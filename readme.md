# Lockdown
Easily lock sections of your Laravel app with Basic Access Authentication using convenient route middleware &amp; configurable guards

## Currently in development
It goes without saying that this shouldn't be used in production yet.

## Installation

run `composer install gwleuverink/lockdown`

## Usage

After installing Lockdown you can immediatly use the package with zero configuration. Apply the lockdown middleware to protect the route with Basic Access Auth. You can use the following default credentials:

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


// Usage without the middleware
class ExampleController
{
    public function __invoke(Lockdown $lockdown)
    {
        $this->lockdown->verifyRequest() // Accepts a optional guard name 
    }

    //
}

```

## Configuration

It's pretty sweet that Lockdown works with zero configuration, but I doubt anyone want's to use `admin:secret` as their default credentials. This can be configured in the configuration file.

run `php artisan vendor:publish --tag="lockdown:config"` to publish the package configuration file. Open `config/lockdown.php` and have a look.

Inside of the configuration file you'll find the following;

- **middleware-enabled**: Defines if the middleware is enabled or not

- **default**: The default guard the middleware uses. By default the cofig guard is used.

- **table**: The table name for the database driver

- **guards**: A list of guards you can configure.

## Drivers

Out of the box you can make use of the config driver and the database driver.

**The config driver**

//

**The database driver**

//


## Custom drivers

//

## Contribution

//