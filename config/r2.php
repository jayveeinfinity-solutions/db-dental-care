<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudflare R2 Storage Configuration
    |--------------------------------------------------------------------------
    | These values are pulled from your .env file. They support both
    | Cloudflare R2 Storage and S3-compatible storage providers (AWS, MinIO, Wasabi, etc.).
    |
    */

    'key'       => env('CF_R2_KEY'),
    'secret'    => env('CF_R2_SECRET'),
    'bucket'    => env('CF_R2_BUCKET'),
    'url'       => env('CF_R2_ENDPOINT'),

    /*
    |--------------------------------------------------------------------------
    | Public Endpoint
    |--------------------------------------------------------------------------
    | Only needed if you’re using a custom S3 endpoint (AWS, MinIO, Wasabi, etc.)
    | For Cloudflare R2 Storage, leave this null.
    |
    */
    'endpoint'  => env('R2_PUBLIC_ENDPOINT')

];