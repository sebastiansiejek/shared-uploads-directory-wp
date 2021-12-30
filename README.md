# Shared Uploads Directory

Wordpress Plugin for upload every file from `/uploads` to remote server. Now you can share your uploads directory with your team!

![Settings page](./docs/images/settings-page.jpeg)

## Supports

* SFTP
* Every file type from `/uploads` directory

## Configuration

### Code

Your can define remote server configuration in `wp-config.php` file. If you define constants inputs in admin panel will be **ignored**.

```php
define('SUD_FTP_HOST', '');
define('SUD_FTP_PORT', '');
define('SUD_FTP_USER', '');
define('SUD_FTP_PASSWORD', '');
define('SUD_FTP_DIRECTORY', '');
define('SUD_FTP_CDN', '');
```
## Develop

### Requirements

* PHP 7.4
* Composer > 2.0
* Docker

### Getting started

1. Clone the repository
2. Start docker containers - `docker-compose up -d`
3. Install dependencies
   1. `docker exec -it <CONTAINER_ID> bash`
   2. `cd wp-content/plugins/shared-uploads-directory-wp`
   3. `composer install`

## Author

* [Sebastian Siejek](https://github.com/sebastiansiejek)