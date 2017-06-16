# Helper function for Laravel 5

[![Latest Stable Version](https://poser.pugx.org/tohtamysh/laravel-helpers/v/stable)](https://packagist.org/packages/tohtamysh/laravel-helpers) [![License](https://poser.pugx.org/tohtamysh/laravel-helpers/license)](https://packagist.org/packages/tohtamysh/laravel-helpers)

### Installation

##### run composer
```bash
composer require tohtamysh/laravel-helpers
```
##### add service provider
Register the Service Provider by adding it to your project's providers array in app.php
``` php
'providers' => array(
    Tohtamysh\Helper\HelperServiceProvider::class,
);
```
##### add alias
```php
'Helper' => Tohtamysh\Helper\HelperFacade::class,
```
### Use
####Replace russian string to latin string
```php
$translite_string = Helper::make($russian_string)
```
####Get correct russian ending
*example return 'домов'*
```php
$end = Helper::ending(55, 'дом', 'дома', 'домов')
```
####Get russian date
*example return 'Января'*
```php
$russian_date = Helper::russianDate('2017-01-02', 'month', true)
```
