<?php

/**
 * @file
 * Settings.
 */

// Load services definition file.
$settings['container_yamls'][] = __DIR__ . '/services.yml';

// Include the Pantheon-specific settings file.
include __DIR__ . "/settings.pantheon.php";

// Hard coding config.
$settings['config_sync_directory'] = '../config';

// If there is a local settings file, then include it.
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

// Automatically generated include for settings managed by ddev.
$ddev_settings = dirname(__FILE__) . '/settings.ddev.php';
if (getenv('IS_DDEV_PROJECT') == 'true' && is_readable($ddev_settings)) {
  require $ddev_settings;
}
