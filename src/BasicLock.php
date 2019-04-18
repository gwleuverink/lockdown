<?php

namespace Gwleuverink\Lockdown;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Gwleuverink\Lockdown\Contracts\Unlockable;
use Illuminate\Config\Repository as ConfigRepository;

class BasicLock implements Unlockable {

    protected $request;
    protected $config;

    public function __construct(Request $request, ConfigRepository $config) {
        $this->request = $request;
        $this->config = $config;
    }

    public function turnKey() : bool
    {
        $user = 'admin';
        $password = 'admssin';

        $providedUser = $this->request->server->get('PHP_AUTH_USER');
        $providedPassword = $this->request->server->get('PHP_AUTH_PW');

        $hasCredentials = ($providedUser && $providedPassword);

        $authenticated = ($hasCredentials && $providedUser === $user && $providedPassword === $password);

        return $authenticated;
    }

    public function authenticationResponse()
    {
        return Response::make('', 401, ['WWW-Authenticate' => 'Basic realm="Access denied"']);
    }
}