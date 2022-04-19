<?php

namespace Drupal\views;

use Drupal\system\PathBasedBreadcrumbBuilder;
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatch;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class to define the menu_link breadcrumb builder.
 */
class ViewsBreadcrumbBuilder extends PathBasedBreadcrumbBuilder {

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    $path = trim($this->context->getPathInfo(), '/');
    $path_elements = explode('/', $path);

    while (count($path_elements) > 1) {
      array_pop($path_elements);
      // Copy the path elements for up-casting.
      $route_request = $this->getRequestForPath('/' . implode('/', $path_elements), []);
      if ($route_request) {
        $route_match = RouteMatch::createFromRequest($route_request);
        $view_id = $route_match->getParameter('view_id');
        if (isset($view_id)) {
          return TRUE;
        }
      }
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $links = [];

    // Add the url.path.parent cache context. This code ignores the last path
    // part so the result only depends on the path parents.
    $breadcrumb->addCacheContexts(['url.path.parent', 'url.path.is_front']);

    // Do not display a breadcrumb on the frontpage.
    if ($this->pathMatcher->isFrontPage()) {
      return $breadcrumb;
    }

    // General path-based breadcrumbs. Use the actual request path, prior to
    // resolving path aliases, so the breadcrumb can be defined by simply
    // creating a hierarchy of path aliases.
    $path = trim($this->context->getPathInfo(), '/');
    $path_elements = explode('/', $path);
    $exclude = [];
    // Don't show a link to the front-page path.
    $front = $this->config->get('page.front');
    $exclude[$front] = TRUE;
    // /user is just a redirect, so skip it.
    // @todo Find a better way to deal with /user.
    $exclude['/user'] = TRUE;
    while (count($path_elements) > 1) {
      array_pop($path_elements);
      // Copy the path elements for up-casting.
      $route_request = $this->getRequestForPath('/' . implode('/', $path_elements), $exclude);
      if ($route_request) {
        $route_match = RouteMatch::createFromRequest($route_request);
        $access = $this->accessManager->check($route_match, $this->currentUser, NULL, TRUE);
        // The set of breadcrumb links depends on the access result, so merge
        // the access result's cacheability metadata.
        $breadcrumb = $breadcrumb->addCacheableDependency($access);
        if ($access->isAllowed()) {
          $view_id = $route_match->getParameter('view_id');
          if (isset($view_id)) {

            $display_id = $route_match->getParameter('display_id');

            $args = $this->getRouteArguments($route_match);
            $name = __METHOD__ . ":$view_id:$display_id";
            if ($args) {
              $name .= ':' . implode(':', $args);
            }

            $title = &drupal_static($name);
            if (!$title) {
              /** @var \Drupal\views\ViewExecutable $view */
            $view = Views::getView($view_id);
            if ($args) {
              $view->setArguments($args);
            }
            $view->setDisplay($display_id);
            $view->buildTitle();
            $title = $view->getBreadcrumbTitle();
            }

          }
          else {
            $title = $this->titleResolver->getTitle($route_request, $route_match->getRouteObject());
          }

          if (!isset($title)) {
            // Fallback to using the raw path component as the title if the
            // route is missing a _title or _title_callback attribute.
            $title = str_replace(['-', '_'], ' ', Unicode::ucfirst(end($path_elements)));
          }

          $url = Url::fromRouteMatch($route_match);
          $links[] = new Link($title, $url);
        }
      }
    }

    // Add the Home link.
    $links[] = Link::createFromRoute($this->t('Home'), '<front>');

    return $breadcrumb->setLinks(array_reverse($links));
  }

  /**
   * Copy of ViewPageController::getRouteArguments
   * Get the current view route arguments.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @return array
   *   The route arguments.
   */
  protected function getRouteArguments(RouteMatchInterface $route_match) {
    $args = [];
    $route = $route_match->getRouteObject();
    $map = $route->hasOption('_view_argument_map') ? $route->getOption('_view_argument_map') : [];

    foreach ($map as $attribute => $parameter_name) {
      // Allow parameters be pulled from the request.
      // The map stores the actual name of the parameter in the request. Views
      // which override existing controller, use for example 'node' instead of
      // arg_nid as name.
      if (isset($map[$attribute])) {
        $attribute = $map[$attribute];
      }
      if ($arg = $route_match->getRawParameter($attribute)) {
      }
      else {
        $arg = $route_match->getParameter($attribute);
      }

      if (isset($arg)) {
        $args[] = $arg;
      }
    }
    return $args;
  }

}
