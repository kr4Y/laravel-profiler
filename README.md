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

'aliases' => array(
  ...
        'Profiler'        => 'Kr4Y\Profiler\Facades\Profiler',
        ...

```
If you need to disable profiler (disabled in `production` environment by default), publish package config `php artisan config:publish kr4y/profiler` and set `'enabled' => false`

Profiler snapshot points usage:
```php

Profiler::startPoint('sample snapshot point');

.....

Profiler::endPoint('sample snapshot point');


```
