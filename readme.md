<h1 align="center">Lockdown</h1>

<p align="center">
    Easily lock sections of your Laravel app with Basic Access Authentication using convenient route middleware &amp; configurable guards
</p>

<p align="center">
    <a href="https://travis-ci.org/gwleuverink/lockdown"><img src="https://travis-ci.org/gwleuverink/lockdown.svg?branch=master" alt="Build Status"></a>
    <a href='https://coveralls.io/github/gwleuverink/lockdown'><img src='https://coveralls.io/repos/github/gwleuverink/lockdown/badge.svg' alt='Coverage Status' /></a>
    <!-- <a href="https://packagist.org/packages/leuverink/lockdown"><img src="https://poser.pugx.org/leuverink/lockdown/d/total.svg" alt="Total Downloads"></a> -->
    <a href="https://packagist.org/packages/leuverink/lockdown"><img src="https://poser.pugx.org/leuverink/lockdown/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/leuverink/lockdown"><img src="https://poser.pugx.org/leuverink/lockdown/v/unstable.svg" alt="Latest Unstable Version"></a>
    <a href="https://packagist.org/packages/leuverink/lockdown"><img src="https://poser.pugx.org/leuverink/lockdown/license.svg" alt="License"></a>
</p>

<br/>

## A note on security
Lockdown is meant to shield sections of your project from prying eyes, for example if you like to demo a feature that is not ready for production.

Basic Acces Auth is insecure by nature. If in production always make sure to have TLS configured so all credentials are encrypted. Even with that precaution I heavily discourage you use this package to protect valuable data. It is not meant to do that. 

That said there are plenty of situations where a easily configurable Basic Access Auth middleware is exactly what you need. If you find yourself in one of those situations, read on!

## Installation

**Install the package**

`composer require leuverink/lockdown`

**Publish the config file**

`php artisan vendor:publish --tag="lockdown:config"`

## Getting started

For usage, check out [the documentation](https://gwleuverink@github.io "Lockdown documentation").
