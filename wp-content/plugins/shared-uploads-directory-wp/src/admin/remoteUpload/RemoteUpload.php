<?php

namespace SharedUploadsDirectoryPlugin\src\admin\remoteUpload;

use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOption;
use function SharedUploadsDirectoryPlugin\src\admin\helpers\getOptions;

class RemoteUpload
{
  function init()
  {
    $config = getOptions();
    $host = getOption($config, 'ftp_host');
    $user = getOption($config, 'ftp_user');
    $port = getOption($config, 'ftp_port');
    $password = getOption($config, 'ftp_password');

    if ($host) {
      try {
        $ftp = new \FtpClient\FtpClient();
        $ftp->connect($host, false, $port, 5);

        try {
          $ftp->login($user, $password);
        } catch (\FtpClient\FtpException $th) {
          add_action('admin_notices', function () use ($th) {
            $type = "error";
            $message = $th->getMessage() . '<br/>' . $th->getTraceAsString();
            include SUD_PLUGIN_ROOT_DIR . "src/admin/templates/notices/notice.php";
          });
        }
      } catch (\FtpClient\FtpException $th) {
        add_action('admin_notices', function () use ($th) {
          $type = "error";
          $message = $th->getMessage() . '<br/>' . $th->getTraceAsString();
          include SUD_PLUGIN_ROOT_DIR . "src/admin/templates/notices/notice.php";
        });
      }
    }

    add_filter('wp_generate_attachment_metadata', function ($args) {
      return $args;
    });
  }

  private function uploadFiles($ftp, $args, $settings)
  {
    $file = $args['file'];
    $sizes = $args['sizes'];
    $localPath = $settings['base'] . '/';
    $remotePath = $settings['path'] . '/';
    $isUploaded = $ftp->put('', '', FTP_BINARY);
    update_option('upload_url_path', esc_url($settings['cdn']));

    $directory = substr($file, 0, strrpos($file, '/')) . '/';
    $ftp->put($remotePath . $file, $localPath . $file, FTP_BINARY);

    foreach ($sizes as $size) {
      $file = $size['file'];
      $ftp->put($remotePath . $directory . $file, $localPath . $directory . $file, FTP_BINARY);
    }
  }
}
