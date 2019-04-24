<?php

namespace Gwleuverink\Lockdown\Middleware;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Foundation\Application;
use Gwleuverink\Lockdown\Responses\AccessDeniedResponse;
use Gwleuverink\Lockdown\LockdownFactory;
use Closure;

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
        $this->app->lockdown->verifyRequest($guard);
        
        return $next($request);
    }
}
