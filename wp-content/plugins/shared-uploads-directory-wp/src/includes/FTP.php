<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\displayNotice;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

use League\Flysystem\PhpseclibV2\SftpAdapter;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;

class FTP
{

  function getConnection()
  {
    try {
      $options = getOptions();
      $login = getOption($options, 'ftp_user');
      $password = getOption($options, 'ftp_password');
      $host = getOption($options, 'ftp_host');
      $port = getOption($options, 'ftp_port');
      $ftpConnection = new SftpConnectionProvider($host, $login, $password, null, null, (int)$port);
      return $ftpConnection;
    } catch (\Throwable $th) {
      displayNotice($th->getMessage());
    }
  }

  /**
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
}
