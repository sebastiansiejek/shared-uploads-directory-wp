<?php

/**
 * Plugin Name:       Shared Uploads Directory Plugin
 * Plugin URI:        https://github.com/sebastiansiejek/shared-uploads-directory-wp
 * Description:       Plugin keeps /uploads directory on remote server.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sebastian Siejek
 * Author URI:        https://sebastiansiejek.dev
 * Text Domain:       shared-uploads-directory-wp
 * Domain Path:       /languages
 */

require_once 'vendor/autoload.php';

use SharedUploadsDirectoryPlugin\src\admin\remoteUpload\RemoteUpload;
use SharedUploadsDirectoryPlugin\src\admin\settings\Settings;

define('SUD_PLUGIN_ROOT_DIR', plugin_dir_path(__FILE__));

if (is_admin()) {
  new Settings();
}

(new RemoteUpload())->init();
