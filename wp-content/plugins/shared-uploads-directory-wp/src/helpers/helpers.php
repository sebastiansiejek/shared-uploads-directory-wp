<?php

namespace SharedUploadsDirectoryPlugin\src\admin\helpers;

use SharedUploadsDirectoryPlugin\src\admin\settings\Settings;

/**
 * Get option by key
 *
 * @param array $options
 * @param string $name
 * @return string
 */
function getOption(array $options, string $key)
{
  if (count($options) && isset($options[$key]) && $options[$key]) {
    return $options[$key];
  }

  $constName = 'SUD_' . strtoupper($key);
  return defined($constName) ? constant('SUD_' . strtoupper($key)) : '';
}

/**
 * Get options from database
 *
 * @return array
 */
function getOptions()
{
  return get_option(Settings::slug . "_options") ? get_option(Settings::slug . "_options") : [];
}

function displayNotice($message, string $type = 'error')
{
  return add_action('admin_notices', function () use ($message, $type) {
    require_once SHARED_UPLOADS_DIRECTORY_PLUGIN_PATH . 'src/admin/templates/notice.php';
  });
}


function isImage(string $text)
{
  return strpos($text, 'image/') === 0;
}
