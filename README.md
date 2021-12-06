# Shared Uploads Directory
Wordpress Plugin for upload every media to remote server

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