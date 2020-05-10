<?php

return [
    'name' => 'Fatoran - служба быстрой доставки',
    'manifest' => [
        'name' => env('APP_NAME', 'Fastoran'),
        'short_name' => 'Fastoran',
        'start_url' => '/m/',
        'background_color' => '#000000',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'portrait',
        'icons' => [
            '72x72' => '/img/icons/icon-72x72.png',
            '96x96' => '/img/icons/icon-96x96.png',
            '128x128' => '/img/icons/icon-128x128.png',
            '144x144' => '/img/icons/icon-144x144.png',
            '152x152' => '/img/icons/icon-152x152.png',
            '192x192' => '/img/icons/icon-192x192.png',
            '384x384' => '/img/icons/icon-384x384.png',
            '512x512' => '/img/icons/icon-512x512.png'
        ],
        'splash' => [
            '640x1136' => '/img/icons/splash-640x1136.png',
            '750x1334' => '/img/icons/splash-750x1334.png',
            '828x1792' => '/img/icons/splash-828x1792.png',
            '1125x2436' => '/img/icons/splash-1125x2436.png',
            '1242x2208' => '/img/icons/splash-1242x2208.png',
            '1242x2688' => '/img/icons/splash-1242x2688.png',
            '1536x2048' => '/img/icons/splash-1536x2048.png',
            '1668x2224' => '/img/icons/splash-1668x2224.png',
            '1668x2388' => '/img/icons/splash-1668x2388.png',
            '2048x2732' => '/img/icons/splash-2048x2732.png',
        ],
        'custom' => []
    ]
];
