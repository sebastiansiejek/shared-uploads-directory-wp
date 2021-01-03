<?php

namespace SharedUploadsDirectoryPlugin\src\admin\helpers;

use SharedUploadsDirectoryPlugin\src\admin\settings\Settings;

function getOption(string $name)
{
  $optionsName = Settings::slug . "_options";
  return isset(get_option($optionsName)[$name]) ? get_option($optionsName)[$name] : '';
}
