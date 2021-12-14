<?php

namespace SharedUploadsDirectoryPlugin\src\admin\settings;

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
    $fieldsCreator->createInput('ftp_host', 'FTP HOST', 'ftp_settings');
    $fieldsCreator->createInput('ftp_port', 'FTP PORT', 'ftp_settings');
    $fieldsCreator->createInput('ftp_user', 'FTP LOGIN', 'ftp_settings');
    $fieldsCreator->createInput('ftp_password', 'FTP PASSWORD', 'ftp_settings');
    $fieldsCreator->createInput('ftp_directory', 'FTP DIRECTORY', 'ftp_settings');
    $fieldsCreator->createInput('ftp_cdn', 'CDN', 'ftp_settings');
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
}
