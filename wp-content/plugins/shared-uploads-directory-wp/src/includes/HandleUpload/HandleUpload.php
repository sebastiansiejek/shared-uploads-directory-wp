<?php

namespace SharedUploadsDirectoryPlugin\src\includes\HandleUpload;

use SharedUploadsDirectoryPlugin\src\includes\FTP;
use SharedUploadsDirectoryPlugin\src\includes\UploadFile;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\isImage;

class HandleUpload
{

  function __construct()
  {
    $this->handleFile();
    $this->handleImage();
  }

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

  private function handleImage()
  {
    add_filter('wp_generate_attachment_metadata', function ($upload) {

      if (isset($upload['sizes']) && isImage($upload['sizes']['thumbnail']['mime-type'])) {
        $uploadDir = wp_upload_dir();
        $uploadCurrentDatePath = $uploadDir['path'] . '/';
        $baseUploadDir = $uploadDir['basedir'] . '/';
        $file = $upload['file'];
        $sizes = $upload['sizes'];
        $ftp = new FTP();
        $ftp->uploadFile($baseUploadDir . $file);

        foreach ($sizes as $size) {
          $file = $size['file'];
          $ftp->uploadFile($uploadCurrentDatePath . $file);
        }
      }

      return $upload;
    }, 10, 2);

    return $this;
  }
}
