<?php

namespace Gwleuverink\Lockdown\Tests\Feature;

use Illuminate\Http\Response;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Route;
use Gwleuverink\Lockdown\Http\Middleware\BasicAccessGuard;

class RouteGuardTest extends TestCase
{

    /** @test */
    public function it_returns_unauthorized_response_when_visiting_protected_route()
    {
        // prepare
        Route::get('lockdown/protected', function () {})->middleware(BasicAccessGuard::class);

        // act
        $response = $this->get('lockdown/protected');
        
        //assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertHeader('WWW-Authenticate');
    }


    /** @test */
    public function it_returns_200_response_when_visiting_unprotected_route()
    {
        
        // prepare
        Route::get('lockdown/unprotected', function () {});

        // act
        $response = $this->get('lockdown/unprotected');

        //assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertHeaderMissing('WWW-Authenticate');
    }
}
