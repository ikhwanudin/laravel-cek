# laravel package for cek

## installation

You can install the package via composer:

```bash
composer require reaimagine/laravel-cek
```

If you are using Laravel 5.5 or later, the service provider will automatically be discovered.

On earlier versions, you need to do that manually. You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Reaimagine\LaravelCek\LaravelCekServiceProvider::class
];
```

You can then publish the configuration file:

```bash
php artisan vendor:publish --provider "Reaimagine\LaravelCek\LaravelCekServiceProvider"
```

## Setup

### Prepare the logger configuration

You must add a new channel to your `config/logging.php` file:

```php
// config/logging.php
'channels' => [
    //...
    'laravel-cek' => [
        'driver' => 'custom',
        'via'    => Reaimagine\LaravelCek\Logger::class,
        'level'  => 'debug',
    ],
];
```

#### Add the channel on top of other channels

Add the channel to the stack in the `config/logging.php` configuration:

```php
// config/logging.php
'channels' => [
    //...
    'stack' => [
        'driver'   => 'stack',
        'channels' => ['single', 'laravel-cek'],
    ],
];
```

Then make sure the logging channel is set to stack in your `.env` file:

```
LOG_CHANNEL=stack
```
