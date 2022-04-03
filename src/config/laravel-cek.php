<?php

return [

    //Laravel Cek host
    'host' => env('LARAVEL_CEK_HOST', 'http://localhost'),

    //Laravel Cek Port
    'port' => env('LARAVEL_CEK_PORT', '9876'),

    // Blade Template to use formatting logs
    'template' => env('LOGGER_TEMPLATE', 'standard'),

    // Telegram sendMessage options: https://core.telegram.org/bots/api#sendmessage
    'options' => [
        // 'parse_mode' => 'html',
        // 'disable_web_page_preview' => true,
        // 'disable_notification' => false
    ]
];
