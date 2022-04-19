<?php

namespace Drupal\media_migration\Utility;

use Drupal\Core\Plugin\PluginBase;

/**
 * Utility for filtering and manipulating migration plugin definitions.
 *
 * @ingroup utility
 */
class MigrationPluginTool {

  /**
   * Creates a source plugin from a plugin ID or from a plugin configuration.
   *
   * @param string|array $source
   *   The source plugin ID, or the configuration of the source plugin.
   *
   * @return \Drupal\migrate\Plugin\MigrateSourceInterface|\Drupal\migrate\Plugin\RequirementsInterface
   *   The fully initialized source plugin.
   *
   * @see \Drupal\migrate\Plugin\MigrationDeriverTrait
   */
  public static function getSourcePlugin($source) {
    $source_config = [
      'ignore_map' => TRUE,
      'plugin' => is_string($source) ? $source : $source['plugin'],
    ];
    if (is_array($source)) {
      $source_config = $source_config + $source;
    }
    $definition = [
      'source' => $source_config,
      'destination' => [
        'plugin' => 'null',
      ],
      'idMap' => [
        'plugin' => 'null',
      ],
    ];
    return \Drupal::service('plugin.manager.migration')
      ->createStubMigration($definition)
      ->getSourcePlugin();
  }

  /**
   * Returns the given migration destination process as an associative array.
   *
   * @param array|string $plugin_process
   *   The plugin process mapping.
   *
   * @return array
   *   The plugin process mapping as an associative array.
   */
  public static function getAssociativeMigrationProcess($plugin_process): array {
    if (!is_array($plugin_process)) {
      $plugin_process = [
        [
          'plugin' => 'get',
          'source' => $plugin_process,
        ],
      ];
    }
    elseif (array_key_exists('plugin', $plugin_process)) {
      $plugin_process = [$plugin_process];
    }

    return $plugin_process;
  }

  /**
   * Finds and returns the content entity migrations from the given migrations.
   *
   * @param array $migrations
   *   The array of migration plugins.
   * @param string $destination_entity_type_id
   *   The ID of the destination entity type.
   * @param bool $exclude_custom_migrations
   *   Whether migrations managed by Migrate Plus should be excluded or not.
   *   Defaults to TRUE.
   *
   * @return array
   *   An array of content entity migration plugin definitions, keyed by their
   *   migration plugin ID.
   */
  public static function getContentEntityMigrations(array $migrations, string $destination_entity_type_id, bool $exclude_custom_migrations = TRUE) :array {
    $entity_destination_plugins = [
      'entity',
      'entity_revision',
      'entity_complete',
      'entity_reference_revisions',
    ];

    return array_filter($migrations, function (array $migration, string $migration_id) use ($entity_destination_plugins, $destination_entity_type_id, $exclude_custom_migrations) {
      // If this is not a Drupal 7 migration, we can skip processing it.
      if (!in_array('Drupal 7', $migration['migration_tags'] ?? [])) {
        return FALSE;
      }

      $destination_parts = explode(PluginBase::DERIVATIVE_SEPARATOR, $migration['destination']['plugin']);
      if (
        count($destination_parts) !== 2 ||
        !in_array($destination_parts[0], $entity_destination_plugins)
      ) {
        return FALSE;
      }

      if ($exclude_custom_migrations) {
        // Exclude migrations instantiated by Migrate Plus. These migrations do
        // have UUID, but don't have 'provider', and their ID begins with
        // 'migration_config_deriver:'.
        // @see \Drupal\migrate_plus\Plugin\MigrationConfigDeriver
        if (
          isset($migration['uuid']) &&
          strpos($migration_id, 'migration_config_deriver' . PluginBase::DERIVATIVE_SEPARATOR) === 0
        ) {
          return FALSE;
        }
      }

      if ($destination_parts[1] === $destination_entity_type_id) {
        return TRUE;
      }

      return FALSE;
    }, ARRAY_FILTER_USE_BOTH);
  }

}
