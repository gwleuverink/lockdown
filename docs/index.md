<p align="center">
    <a href="https://travis-ci.org/gwleuverink/lockdown"><img src="https://travis-ci.org/gwleuverink/lockdown.svg?branch=master" alt="Build Status"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/gwleuverink/lockdown"><img src="https://poser.pugx.org/gwleuverink/lockdown/license.svg" alt="License"></a>
</p>

Easily lock sections of your Laravel app with Basic Access Authentication using convenient route middleware  
Lockdown provides a clean way to integrate with middleware and supports multiple configurations due to it's guard setup similar to Laravel's authentication guards. 

## Installation

`composer require leuverink/lockdown`

**Optionally publish the config file**

`php artisan vendor:publish --tag="lockdown:config"`
