<?php

namespace Gwleuverink\Lockdown\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Gwleuverink\Lockdown\LockdownFactory;
use Gwleuverink\Lockdown\Responses\AccessDeniedResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
            
            $this->app->lockdown->authenticates($guard);
        }
        
        return $next($request);
    }
}
