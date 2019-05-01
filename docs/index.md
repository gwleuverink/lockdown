<p align="center">
    <a href="https://travis-ci.org/gwleuverink/lockdown"><img src="https://travis-ci.org/gwleuverink/lockdown.svg?branch=master" alt="Build Status"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/license.svg" alt="License"></a>
</p>

Easily lock sections of your Laravel app with Basic Access Authentication.

Lockdown provides a flexible middleware that supports multiple configurations due to it's guard setup similar to Laravel's authentication guards. 

Lockdown ships with confguration & database drivers and provides support for custom drivers in order to serve any implementation you might need.

## Installation

`composer require leuverink/lockdown`

**Optionally publish the config file**

`php artisan vendor:publish --tag="lockdown:config"`

## A note on security
Lockdown is meant to shield sections of your project from prying eyes, for example if you like to demo a feature that is not ready for production.

Basic Acces Auth is insecure by nature. If in production always make sure to have TLS configured so all credentials are encrypted. Even with that precaution I heavily discourage you use this package to protect valuable data. It is not meant to do that. 

That said there are plenty of situations where a easily configurable Basic Access Auth middleware is exactly what you need. If you find yourself in one of those situations, read on!