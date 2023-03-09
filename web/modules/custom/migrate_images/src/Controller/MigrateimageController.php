<?php

namespace Drupal\migrate_images\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class MigrateimageController.
 */
class MigrateimageController extends ControllerBase {

  /**
   * Migrateimage.
   */
  public function migrateimage() {
    /** @var \Drupal\Core\KeyValueStore\KeyValueFactoryInterface $key_value_factory */
    $key_value_factory = \Drupal::service('keyvalue');
    $field_map_kv_store = $key_value_factory->get('entity.definitions.bundle_field_map');
    $comment_map = $field_map_kv_store->get('comment');
    // Remove the field_dates field from the bundle field map for the page bundle.
    unset($comment_map['comment_body']['bundles']['comment_node_always_in_my_hear']);
    $field_map_kv_store->set('comment', $comment_map);

  }

}
