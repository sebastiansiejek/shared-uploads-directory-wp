<?php

namespace SharedUploadsDirectoryPlugin\src\includes\HandleUpload;

use SharedUploadsDirectoryPlugin\src\includes\FTP;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\isImage;

class HandleUpload
{

  function __construct()
  {
    $this->handleFile();
    $this->handleImage();
  }

  /**
   * Handling files
   *
   * @return this
   */
  private function handleFile()
  {
    add_filter('wp_handle_upload', function ($upload) {
      $ftp = new FTP();
      $ftp->uploadFile($upload['file']);

      return $upload;
    }, 10, 2);

    return $this;
  }

  /**
   * Handling generated images
   *
   * @return this
   */
  private function handleImage()
  {
    add_filter('wp_generate_attachment_metadata', function ($upload) {
      if ($upload && is_array($upload) && count($upload) > 0 && !isset($upload['mime_type'])) {
        $uploadDir = wp_upload_dir();
        $uploadCurrentDatePath = $uploadDir['path'] . '/';
        $file = $upload['file'];
        $ftp = new FTP();


        // Upload generated images
        if (isset($upload['sizes']) && count($upload['sizes']) > 0) {
          $sizes = $upload['sizes'];

          foreach ($sizes as $size) {
            $file = $size['file'];
            $ftp->uploadFile($uploadCurrentDatePath . $file);
          }
        }
      }

      return $upload;
    }, 10, 2);

    return $this;
  }
}
