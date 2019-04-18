<?php

namespace Gwleuverink\Lockdown\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;
use Gwleuverink\Lockdown\BasicLockFactory;
use Illuminate\Foundation\Application;

class BasicLockGuard
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
    public function handle($request, Closure $next)
    {
        $lock = $this->app->make(BasicLockFactory::class)->build($request);

        if (! $lock->turnKey()) {
            return $lock->authenticationResponse();
        }

        return $next($request);
    }
}
