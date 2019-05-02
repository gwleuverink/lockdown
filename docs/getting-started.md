# Getting started

After installing Lockdown you can immediatly use the package with zero configuration. Apply lockdown route middleware to protect sections of your app with Basic Access Auth. There are a couple of approaches you can take.

Without additional configuration you can use `admin` & `secret` as default credentials. You should change this before using Lockdown in production. Read more about this on [the configuration page](/configuration "Lockdown configuration documentation").

*As a route middleware applied to a single route or a route group*
``` php
// On a single route
Route::get('some-protected-route', PageController::class)->middleware('lockdown');


// On a route group
Route::group(['middleware' => 'lockdown'], function() {
    // Protected routes here
})
```

<br />

*Inside of a controller's constructor*
``` php
class ExampleController
{
    public function __construct()
    {
        $this->middleware('lockdown')->only(['update', 'patch'])
    }

    //
}
```

<br />

*Perform a check manually without middleware*
``` php
// Usage without the middleware
class ExampleController
{
    public function __invoke(Lockdown $lockdown)
    {
        // 
        if($someCondition === true) {
            $lockdown->verifyRequest() // Accepts a optional guard name 
        }
    }
}
```