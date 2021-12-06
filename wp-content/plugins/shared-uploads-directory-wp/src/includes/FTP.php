<?php

namespace SharedUploadsDirectoryPlugin\src\includes;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\displayNotice;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;

class FTP
{

  function __construct()
  {
    try {
      $options = getOptions();
      $login = getOption($options, 'ftp_user');
      $password = getOption($options, 'ftp_password');
      $host = getOption($options, 'ftp_host');
      $port = getOption($options, 'ftp_port');
      $ftpConnection = new SftpConnectionProvider($host, $login, $password, null, null, (int)$port);
    } catch (\Throwable $th) {
      displayNotice($th->getMessage());
    }
  }
}
