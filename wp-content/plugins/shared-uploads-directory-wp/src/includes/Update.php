<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use Puc_v4_Factory;

require SHARED_UPLOADS_DIRECTORY_PLUGIN_PATH . 'plugin-update-checker/plugin-update-checker.php';

class Update
{
  function __construct()
  {
    $updateChecker = Puc_v4_Factory::buildUpdateChecker(
      'https://github.com/sebastiansiejek/shared-uploads-directory-wp/',
      SHARED_UPLOADS_DIRECTORY_PLUGIN_FILE,
      SHARED_UPLOADS_DIRECTORY_PLUGIN_SLUG,
      1
    );

    $updateChecker->getVcsApi()->enableReleaseAssets();
  }
}
