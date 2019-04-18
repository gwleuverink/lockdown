<?php

namespace Gwleuverink\Lockdown\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class BasicAccessGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = 'admin';
        $password = 'admssin';

        $providedUser = $request->server->get('PHP_AUTH_USER');
        $providedPassword = $request->server->get('PHP_AUTH_PW');

        $hasCredentials = ($providedUser && $providedPassword);

        $authenticated = ($hasCredentials && $providedUser === $user && $providedPassword === $password);

        if (!$authenticated) {
            return Response::make('', 401, ['WWW-Authenticate' => 'Basic realm="Access denied"']);
        }

        return $next($request);
    }
}
