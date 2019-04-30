<h1 align="center">Lockdown</h1>

<p align="center">
    <a href="https://travis-ci.org/gwleuverink/lockdown"><img src="https://travis-ci.org/gwleuverink/lockdown.svg?branch=master" alt="Build Status"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/license.svg" alt="License"></a>
</p>

<p align="center">
    Easily lock sections of your Laravel app with Basic Access Authentication using convenient route middleware &amp; configurable guards
</p>

## A note on security
Lockdown is meant to shield sections of your project from prying eyes, for example if you like to demo a feature that is not ready for production.

Basic Acces Auth is insecure by nature. If in production always make sure to have TLS configured so all credentials are encrypted. Even with that precaution I heavily discourage you use this package to protect valuable data. It is not meant to do that. 

That said there are plenty of situations where a easily configurable Basic Access Auth middleware is exactly what you need. If you find yourself in one of those situations, read on!

## Installation

**Install the package**

`composer install gwleuverink/lockdown`

**Publish the config file**

`php artisan vendor:publish --tag="lockdown:config"`

## Usage

After installing Lockdown you can immediatly use the package with zero configuration. Apply lockdown route middleware to protect the route with Basic Access Auth. You can use the following default credentials:

- User: admin
- Password: secret

``` php
// On a single route
Route::get('some-protected-route', PageController::class)->middleware('lockdown');


// On a route group
Route::group(['middleware' => 'lockdown'], function() {
    // Protected routes here
})


// On specific controller methods
class ExampleController
{
    public function __construct()
    {
        $this->middleware('lockdown')->only(['update', 'patch'])
    }

    //
}
```

You can apply different guards to check against as a middleware parameter. You can configure these guards in the config file. More on that in the next chapter.

``` php
Route::get('some-protected-route', PageController::class)->middleware('lockdown:database');
```

Lockdown can also be used to check Basic Acces Auth conditionally within your code. Just grab the lockdown instance from the container and use it as you like.

``` php

// Usage without the middleware
class ExampleController
{
    public function __invoke(Lockdown $lockdown)
    {
        // 
        if($someCondition === true) {
            $this->lockdown->verifyRequest() // Accepts a optional guard name 
        }
    }
}
```

## Configuration
run `php artisan vendor:publish --tag="lockdown:config"` to publish the package configuration file if you haven't done so already. Open `config/lockdown.php` and have a look.

Inside of the configuration file you'll find the following;

- **middleware-enabled**: Defines if the middleware is enabled or not

- **default**: The default guard the middleware uses. By default the config guard is used.

- **table**: The table name for the database driver

- **guards**: A list of guards you can configure.

You can configure as many guards you like. A guard acts as a group of user credentials to check against. Each guard makes use of a driver. Shipped with lockdown are two drivers; the config driver, which checks against a list of (non hashed) usercredentials passed through the guard configuration, and a database driver, which checks hashed credentials against the database.


## Drivers

Out of the box you can make use of the config driver and the database driver. Inside of the config file you can define as many guards you like to create different groups of users to check the middleware against.

### The config driver

When using the config driver, simply store users inside of the config file. This file should be checked in to version control. This is the easiest driver to get started with. If you don't want to have credentials inside of the config file, which I can imagine, use the database driver instead.

Let's say you want to create an additional guard with the name 'my-custom-guard' using the config driver:
``` php
'my-custom-guard' => [
    'driver' => 'config',
    'arguments' => [
        [
            'user' => 'admin',
            'password' => 'secret',
        ],
        // Add more users here
    ]
],
```

### The database driver

The database driver stores all your users in the database. Passwords are hashed so it's a little more secure.

Before you can do anythin you need to publish lockdown's migration file and migrate the database:

`php artisan vendor:publish --tag="lockdown:migrations"` & `php artisan migrate`

Same as the config driver you can create as many guards to check against as many groups of users you'd like.

Let's say you'd want to define a new database guard. That would look something like this:

``` php
'my-custom-guard' => [
    'driver' => 'database',
    'arguments' => [
        'group' => 'my-group-name'
    ]
],
```
In the case of this example we still need to add a user to `my-custom-group` Simply add one with the following command:

`php artisan lockdown:create-user username password my-custom-group`

To remove users use the following command:

`php artisan lockdown:delete-user username my-custom-group`

## Custom drivers
You can also extend Lockdown with your own drivers if the need arises. Simply fill in a fully qualified class name as your driver definition:

``` php
'my-custom-guard' => [
    'driver' => CustomDriver::class,
    'arguments' => [
        // Whatever extra data you driver needs
    ]
],
```

Then create a new class within that location, extend Lockdown's base driver class and apply it's interface method:

``` php
namespace App\Lockdown;

use Gwleuverink\Lockdown\Drivers\Driver;

class CustomDriver extends Driver
{
    /**
     * Check if current request passes the
     * BasicLock authentication guard
     *
     * @return boolean
     */
    public function passesAuthentication($user, $password) : bool
    {
        // Get whatever extra arguments passed in the config using: $this->arguments;
        // Do whatever checks you like and return a boolean

        return $passes
    }
}
```

## Contribution

You wan't to contribute? That is great! I appreciate all the help you can spare. 
If you'd like to add a feature, a custom driver or anything else, please create an issue first so we can discuss.