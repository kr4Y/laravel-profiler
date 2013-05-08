laravel-profiler
================

Profiler for Laravel 4

## Installation

In `composer.json` file:
```json
{
    "require-dev": {
        "kr4y/profiler": "1.0.*"
    },
}
```

In `app/config/app.php`:
```php
'providers' => array(
  ...

	'Kr4Y\Profiler\ProfilerServiceProvider',
	...
),
```
If you need to disable profiler (disabled in `production` environment by default), publish package config `php artisan config:publish kr4y/profiler` and set `'enabled' => false`
