<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\displayNotice;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

use League\Flysystem\PhpseclibV2\SftpAdapter;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;

class FTP
{

  /**
   * Get connection to remote FTP server
   *
   * @return \League\Flysystem\PhpseclibV2\SftpConnectionProvider
   */
  function getConnection()
  {
    try {
      $options = getOptions();
      $login = getOption($options, 'ftp_user');
      $password = getOption($options, 'ftp_password');
      $host = getOption($options, 'ftp_host');
      $port = getOption($options, 'ftp_port');
      $ftpConnection = new SftpConnectionProvider($host, $login, $password, null, null, (int)$port);
      $ftpConnection->provideConnection();
      return $ftpConnection;
    } catch (\Throwable $th) {
      displayNotice($th->getMessage());
    }
  }

  /**
   * Get adapter for remote FTP server
   *
   * @return SftpAdapter
   */
  function getDirectory(string $path = "/"): SftpAdapter
  {
    $options = getOptions();
    $baseDirectory = getOption($options, 'ftp_directory');

    try {
      return (new SftpAdapter($this->getConnection(), $baseDirectory . $path));
    } catch (\Throwable $th) {
      displayNotice($th->getMessage());
    }
  }

  /**
   * Upload file to the FTP server
   *
   * @param void
   */
  function uploadFile(string $fileDirectory)
  {
    return (new UploadFile($this->getConnection()))->upload($fileDirectory,  $this->getDirectory());
  }
}
