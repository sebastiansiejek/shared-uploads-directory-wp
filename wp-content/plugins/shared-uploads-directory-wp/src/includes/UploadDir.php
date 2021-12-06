<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

class UploadDir
{

  function setBaseURL()
  {
    add_filter(
      'upload_dir',
      function ($args) {

        $options = getOptions();
        $cdn = getOption($options, 'ftp_cdn');

        if ($cdn) {
          $args['baseurl'] = $cdn;
        }

        return $args;
      }
    );
  }
}
