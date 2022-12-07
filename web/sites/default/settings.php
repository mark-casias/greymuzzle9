<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

// Hard coding config.
$settings['config_sync_directory'] = '../config';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all environments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to ensure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * Skipping permissions hardening will make scaffolding
 * work better, but will also raise a warning when you
 * install Drupal.
 *
 * https://www.drupal.org/project/drupal/issues/3091285
 */
// $settings['skip_permissions_hardening'] = TRUE;

// Set up Migration from Secrets file.
$secretsFile = $_SERVER['HOME'] . '/files/private/secrets.json';
if (file_exists($secretsFile)) {
 $secrets = json_decode(file_get_contents($secretsFile), 1);
}

if (!empty($secrets['port']) && !empty($secrets['host']) && !empty($secrets['pass'])) {
  $databases['migrate']['default'] = [
    'database' => 'migrate',
    'username' => 'pantheon',
    'password' => $secrets['pass'],
    'host' => $secrets['host'],
    'port' => $secrets['port'],
    'driver' => 'mysql',
    'prefix' => '',
    'collation' => 'utf8mb4_general_ci',
  ];
}

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

// Automatically generated include for settings managed by ddev.
$ddev_settings = dirname(__FILE__) . '/settings.ddev.php';
if (getenv('IS_DDEV_PROJECT') == 'true' && is_readable($ddev_settings)) {
  require $ddev_settings;
}

