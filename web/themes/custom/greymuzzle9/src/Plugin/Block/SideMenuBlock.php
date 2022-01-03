<?php

namespace Drupal\greymuzzle9\Plugin\Block;

use Drupal\menu_block\Plugin\Block\MenuBlock;
use Drupal\Core\Menu\MenuTreeParameters;

/**
 * Provides a SideMenuBlock.
 *
 * @Block(
 *   id = "side_menu_block",
 *   admin_label = @Translation("Side Menu Block"),
 *   category = @Translation("Custom"),
 * )
 */
class SideMenuBlock extends MenuBlock {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');

    // If we are not on a node route, get out.
    if (!$node) {
      return parent::build();
    }

    $build = parent::build();

    $menu_link_manager = \Drupal::service('plugin.manager.menu.link');
    $node_id = $node->id();
    if ($node_id) {
      $menu_link = $menu_link_manager->loadLinksByRoute('entity.node.canonical', ['node' => $node_id]);
    }
    else {
      return '';
    }
    if (is_array($menu_link) && count($menu_link)) {
      $menu_link = reset($menu_link);
      if ($menu_link->getParent()) {
        $parents = $menu_link_manager->getParentIds($menu_link->getParent());
        $parent = reset(array_reverse($parents));
        $build['title'] = $menu_link_manager->createInstance($parent)->getTitle();
      }
    }

    $params = new MenuTreeParameters();

    $params->setRoot($parent);
    $params->setActiveTrail([$parent, reset($menu_links)->getPluginId()]);
    $tree = $this->menuTree->load($parent, $params);

    // Transform the tree using the manipulators you want.
    $manipulators = [
      // Only show links that are accessible for the current user.
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      // Use the default sorting of menu links.
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];
    $tree = $this->menuTree->transform($tree, $manipulators);

    $element = $this->menuTree->build($tree);
    $build['#items'] = $element['#items'][$parent]['below'];

    if (empty($build['#cache']['contexts'])) {
      $build['#cache']['contexts'] = ['user.permissions'];
      $build['#cache']['tags'] = ['config:system.menu.main'];
    }

    return $build;
  }

}
