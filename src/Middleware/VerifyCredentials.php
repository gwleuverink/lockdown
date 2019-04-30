<?php

namespace Gwleuverink\Lockdown\Middleware;

use Closure;
use Illuminate\Foundation\Application;

class VerifyCredentials
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (config('lockdown.middleware-enabled')) {
            $this->app->lockdown->verifyRequest($guard);
        }

        return $next($request);
    }
}
