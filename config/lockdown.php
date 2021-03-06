<?php

return [

    'middleware-enabled' => env('LOCKDOWN_ENABLED', true),
    'default' => 'config',

    'table' => 'basic_auth_users',

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

            'users' => [
                [
                    'user' => 'admin',
                    'password' => 'secret',
                ],
            ],
        ],
        'database' => [
            'driver' => 'database',

            'group' => 'default',
        ],
    ],
];
