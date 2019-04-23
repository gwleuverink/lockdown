<?php

return [

    'enabled' => env('BASIC_AUTH_ENABLED', true),
    'default' => 'config',

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    | Available drivers: config, database.
    | The config driver directly checks authentication from passed arguments
    | The database driver does a table look-up. Use the provided  commands
    | to manage users
    */

    'guards' => [
        'config' => [
            'driver' => 'config',
            'arguments' => [
                [
                    'user' => 'admin',
                    'password' => 'secret',
                ]
            ]
        ],
        'database' => [
            'driver' => 'database',
        ]
    ]
];
