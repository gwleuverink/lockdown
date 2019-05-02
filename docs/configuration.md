# Configuration
run `php artisan vendor:publish --tag="lockdown:config"` to publish the package configuration file if you haven't done so already. Open `config/lockdown.php` and have a look.

Inside of the configuration file you'll find the following;

- **middleware-enabled**: Defines if the middleware is enabled or not

- **default**: The default guard the middleware uses. By default the config guard is used.

- **table**: The table name for the database driver

- **guards**: A list of guards you can configure.

<br />

## Configuring guards
You can configure as many guards you like. A guard acts as a group of user credentials to check against. Each guard makes use of a driver. Shipped with lockdown are two drivers; the config driver, which checks against a list of (non hashed) usercredentials passed through the guard configuration, and a database driver, which checks hashed credentials against the database.

Let's take the first guard that is configured when you first publish the config file as an example.

``` php
'guards' => [
    'config' => [
        'driver' => 'config',
        'arguments' => [
            [
                'user' => 'admin',
                'password' => 'secret',
            ],
        ],
    ],
]
```

<br />

`config` in this case is the guard's name. To validate Lockdown against this guard you can pass the guard name as a middleware parameter like so:

``` php
// Pass the guard name as middleware parameter
Route::get('some-protected-route', PageController::class)->middleware('lockdown:config');

// Or pass it to the validateRequest method when not using middleware
public function __invoke(Lockdown $lockdown)
{   
    $this->lockdown->verifyRequest('config');
}
```

<br />

As you can see a guard always consists of a name and two keys; a driver definition and optional arguments passed to that driver. Read on for more information on the available drivers Lockdown ships with.

## The config driver
The config driver is the easiest to get started with. Using this driver lockdown authentication requests are validated against an array of user credentials which are passed inside of the guard's arguments. Let's say you'd want to define a new guard with the name `my-custom-guard` using the config driver. You'd go about it as follows:

``` php
'my-custom-guard' => [
    'driver' => 'config',
    'arguments' => [
        [
            'user' => 'example user 1',
            'password' => 'secret',
        ],
        [
            'user' => 'example user 2',
            'password' => 'secret',
        ],
        // And so on...
    ],
],
```

If you don't want to have credentials inside of the config file, which I can imagine, use the database driver instead.

## The database driver

The database driver stores all your users in the database. Passwords are hashed so it's a little more secure.

Before you can do anything you need to publish lockdown's migration file and migrate the database:

`php artisan vendor:publish --tag="lockdown:migrations"` & `php artisan migrate`

Same as the config driver you can create as many guards to check against as many groups of users you'd like:


``` php
'my-custom-guard' => [
    'driver' => 'database',
    'arguments' => [
        'group' => 'my-group-name'
    ]
],
```

Each guard using the database driver should have a group name defined within it's arguments clause. Credentials are checked for a username & password in combination with a group. This way you can create multiple groups of users if you want to have it so different sections of your app are accessible to different groups of users.

### Database driver commands
Lockdown provides commands to create & delete users for the database driver.