<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

class UploadDir
{

  /**
   * Set base URL for the uploads directory
   *
   * @return this
   */
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

    return $this;
  }
}
