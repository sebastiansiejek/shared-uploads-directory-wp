<?php

/**
 * Plugin Name:       Shared Uploads Directory Plugin
 * Plugin URI:        https://github.com/sebastiansiejek/shared-uploads-directory-wp
 * Description:       Plugin keeps /uploads directory on remote server.
 * Version:           1.0.5
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Sebastian Siejek
 * Author URI:        https://sebastiansiejek.dev
 * Text Domain:       shared-uploads-directory-wp
 * Domain Path:       /languages
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/shared-uploads-directory-wp/vendor/autoload.php';

use SharedUploadsDirectoryPlugin\src\admin\settings\Settings;
use SharedUploadsDirectoryPlugin\src\admin\settings\SettingsPage;
use SharedUploadsDirectoryPlugin\src\includes\FTP;
use SharedUploadsDirectoryPlugin\src\includes\HandleUpload\HandleUpload;
use SharedUploadsDirectoryPlugin\src\includes\Update;
use SharedUploadsDirectoryPlugin\src\includes\UploadDir;

define('SHARED_UPLOADS_DIRECTORY_PLUGIN_SLUG', 'shared-uploads-directory-wp');
define('SHARED_UPLOADS_DIRECTORY_PLUGIN_PATH', __DIR__ . '/');
define('SHARED_UPLOADS_DIRECTORY_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('SHARED_UPLOADS_DIRECTORY_PLUGIN_FILE', __FILE__);

if (is_admin()) {
  new Update();
  new Settings();
}

if (Settings::isRequiredSettings()) {
  $settingsPage = new SettingsPage();

  if ($settingsPage->isCurrentPage()) {
    (new FTP())->getConnection();
  }

  new HandleUpload();
  (new UploadDir())->setBaseURL();
}
