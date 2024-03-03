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
     * @param  Closure  $closure
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
     * @return Closure
     */
    public function getClosure() : Closure
    {
        return $this->serializable->getClosure();
    }

    /**
     * Create a new unsigned serializable closure instance.
     *
     * @param  Closure  $closure
     */
    public static function unsigned( Closure $closure ) : UnsignedSerializableClosure
    {
        return new UnsignedSerializableClosure( $closure );
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param  ?string $secret
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
     * @param  ?Closure $transformer
     * @return void
     */
    public static function transformUseVariablesUsing( ?Closure $transformer ) : void
    {
        Native::$transformUseVariables = $transformer;
    }

    /**
     * Sets the serializable closure secret key.
     *
     * @param  ?Closure $resolver
     * @return void
     */
    public static function resolveUseVariablesUsing( ?Closure $resolver ) : void
    {
        Native::$resolveUseVariables = $resolver;
    }

    /**
     * Get the serializable representation of the closure.
     *
     * @return array
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
     * @param  array $data
     * @return void
     * @throws InvalidSignatureException
     */
    public function __unserialize( array $data ) : void
    {
        if ( Signed::$signer && ! $data[ 'serializable' ] instanceof Signed ) {
            throw new InvalidSignatureException();
        }

        $this->serializable = $data[ 'serializable' ];
    }
}