<?php

declare(strict_types=1);

return [
    'access_key_id' => env('AWS_ACCESS_KEY_ID'),
    'secret_access_key' => env('AWS_SECRET_ACCESS_KEY'),
    'default_region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
    'endpoint' => env('AWS_ENDPOINT'),
];