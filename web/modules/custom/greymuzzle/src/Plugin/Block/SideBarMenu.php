<?php

namespace Drupal\greymuzzle\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Menu\MenuTreeParameters;
use \Drupal\Core\Url;

/**
 * Provides a SideMenuBlock.
 *
 * @Block(
 *   id = "sidebar_menu_block",
 *   admin_label = @Translation("Sidebar Menu Block"),
 *   category = @Translation("Custom"),
 * )
 */
class SideBarMenu extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $menu_link_manager = \Drupal::service('plugin.manager.menu.link');
    $node = \Drupal::routeMatch()->getParameter('node');
    // If we are not on a node route, get out.
    if ($node) {
      $node_id = $node->id();
      if ($node_id) {
        $menu_links = $menu_link_manager->loadLinksByRoute('entity.node.canonical', ['node' => $node_id]);
      }
      else {
        return [];
      }
    }
    else {
      $term = \Drupal::routeMatch()->getParameter('taxonomy_term');
      if ($term) {
        $tid = $term->id();
        $menu_links = $menu_link_manager->loadLinksByRoute('entity.taxonomy_term.canonical', [
        'taxonomy_term' => $tid]);
        // Do the thing with a term id.
      }
    }

    if ($node && !$menu_links) {
      // No menu item.. lets see if we can find one from the parent.
      $alias = \Drupal::service('path_alias.manager')->getAliasByPath('/node/'. $node->id());
      $parts = explode('/', $alias);
      $newAlias = $parts[1];
      $alias = \Drupal::service('path_alias.manager')->getPathByAlias('/' . $newAlias);
      $params = Url::fromUri("internal:" . $alias)->getRouteParameters();
      $entity_type = key($params);
      $node = \Drupal::entityTypeManager()->getStorage($entity_type)->load($params[$entity_type]);

      $menu_links = $this->get_menu_link($node);
    }

    $menu_link = NULL;
    if (is_array($menu_links) && count($menu_links)) {
      $menu_link = reset($menu_links);
      if ($menu_link->getParent()) {
        $parents = $menu_link_manager->getParentIds($menu_link->getParent());
        $parent = end($parents);
        $build['title'] = $menu_link_manager->createInstance($parent)->getTitle();
      }
    }

    $params = new MenuTreeParameters();
    $params->setRoot($parent);
    $params->setMaxDepth(2);
    if ($menu_link) {
      $params->setActiveTrail([$parent, $menu_link->getPluginId()]);
    }
    $menu_tree = \Drupal::menuTree();
    $tree = $menu_tree->load($parent, $params);

    // Transform the tree using the manipulators you want.
    $manipulators = [
      // Only show links that are accessible for the current user.
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      // Use the default sorting of menu links.
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];
    $tree = $menu_tree->transform($tree, $manipulators);

    $element = $menu_tree->build($tree);
    $build['items'] = $element['#items'][$parent]['below'];

    if (empty($build['#cache']['contexts'])) {
      $build['#cache']['contexts'] = ['user.permissions'];
      $build['#cache']['tags'] = ['config:system.menu.main'];
    }

    return $build;
  }

}