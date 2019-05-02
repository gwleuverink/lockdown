# Custom drivers
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

use Leuverink\Lockdown\Drivers\Driver;

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
