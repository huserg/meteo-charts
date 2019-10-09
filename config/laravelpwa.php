<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'Meteo Charts'),
        'short_name' => 'Meteo',
        'start_url' => '/',
        'background_color' => '#292929',
        'theme_color' => '#515151',
        'display' => 'standalone',
        'orientation'=> 'any',
        'icons' => [
            '96x96' => '/images/icons/icon-96.png',
            '512x512' => '/images/icons/icon-512.png'
        ],
        'splash' => [
            '750x1334' => '/images/icons/splash-750x1334.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'custom' => []
    ]
];
