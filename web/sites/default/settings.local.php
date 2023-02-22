<?php

/**
 * @file
 * Local development override configuration feature.
 *
 * To activate this feature, copy and rename it such that its path plus
 * filename is 'sites/default/settings.local.php'. Then, go to the bottom of
 * 'sites/default/settings.php' and uncomment the commented lines that mention
 * 'settings.local.php'.
 *
 * If you are using a site name in the path, such as 'sites/example.com', copy
 * this file to 'sites/example.com/settings.local.php', and uncomment the lines
 * at the bottom of 'sites/example.com/settings.php'.
 */

/**
 * Assertions.
 *
 * The Drupal project primarily uses runtime assertions to enforce the
 * expectations of the API by failing when incorrect calls are made by code
 * under development.
 *
 * @see http://php.net/assert
 * @see https://www.drupal.org/node/2492225
 *
 * If you are using PHP 7.0 it is strongly recommended that you set
 * zend.assertions=1 in the PHP.ini file (It cannot be changed from .htaccess
 * or runtime) on development machines and to 0 in production.
 *
 * @see https://wiki.php.net/rfc/expectations
 */
assert_options(ASSERT_ACTIVE, TRUE);
\Drupal\Component\Assertion\Handle::register();

/**
 * Enable local development services.
 */
#$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/development.services.yml';

/**
 * Show all error messages, with backtrace information.
 *
 * In case the error level could not be fetched from the database, as for
 * example the database connection failed, we rely only on this value.
 */
#$config['system.logging']['error_level'] = 'verbose';

/**
 * Disable CSS and JS aggregation.
 */
#$config['system.performance']['css']['preprocess'] = FALSE;
#$config['system.performance']['js']['preprocess'] = FALSE;

/**
 * Disable the render cache (this includes the page cache).
 *
 * Note: you should test with the render cache enabled, to ensure the correct
 * cacheability metadata is present. However, in the early stages of
 * development, you may want to disable it.
 *
 * This setting disables the render cache by using the Null cache back-end
 * defined by the development.services.yml file above.
 *
 * Do not use this setting until after the site is installed.
 */
#$settings['cache']['bins']['render'] = 'cache.backend.null';

/**
 * Disable caching for migrations.
 *
 * Uncomment the code below to only store migrations in memory and not in the
 * database. This makes it easier to develop custom migrations.
 */
#$settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';

/**
 * Disable Dynamic Page Cache.
 *
 * Note: you should test with Dynamic Page Cache enabled, to ensure the correct
 * cacheability metadata is present (and hence the expected behavior). However,
 * in the early stages of development, you may want to disable it.
 */
#$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';

/**
 * Allow test modules and themes to be installed.
 *
 * Drupal ignores test modules and themes by default for performance reasons.
 * During development it can be useful to install test extensions for debugging
 * purposes.
 */
# $settings['extension_discovery_scan_tests'] = TRUE;

/**
 * Enable access to rebuild.php.
 *
 * This setting can be enabled to allow Drupal's php and database cached
 * storage to be cleared via the rebuild.php page. Access to this page can also
 * be gained by generating a query string from rebuild_token_calculator.sh and
 * using these parameters in a request to rebuild.php.
 */
$settings['rebuild_access'] = FALSE;

/**
 * Skip file system permissions hardening.
 *
 * The system module will periodically check the permissions of your site's
 * site directory to ensure that it is not writable by the website user. For
 * sites that are managed with a version control system, this can cause problems
 * when files in that directory such as settings.php are updated, because the
 * user pulling in the changes won't have permissions to modify files in the
 * directory.
 */
$settings['skip_permissions_hardening'] = TRUE;

/**
 * Private file path
 */
$settings['file_private_path'] = 'sites/default/files/private';

$databases['default']['default'] = array (
  'database' => 'drupal9',
  'username' => 'drupal9',
  'password' => 'drupal9',
  'prefix' => '',
  'host' => 'database',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

/*
 * Environment Indicator config
 */
$config['environment_indicator.indicator']['bg_color'] = '#8E44AD';
$config['environment_indicator.indicator']['fg_color'] = '#efefef';
//$config['environment_indicator.indicator']['name'] = 'PROD';

# Solr config
#$config['search_api.server.gared_solr'] = [
#  'backend_config' => [
#    'connector_config' => [
#      'host' => 'solr-1162.hostedapachesolr.com',
#      'path' => '',
#      'core' => '0niLkUXh6W_garedsports_com',
#      'port' => '80'
#    ],
#  ],
#];
#$config['search_api.server.gared_solr']['backend_config']['connector'] = 'basic_auth';
#$config['search_api.server.gared_solr']['backend_config']['connector_config']['username'] = '1162';
#$config['search_api.server.gared_solr']['backend_config']['connector_config']['password'] = 'mJ7uzxL6scvP';

#$config['search_api.server.gared_solr_files'] = [
#  'backend_config' => [
#    'connector_config' => [
#      'host' => 'solr-1163.hostedapachesolr.com',
#      'path' => '',
#      'core' => 'HxOlA2LJnK_garedsports_com',
#      'port' => '80'
#    ],
#  ],
#];
#$config['search_api.server.gared_solr_files']['backend_config']['connector'] = 'basic_auth';
#$config['search_api.server.gared_solr_files']['backend_config']['connector_config']['username'] = '1163';
#$config['search_api.server.gared_solr_files']['backend_config']['connector_config']['password'] = 'cpaNVCgfE2z4';

/*
 * Split configuration settings
 */
$config['config_split.config_split.dev_config']['status'] = FALSE;
$config['config_split.config_split.production']['status'] = TRUE;
$config['config_split.config_split.webforms']['status'] = TRUE;

/*
 * Memcache settings
 */
#$settings['memcache']['servers'] = ['127.0.0.1:11211' => 'default'];
#$settings['memcache']['bins'] = ['default' => 'default'];
#$settings['memcache']['key_prefix'] = 'gared';
#$settings['cache']['default'] = 'cache.backend.memcache';
