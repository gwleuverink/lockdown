<?php

namespace Gwleuverink\Lockdown\Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Gwleuverink\Lockdown\Tests\TestCase;

class RouteGuardTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        Route::get('lockdown/protected', function () {
        })->middleware('basic-lock');
        Route::get('lockdown/unprotected', function () {
        });
    }

    /** @test */
    public function it_returns_unauthorized_response_when_visiting_protected_route()
    {
        // act
        $response = $this->get('lockdown/protected');
        
        //assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertHeader('WWW-Authenticate');
    }


    /** @test */
    public function it_returns_ok_response_when_visiting_unprotected_route()
    {
        // act
        $response = $this->get('lockdown/unprotected');

        //assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertHeaderMissing('WWW-Authenticate');
    }

    /** @test */
    public function it_returns_ok_response_when_visiting_protected_route_with_valid_credentials()
    {
        // arrange
        // We need to set the server variables explicitly because
        // PHP_AUTH_USER & PHP_AUTH_PW are not set in CGI mode
        // When using the authorisation header with a token.
        $this->withServerVariables([
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'secret'
        ]);

        // act
        $response = $this->get('lockdown/protected');

        //assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertHeaderMissing('WWW-Authenticate');
    }

    /** @test */
    public function it_returns_ok_response_when_visiting_protected_route_when_middleware_is_disabled()
    {
        // arrange
        config(['basic-lock.middleware-enabled' => false]);

        // act
        $response = $this->get('lockdown/protected');

        //assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertHeaderMissing('WWW-Authenticate');
    }
}
