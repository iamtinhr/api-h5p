# Headless H5P Laravel API

Forked from [https://github.com/EscolaLMS](https://github.com/EscolaLMS/h5p)

## Description

This package provides a Laravel API for interacting with H5P content without installing **_unrelated_** dependencies.


# Original Documentation
## Features

The lib allows headlessly

- play all h5p content - exposed all essential data, yet player is needed
- edit all h5p content - exposed all essential data, yet editor is needed
- CRUD libraries
- CRUD content
- upload library from `.h5p` file
- upload content from `.h5p` file

See [Swagger](https://escolalms.github.io/H5P/) documented endpoints.

To play the content you can use [EscolaLMS H5P Player](https://github.com/EscolaLMS/H5P-player)

## Install

1. `composer require tinhr/api-h5p`
2. `php artisan migrate`
3. `php artisan h5p:storage-link` see below

### Storage links

You need to publish many of files to be availabe as public link.

`php artisan h5p:storage-link` which creates a symbolic link from `storage/app/h5` and `vendor/h5p/h5p-core` and `vendor/h5p/h5p-editor` to be accesible to public, as follows

```
public_path('h5p') => storage_path('app/h5p'),
public_path('h5p-core') => base_path().'vendor/h5p/h5p-core',
public_path('h5p-editor') => base_path().'vendor/h5p/h5p-editor',
```

### Cors

All the endpoints need to be accesible from other domains, so [CORS](https://laravel.com/docs/8.x/routing#cors) must be properlly set.

Except of endpoints assets must expose CORS headers as well. You achive that by setting Apache/Nginx/Caddy/Whatever settings - below is example for Nginx for wildcard global access.

```
location ~* \.(eot|ttf|woff|woff2|jpg|jpeg|gif|png|wav|mp3|mp4|mov|ogg|webv)$ {
    add_header Access-Control-Allow-Origin *;
}
```

### Seeder

To seed content and library

```
php artisan db:seed --class="\EscolaLms\HeadlessH5P\Database\Seeders\ContentLibrarySeeder"
```

You can seed library and content with build-in seeders as command that are accessible with

- `php artisan h5p:seed` to add just libraries
- `php artisan h5p:seed --addContent` to add content with libraries

## Road map

- rewrite h5p core in a way like [luminare in typescript](https://github.com/lumieducation/lumi)