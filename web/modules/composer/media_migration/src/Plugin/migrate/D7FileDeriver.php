<?php

namespace Drupal\media_migration\Plugin\migrate;

use Drupal\Core\Database\DatabaseExceptionWrapper;
use Drupal\Core\Plugin\PluginBase;
use Drupal\media_migration\MediaMigration;
use Drupal\media_migration\Plugin\migrate\source\d7\ConfigSourceBase;
use Drupal\migrate\Exception\RequirementsException;
use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Deriver class for plain file to media entity migrations.
 *
 * "Plain file" refers to managed files whose "type" column's value (added to
 * the "file_managed" table by the D7 contrib file_entity module) is empty ("")
 * or "undefined"), OR for every managed file when there is no "type" column is
 * defined in the "file_managed" table.
 *
 * This deriver class should be used for the actual plain file to media entity
 * migrations.
 */
class D7FileDeriver extends D7FileConfigDeriver {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $plain_file_types = static::getSourcePlugin('d7_file_plain_type');

    try {
      $plain_file_types->checkRequirements();
    }
    catch (RequirementsException $e) {
      // The requirements of the "d7_file_plain_type" source plugin can fail if:
      // - The source database is not configured
      // - The File module is not enabled on the source Drupal instance
      // - The source database is not a Drupal 7 database.
      return $this->derivatives;
    }

    assert($plain_file_types instanceof DrupalSqlBase);

    try {
      foreach ($plain_file_types as $plain_file_type_row) {
        assert($plain_file_type_row instanceof Row);
        [
          'mimes' => $mimes,
          'schemes' => $schemes,
        ] = $plain_file_type_row->getSource();

        foreach (explode(ConfigSourceBase::MULTIPLE_SEPARATOR, $mimes) as $mime) {
          foreach (explode(ConfigSourceBase::MULTIPLE_SEPARATOR, $schemes) as $scheme) {
            // The "fallback" plugin has to be instantiated for any kind of
            // combination.
            if (!($dealer_plugin = $this->fileDealerManager->createInstanceFromSchemeAndMime($scheme, $mime))) {
              throw new \LogicException(sprintf('No FileDealer plugin applies for files with scheme "%s" and with mime type "%s/*"', $scheme, $mime));
            }
            $destination_media_type_id = $dealer_plugin->getDestinationMediaTypeId();
            $derivative_id = implode(PluginBase::DERIVATIVE_SEPARATOR, [
              $mime,
              $scheme,
            ]);
            $derivative_definition = $base_plugin_definition;
            // Create the migration derivative.
            $derivative_definition['migration_tags'][] = MediaMigration::MIGRATION_TAG_MAIN;
            $derivative_definition['migration_tags'][] = MediaMigration::MIGRATION_TAG_CONTENT;
            $derivative_definition['source']['mime'] = $mime;
            $derivative_definition['source']['scheme'] = $scheme;
            $derivative_definition['source']['destination_media_type_id'] = $destination_media_type_id;
            $derivative_definition['label'] = $this->t('@label (@type)', [
              '@label' => $base_plugin_definition['label'],
              '@type' => $dealer_plugin->getDestinationMediaTypeLabel(),
            ]);

            // Post-process migration dependencies: instead of depending on
            // migrations based on their base plugin ID, it is better to use the
            // corresponding derivatives where possible.
            $derived_migration_ids = [
              'd7_file_plain_type',
              'd7_file_plain_source_field',
              'd7_file_plain_source_field_config',
              'd7_file_plain_widget',
              'd7_file_plain_formatter',
            ];
            foreach ($derived_migration_ids as $derived_migration_base_id) {
              $required_dependencies = !empty($derivative_definition['migration_dependencies']['required'])
                ? $derivative_definition['migration_dependencies']['required']
                : [];
              $dependency_key = array_search($derived_migration_base_id, $required_dependencies, TRUE);
              if ($dependency_key !== FALSE) {
                $derivative_definition['migration_dependencies']['required'][$dependency_key] .= PluginBase::DERIVATIVE_SEPARATOR . $destination_media_type_id;
              }
            }

            // Add the corresponding file migration as migration dependency.
            switch ($scheme) {
              case 'public':
                $derivative_definition['migration_dependencies']['required'][] = 'd7_file';
                break;

              case 'private':
                $derivative_definition['migration_dependencies']['required'][] = 'd7_file_private';
                break;
            }

            if ($derivative_definition['source']['plugin'] === 'd7_file_plain') {
              $dealer_plugin->alterMediaEntityMigrationDefinition($derivative_definition, $plain_file_types->getDatabase());
            }

            $this->derivatives[$derivative_id] = $derivative_definition;
          }
        }
      }
    }
    catch (DatabaseExceptionWrapper $e) {
      // Once we begin iterating the source plugin it is possible that the
      // source tables will not exist. This can happen when the
      // MigrationPluginManager gathers up the migration definitions but we do
      // not actually have a Drupal 7 source database.
    }

    return $this->derivatives;
  }

}
