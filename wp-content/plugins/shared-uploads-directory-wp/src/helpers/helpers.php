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
  return count($options) && isset($options[$key]) ? $options[$key] : '';
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
