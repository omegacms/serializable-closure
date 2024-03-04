<?php
/**
 * Part of Omega CMS - Serializable Closure Package
 *
 * @link       https://omegacms.github.io
 * @author     Adriano Giovannini <omegacms@outlook.com>
 * @copyright  Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 */

/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @namespace
 */
namespace Omega\SerializableClosure;

/**
 * @use
 */
use function call_user_func_array;
use function func_get_args;
use Closure;
use Omega\SerializableClosure\Exceptions\InvalidSignatureException;
use Omega\SerializableClosure\Serializers\Native;
use Omega\SerializableClosure\Serializers\Signed;
use Omega\SerializableClosure\Serializers\SerializableInterface;
use Omega\SerializableClosure\Signers\Hmac;

/**
 * Serializable closure class.
 *
 * The `SerializableClosure` class provides a flexible mechanism for serializing closures
 * with the option to use cryptographic signatures for integrity verification. This class
 * supports both signed and unsigned closures. The signed closures utilize HMAC (Hash-based
 * Message Authentication Code) for signature generation.
 *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class SerializableClosure
{
    /**
     * The closure's serializable.
     *
     * @var SerializableInterface $serializable Holds the closure's serializable.
     */
    protected SerializableInterface $serializable;

    /**
     * Creates a new serializable closure instance.
     *
     * @param  Closure  $closure Holds the current closure object.
     * @return void
     */
    public function __construct( Closure $closure )
    {
        $this->serializable = Signed::$signer
            ? new Signed( $closure )
            : new Native( $closure );
    }

    /**
     * Resolve the closure with the given arguments.
     *
     * @return mixed
     */
    public function __invoke() : mixed
    {
        return call_user_func_array( $this->serializable, func_get_args() );
    }

    /**
     * Gets the closure.
     *
     * @return Closure Return the current closure objecy.
     */
    public function getClosure() : Closure
    {
        return $this->serializable->getClosure();
    }

    /**
     * Create a new unsigned serializable closure instance.
     *
     * @param  Closure $closure Holds the current closure instance.
     * @return UnsignedSerializableClosure Return a new instance of UnsignedSerializableClosure.
     */
    public static function unsigned( Closure $closure ) : UnsignedSerializableClosure
    {
        return new UnsignedSerializableClosure( $closure );
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param  ?string $secret Holds the secret code to set.
     * @return void
     */
    public static function setSecretKey( ?string $secret ) : void
    {
        Signed::$signer = $secret
            ? new Hmac( $secret )
            : null;
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param  ?Closure $transformer Holds the current closure instance for transformer.
     * @return void
     */
    public static function transformUseVariablesUsing( ?Closure $transformer ) : void
    {
        Native::$transformUseVariables = $transformer;
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param  ?Closure $resolver Holds the current closure instance for resolver.
     * @return void
     */
    public static function resolveUseVariablesUsing( ?Closure $resolver ) : void
    {
        Native::$resolveUseVariables = $resolver;
    }

    /**
     * Get the serializable representation of the closure.
     *
     * @return array Return an array of the serialized repreentation of the closure.
     */
    public function __serialize() : array
    {
        return [
            'serializable' => $this->serializable,
        ];
    }

    /**
     * Restore the closure after serialization.
     *
     * @param  array $data Holds an array of the closure data for restore.
     * @return void
     * @throws InvalidSignatureException if the signature is not valid.
     */
    public function __unserialize( array $data ) : void
    {
        if ( Signed::$signer && ! $data[ 'serializable' ] instanceof Signed ) {
            throw new InvalidSignatureException();
        }

        $this->serializable = $data[ 'serializable' ];
    }
}