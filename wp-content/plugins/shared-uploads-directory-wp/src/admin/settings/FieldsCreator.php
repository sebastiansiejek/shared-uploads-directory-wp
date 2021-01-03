<?php

namespace SharedUploadsDirectoryPlugin\src\admin\settings;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;

class FieldsCreator
{
  const optionsName = Settings::slug . "_options";

  function createInput(string $name, string $title, string $group)
  {
    return add_settings_field(Settings::slug . '_' . $name, __($title, Settings::slug), function () use ($name) {
      $value = getOption($name);
      $nameAttr = esc_attr(FieldsCreator::optionsName . "[{$name}]");
      echo "<input type='text' name='{$nameAttr}' value='{$value}'  />";
    }, Settings::slug, Settings::slug . '_' . $group);
  }
}
