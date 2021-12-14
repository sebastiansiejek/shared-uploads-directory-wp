<?php

namespace SharedUploadsDirectoryPlugin\src\admin\settings;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

class FieldsCreator
{
  const optionsName = Settings::slug . "_options";

  function createInput(string $name, string $title, string $group, string $type = 'text')
  {
    return add_settings_field(Settings::slug . '_' . $name, __($title, Settings::slug), function () use ($name, $type) {
      $value = getOption(getOptions(), $name);
      $nameAttr = esc_attr(FieldsCreator::optionsName . "[{$name}]");
      echo "<input type='{$type}' name='{$nameAttr}' value='{$value}'  />";
    }, Settings::slug, Settings::slug . '_' . $group);
  }
}
