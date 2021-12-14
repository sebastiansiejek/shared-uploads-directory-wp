<?php

/**
 * Plugin Name:       Shared Uploads Directory Plugin
 * Plugin URI:        https://github.com/sebastiansiejek/shared-uploads-directory-wp
 * Description:       Plugin keeps /uploads directory on remote server.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Sebastian Siejek
 * Author URI:        https://sebastiansiejek.dev
 * Text Domain:       shared-uploads-directory-wp
 * Domain Path:       /languages
 */

require_once 'vendor/autoload.php';

use SharedUploadsDirectoryPlugin\src\admin\settings\Settings;
use SharedUploadsDirectoryPlugin\src\admin\settings\SettingsPage;
use SharedUploadsDirectoryPlugin\src\includes\FTP;
use SharedUploadsDirectoryPlugin\src\includes\HandleUpload\HandleUpload;
use SharedUploadsDirectoryPlugin\src\includes\UploadDir;

define('SHARED_UPLOADS_DIRECTORY_PLUGIN_PATH', __DIR__ . '/');
define('SHARED_UPLOADS_DIRECTORY_PLUGIN_BASENAME', plugin_basename(__FILE__));

if (is_admin()) {
  new Settings();
}

$settingsPage = new SettingsPage();
if ($settingsPage->isCurrentPage()) {
  (new FTP())->getConnection();
}

new HandleUpload();
(new UploadDir())->setBaseURL();
