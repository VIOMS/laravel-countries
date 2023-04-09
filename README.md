# Laravel Countries

[![Total Downloads](https://poser.pugx.org/vioms/laravel-countries/downloads.svg)](https://packagist.org/packages/vioms/laravel-countries)
[![Latest Stable Version](https://poser.pugx.org/vioms/laravel-countries/v/stable.svg)](https://packagist.org/packages/vioms/laravel-countries)
[![Latest Unstable Version](https://poser.pugx.org/vioms/laravel-countries/v/unstable.svg)](https://packagist.org/packages/vioms/laravel-countries)

Laravel Countries is a bundle for Laravel, providing Almost ISO 3166_2, 3166_3, currency, Capital and more for all countries.

This package can be used standalone or can be combined with:
* vioms/laravel-cities

## Inspired by Webpatser:
[Webpatser/laravel-countries](https://github.com/webpatser/laravel-countries)

## Installation

Runs `composer require vioms/laravel-countries` to install the package

Run `composer update` to pull down the latest version of Country List.

## Model

You can start by publishing the configuration. This is an optional step, it contains the table name and does not need to be altered. If the default name `countries` suits you, leave it. Otherwise run the following command

    $ php artisan vendor:publish

You may now run it with the artisan migrate command:

    $ php artisan migrate
    $ php artisan db:seed --class=CountriesSeeder

After running this command the filled countries table will be available
