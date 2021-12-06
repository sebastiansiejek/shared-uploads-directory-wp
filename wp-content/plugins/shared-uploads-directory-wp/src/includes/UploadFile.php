<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use League\Flysystem\Filesystem;
use SharedUploadsDirectoryPlugin\src\includes\FTP;

class UploadFile
{
  private FTP $_ftp;

  function __construct(FTP $ftp)
  {
    $this->_ftp = $ftp;
  }

  function upload(string $fileDirectory)
  {
    try {
      $handleFile = fopen($fileDirectory, 'r');
      $explodePath = explode("/uploads", $fileDirectory);
      $fileDirectoryWithName = $explodePath[1];
      (new Filesystem($this->_ftp->getDirectory()))->writeStream($fileDirectoryWithName, $handleFile);
    } catch (\Throwable $th) {
      var_dump($th->getMessage());
    }
  }
}
