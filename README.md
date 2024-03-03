# Serializable Closure Package

The Serializable Closure package provides easy and secure way to **serialize closure in PHP**

## Requirements

* PHP 8.2 or later

## Installation via Composer

Add `"omegacms/serializable-closure": "^1.0.0"` to the require block in your `composer.json` file and then run `composer install`.

```json
{
    "require": {
        "omegacms/serializable-closure": "^1.0.0"
    }
}
```

Alternatively, you can simply run the folowing from the command line:

```sh
composer require omegacms/serializable-closure "^1.0.0"
```

If you want to include the test sources, use:

```sh
composer require --prefer-source omegacms/serializable-closure "^1.0.0"
```

## Basic Usage

You may serialize a closure this way:

```php
use Omega\SerializableClosure\SerializableClosure;

$closure = fn() => 'YOUR_STRING';

// Secure the serialize.
SerializableClosure::setSecretKey( 'secret' );

// Serialize
$serialized = serialize( new SerializableClosure( $closure ) );

// Unserialize
$closure    = unserialize( $serialized )->getClosure();

// Print result.
echo $closure();
```

## Documentation

Work in progress

## Contributing

If you'd like to contribute to the OmegaCMS Serializable Closure package, please follow our [contribution guidelines](CONTRIBUTING.md).

## License

This project is open-source software licensed under the [GNU General Public License v3.0](LICENSE).
