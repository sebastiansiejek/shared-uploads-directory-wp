<?php

namespace SharedUploadsDirectoryPlugin\src\includes\HandleUpload;

use SharedUploadsDirectoryPlugin\src\includes\FTP;
use SharedUploadsDirectoryPlugin\src\includes\UploadFile;

class HandleUpload
{

  function __construct()
  {
    add_filter('wp_handle_upload', function ($upload) {
      $type = $upload['type'];
      $isImage = strpos($type, 'image/') === 0;
      $ftp = new FTP();
      $uploadFile = new UploadFile($ftp);

      if (!$isImage) {
        $uploadFile->upload($upload['file']);
      }

      return $upload;
    }, 10, 2);
  }
}
