<?php

namespace SharedUploadsDirectoryPlugin\src\admin\settings;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\displayNotice;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

class Settings
{
  const name = 'Shared Uploads Directory';
  const slug = 'shared_uploads_directory';

  function __construct()
  {
    add_action('admin_menu', function () {
      (new SettingsPage())->add();
    });

    add_action('admin_init', function () {
      $this->addSettings();
    });

    $this->addLinksOnPluginsList();
  }

  function addSettings()
  {
    register_setting(Settings::slug . "_options", Settings::slug . "_options");
    add_settings_section(Settings::slug . '_ftp_settings', __(Settings::name, Settings::slug), '', Settings::slug);
    $fieldsCreator = new FieldsCreator();

    if (!defined('SUD_FTP_HOST')) {
      $fieldsCreator->createInput('ftp_host', 'FTP HOST', 'ftp_settings');
    }

    if (!defined('SUD_FTP_PORT')) {
      $fieldsCreator->createInput('ftp_port', 'FTP PORT', 'ftp_settings', 'number');
    }

    if (!defined('SUD_FTP_USER')) {
      $fieldsCreator->createInput('ftp_user', 'FTP LOGIN', 'ftp_settings');
    }

    if (!defined('SUD_FTP_PASSWORD')) {
      $fieldsCreator->createInput('ftp_password', 'FTP PASSWORD', 'ftp_settings');
    }

    if (!defined('SUD_FTP_DIRECTORY')) {
      $fieldsCreator->createInput('ftp_directory', 'FTP DIRECTORY', 'ftp_settings');
    }

    if (!defined('SUD_FTP_CDN')) {
      $fieldsCreator->createInput('ftp_cdn', 'CDN', 'ftp_settings');
    }
  }

  private function addLinksOnPluginsList()
  {
    add_filter(
      'plugin_action_links_' . SHARED_UPLOADS_DIRECTORY_PLUGIN_BASENAME,
      function (array $links) {
        $slug = Settings::slug;

        $url = get_admin_url() . "admin.php?page={$slug}";
        $settingLink = '<a href="' . $url . '">' . __('Settings', 'textdomain') . '</a>';

        $links[] = $settingLink;

        return $links;
      }
    );

    return $this;
  }

  static function isRequiredSettings()
  {
    $options = getOptions();
    $name = Settings::name . ": ";

    $user = getOption($options, "ftp_user");
    if (!$user) {
      displayNotice(__("{$name} FTP user is required", Settings::slug));
      return false;
    }

    $password = getOption($options, "ftp_password");
    if (!$password) {
      displayNotice(__("{$name} FTP password is required", Settings::slug));
      return false;
    }

    $host = getOption($options, "ftp_host");
    if (!$host) {
      displayNotice(__("{$name} FTP host is required", Settings::slug));
      return false;
    }

    $port = getOption($options, "ftp_port");
    if (!$port) {
      displayNotice(__("{$name} FTP port is required", Settings::slug));
      return false;
    }

    $cdn = getOption($options, "ftp_cdn");
    if (!$cdn) {
      displayNotice(__("{$name} CDN is required", Settings::slug));
      return false;
    }

    $directory = getOption($options, "ftp_directory");
    if (!$directory) {
      displayNotice(__("{$name} FTP directory is required", Settings::slug));
      return false;
    }

    return true;
  }
}
