<?php

namespace Gwleuverink\Lockdown\Middleware;

use Closure;
use Gwleuverink\Lockdown\LockdownFactory;
use Illuminate\Foundation\Application;
use Gwleuverink\Lockdown\Responses\AccessDeniedResponse;

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
    public function handle($request, Closure $next, $guard = null)
    {
        if (config('lockdown.middleware-enabled')) {
            $lock = $this->app->make(LockdownFactory::class)->build($request);

            if (!$lock->authenticates($guard)) {
                return new AccessDeniedResponse();
            }
        }
        
        return $next($request);
    }
}
