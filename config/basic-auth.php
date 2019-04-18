<?php

return [

    'enabled' => env('BASIC_AUTH_ENABLED', true),
    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    */

    'guards' => [
        'default' => [
            [
                'user' => 'admin',
                'password' => 'admin',
            ]
        ]
    ]
];
