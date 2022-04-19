<?php

namespace Drupal\Tests\media_migration\Traits;

use Drupal\Core\Database\Database;

/**
 * Trait for importing custom data into the migrate source database.
 */
trait MediaMigrationTestDatabaseTrait {

  /**
   * Changes the database connection to the prefixed one.
   *
   * @see \Drupal\Tests\migrate\Kernel\MigrateTestBase::createMigrationConnection()
   *
   * @todo Refactor when core don't use global.
   *   https://www.drupal.org/node/2552791
   */
  protected function createSourceMigrationConnection() {
    // If the backup already exists, something went terribly wrong.
    // This case is possible, because database connection info is a static
    // global state construct on the Database class, which at least persists
    // for all test methods executed in one PHP process.
    if (Database::getConnectionInfo('simpletest_original_migrate')) {
      throw new \RuntimeException("Bad Database connection state: 'simpletest_original_migrate' connection key already exists. Broken test?");
    }

    // Clone the current connection and replace the current prefix.
    $connection_info = Database::getConnectionInfo('migrate');
    if ($connection_info) {
      Database::renameConnection('migrate', 'simpletest_original_migrate');
    }
    $connection_info = Database::getConnectionInfo('default');
    foreach ($connection_info as $target => $value) {
      $prefix = is_array($value['prefix']) ? $value['prefix']['default'] : $value['prefix'];
      // Simpletest uses 7 character prefixes at most so this can't cause
      // collisions.
      $connection_info[$target]['prefix']['default'] = $prefix . '0';

      // Add the original simpletest prefix so SQLite can attach its database.
      // @see \Drupal\Core\Database\Driver\sqlite\Connection::init()
      $connection_info[$target]['prefix'][$value['prefix']['default']] = $value['prefix']['default'];
    }
    Database::addConnectionInfo('migrate', 'default', $connection_info['default']);
  }

  /**
   * Loads a database fixture into the source database connection.
   *
   * @param array $database
   *   The source data, keyed by table name. Each table is an array containing
   *   the rows in that table.
   */
  protected function importSourceDatabase(array $database): void {
    // Create the tables and fill them with data.
    foreach ($database as $table => $rows) {
      // Use the biggest row to build the table schema.
      $counts = array_map('count', $rows);
      asort($counts);
      end($counts);
      $pilot = $rows[key($counts)];
      $schema = array_map(function ($value) {
        $type = is_numeric($value) && !is_float($value + 0)
          ? 'int'
          : 'text';
        return ['type' => $type];
      }, $pilot);

      $this->sourceDatabase->schema()
        ->createTable($table, [
          'fields' => $schema,
        ]);

      $fields = array_keys($pilot);
      $insert = $this->sourceDatabase->insert($table)->fields($fields);
      array_walk($rows, [$insert, 'values']);
      $insert->execute();
    }
  }

  /**
   * Cleans up the test migrate connection.
   *
   * @see \Drupal\Tests\migrate\Kernel\MigrateTestBase::cleanupMigrateConnection()
   *
   * @todo Refactor when core don't use global.
   *   https://www.drupal.org/node/2552791
   */
  private function cleanupSourceMigrateConnection() {
    Database::removeConnection('migrate');
    $original_connection_info = Database::getConnectionInfo('simpletest_original_migrate');
    if ($original_connection_info) {
      Database::renameConnection('simpletest_original_migrate', 'migrate');
    }
  }

}
