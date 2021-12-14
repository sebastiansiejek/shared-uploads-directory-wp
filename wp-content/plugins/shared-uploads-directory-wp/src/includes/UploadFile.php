<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use League\Flysystem\Filesystem;
use League\Flysystem\PhpseclibV2\SftpAdapter;

class UploadFile
{

  /**
   * Upload file to the remote FTP server
   */
  function upload(string $fileDirectory, SftpAdapter $destinationPath)
  {
    try {
      $handleFile = fopen($fileDirectory, 'r');
      $explodePath = explode("/uploads", $fileDirectory);
      $fileDirectoryWithName = $explodePath[1];
      (new Filesystem($destinationPath))->writeStream($fileDirectoryWithName, $handleFile);
    } catch (\Throwable $th) {
      var_dump($th->getMessage());
    }
  }
}
