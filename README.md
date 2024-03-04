# Serializable Closure Package

The Serializable Closure package provides a convenient and secure way to serialize closures in PHP. It allows you to serialize and unserialize closures, preserving their state and functionality even across different PHP processes. This can be particularly useful in scenarios where closures need to be stored and retrieved, such as in caching mechanisms or queue systems.

## How it Works

The package introduces two main classes: `SerializableClosure` and `UnsignedSerializableClosure`.

- **`SerializableClosure`**: This class is designed for closures that require additional security measures. It supports signed serialization, which means the closure is associated with a secret key for added security. The signer used is configurable through the `setSecretKey` method.

- **`UnsignedSerializableClosure`**: This class is suitable for closures that don't require a secret key for signing. It provides a straightforward way to serialize closures without additional security measures.

### ⚠️ Experimental Feature: Serialization of Anonymous Functions

**Caution: This feature is experimental!** We've added support for the serialization of anonymous functions, but it comes with a warning. This feature is considered experimental, and we recommend using it only if you fully understand its implications.

Anonymous function serialization involves intricacies and potential risks, and its usage should be approached with caution. If you're unsure about the consequences or don't specifically need this functionality, it's advisable to stick to serializing named functions or closures.

Before incorporating this feature into your code, ensure you are aware of the implications and are comfortable handling any potential issues that might arise. Proceed with caution!

## Requirements

* PHP 8.2 or later

## Installation via Composer

To install the package, add the following to your `composer.json` file:

```json
{
    "require": {
        "omegacms/serializable-closure": "^1.0.0"
    }
}
```

Then run:

```sh
composer install
```

## Getting Started

Example 1: Using `SerializableClosure` with `Signing`.

```php
use Omega\SerializableClosure\SerializableClosure;

// Create a closure.
$closure = fn() => 'YOUR_STRING_HERE';

// Set a secret key for signing.
SerializableClosure::setSecretKey( 'secret' );

// Serialize the closure
$serialized = serialize( new SerializableClosure( $closure ) );

// Unserialize and get the closure.
$closure    = unserialize( $serialized )->getClosure();

// Print result.
echo $closure(); // Output: YOUR_STRING_HERE
```

Example 2: Using `UnsignedSerializableClosure`.

```php
use Omega\SerializableClosure\UnsignedSerializableClosure;

// Create a closure
$closure = fn( $value ) => strtoupper( $value );

// Serialize the closure
$serialized = serialize( new UnsignedSerializableClosure( $closure ) );

// Unserialize and get the closure
$unserialized = unserialize( $serialized )->getClosure();

// Invoke the closure
echo $unserialized( 'hello' ); // Output: HELLO
```

Example 3: Using `SerializableClosure` with `Signing` and `anonymous functions`.

```php
use Omega\SerializableClosure\SerializableClosure;

// Create a closure.
$closure = function() {
    $anonymousClass = new class {
        public function getMessage() : string {
            return "Helloo from anonymous class!";
        }
    };
    
    return $anonymousClass->getMessage();
};

// Serialize
$serialized = serialize( new SerializableClosure( $closure ) );

// Unserialize
$unserializedClosure = unserialize( $serialized );

//Invoke the closure
$result = $unserializedClosure();

echo $result; // Output: Hello from anonymous class!
```

Example 4: UsUsing `UnsignedSerializableClosure` and `anonymous functions`.

```php
use Omega\SerializableClosure\UnsignedSerializableClosure;

// Create a closure
$anonymousFunction = function( $name ) {
    return "Hello, $name!";
};

// Create UnsignedSerializableClosure
$unsignedClosure = new UnsignedSerializableClosure( $anonymousFunction );

 // Serialize
 $serialized = serialize( $unsignedClosure );
 
 // Deserialize
 $unserialized = unserialize( $serialized );
 
 // Invoke the closure
 $result = $unserializedClosure( "Jhon" );
 
 // Echo the closure
 echo $result; // Output: Hello, Jhon!
```

## Contributing

If you'd like to contribute to the OmegaCMS Serializable Closure package, please follow our [contribution guidelines](CONTRIBUTING.md).

## License

This project is open-source software licensed under the [GNU General Public License v3.0](LICENSE).
