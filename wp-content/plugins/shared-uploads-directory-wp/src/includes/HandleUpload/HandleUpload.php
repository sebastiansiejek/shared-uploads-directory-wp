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
   * Handling files upload except images
   *
   * @return this
   */
  private function handleFile()
  {
    add_filter('wp_handle_upload', function ($upload) {
      $type = $upload['type'];
      $ftp = new FTP();

      if (!isImage($type)) {
        $ftp->uploadFile($upload['file']);
      }

      return $upload;
    }, 10, 2);

    return $this;
  }

  /**
   * Handling images upload
   *
   * @return this
   */
  private function handleImage()
  {
    add_filter('wp_generate_attachment_metadata', function ($upload) {
      if ($upload && is_array($upload) && count($upload) > 0 && !isset($upload['mime_type'])) {
        $uploadDir = wp_upload_dir();
        $uploadCurrentDatePath = $uploadDir['path'] . '/';
        $baseUploadDir = $uploadDir['basedir'] . '/';
        $file = $upload['file'];
        $ftp = new FTP();

        // Upload original image
        $ftp->uploadFile($baseUploadDir . $file);

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
