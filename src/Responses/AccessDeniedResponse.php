<?php

namespace Gwleuverink\Lockdown\Responses;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AccessDeniedResponse extends Response
{
    public function __construct()
    {
        $this->headers = new ResponseHeaderBag([
            'WWW-Authenticate' => 'Basic realm="Access denied"'
        ]);
        
        $this->setStatusCode(401);
        $this->setProtocolVersion('1.0');
    }
}
