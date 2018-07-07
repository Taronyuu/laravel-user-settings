# Laravel user settings
> Simple and persistent boolean settings per user.

[![Build Status](https://travis-ci.org/Internetcodehq/laravel-user-settings.svg?branch=master)](https://travis-ci.org/Internetcodehq/laravel-user-settings)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)


This package has been developed to help you store simple boolean settings (true/false or yes/no settings) per user.

### Features
- Only 1 additional column for multiple settings.
- Settings are stored as binary.
- Can be used on all models.
- Customizable.
- Fast.

### Background
Laravel user settings only requires 1 additional column (bigint) per entity. All settings are stored in this column as a binary value. By using the [bitwise operators](http://php.net/manual/en/language.operators.bitwise.php) in PHP we are able to store multiple settings in a single column without extra coding/decoding or multiple queries.

Searching for enabled settings is supported by MySQL [as can be found here.](https://dev.mysql.com/doc/refman/8.0/en/bit-functions.html)

### Usage
**Get a setting**
```php
$user->setting('my_setting');
```
OR
```php
$user->getSetting('my_setting');
```

**Set a setting**
```php
$user->setting('my_setting', true);
```
OR
```php
$user->setSetting('my_setting', true);
```

**Overriding a list of allowed setting for the entity.**
A global list of settings can be found in the `user-settings.php` config file, if you want to override these settings per model you can override the following method:
```php
/**
 * getSettingFields function.
 * Get the default possible settings for the user. Can be overwritten
 * in the user model.
 *
 * @return array
 */
public function getSettingFields()
{
    return config('user-settings.setting_fields', []);
}
```

**Searching for settings in a query**
```php
$user = (new User())->whereSetting('my_setting')->first();
```

### Installation
First of all you should require the package using composer:
```
composer require internetcode/laravel-user-settings
```

Afterwards you can add the service provider to your providers array. This is optional since it is already auto discovered by Laravel.
```php
'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,

        ...

        Internetcode\LaravelUserSettings\LaravelUserSettingsServiceProvider::class,
    ],
```

Publish the config and migration files.
```
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=migrations
```
Please note that the newly created migration file defaults to a `settings` column on the user model. Feel free to change that, or add multiple tables.

On the models where you want to use the settings add the `HasSettingsTrait` trait.
```php
<?php

namespace Internetcode\LaravelUserSettings\Tests;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Internetcode\LaravelUserSettings\Traits\HasSettingsTrait;

class User extends Authenticatable
{
    use HasSettingsTrait;
```

### Caveats
- ***Never*** change the order of the settings in the `setting_fields` array. Every field in here is converted based on the index of the field. Therefore changing the order/index of your setting, will result in invalid settings being true or false.

### Bugs / Issues / Ideas
Please create an issue using the [issue tracker](https://github.com/Internetcodehq/laravel-user-settings/issues) or drop us an email.

### License
[MIT](https://github.com/Internetcodehq/laravel-user-settings/blob/master/LICENSE) © Zander van der Meer