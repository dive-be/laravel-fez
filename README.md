# Optimize document heads for robots

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dive-be/laravel-fez.svg?style=flat-square)](https://packagist.org/packages/dive-be/laravel-fez)

TODO

⚠️ Minor releases of this package may cause breaking changes as it has no stable release yet.

## What problem does this package solve?

TODO

## Installation

You can install the package via composer:

```bash
composer require dive-be/laravel-fez
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Dive\Fez\FezServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Dive\Fez\FezServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-fez = new Dive\Fez();
echo $laravel-fez->echoPhrase('Hello, Dive!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email oss@dive.be instead of using the issue tracker.

## Credits

- [Muhammed Sari](https://github.com/mabdullahsari)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
