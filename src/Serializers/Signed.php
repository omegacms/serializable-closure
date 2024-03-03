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
namespace Omega\SerializableClosure\Serializers;

/**
 * @use
 */
use function call_user_func_array;
use function func_get_args;
use function serialize;
use function unserialize;
use Closure;
use Omega\SerializableClosure\Signers\SignerInterface;
use Omega\SerializableClosure\Serializers\SerializableInterface;
use Omega\SerializableClosure\Exceptions\InvalidSignatureException;
use Omega\SerializableClosure\Exceptions\MissingSecretKeyException;

/**
 * Signed class.
 *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @subpackage  Omega\SerializableClosure\Serializers
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Signed implements SerializableInterface
{
    /**
     * The signer that will sign and verify the closure's signature.
     *
     * @var ?SignerInterface $signer Holds the current signer object or null.
     */
    public static ?SignerInterface $signer;

    /**
     * The closure to be serialized/unserialized.
     *
     * @var Closure $closure Holds the closure to be serialized/unserialized.
     */
    protected Closure $closure;

    /**
     * Creates a new serializable closure instance.
     *
     * @param  Closure  $closure
     * @return void
     */
    public function __construct( Closure $closure )
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     *
     * @return mixed
     */
    public function __invoke() : mixed
    {
        return call_user_func_array( $this->closure, func_get_args() );
    }

    /**
     * @inheritdoc
     *
     * @return Closure Return the Closure.
     */
    public function getClosure() : Closure
    {
        return $this->closure;
    }

    /**
     * Get the serializable representation of the closure.
     *
     * @return array
     */
    public function __serialize() : array
    {
        if ( ! static::$signer ) {
            throw new MissingSecretKeyException();
        }

        return static::$signer->sign(
            serialize( new Native( $this->closure ) )
        );
    }

    /**
     * Restore the closure after serialization.
     *
     * @param  array  $signature
     * @return void
     * @throws InvalidSignatureException
     */
    public function __unserialize( array $signature ) : void
    {
        if ( static::$signer && ! static::$signer->verify( $signature ) ) {
            throw new InvalidSignatureException();
        }

        /** @var SerializableInterface $serializable */
        $serializable = unserialize( $signature[ 'serializable' ] );

        $this->closure = $serializable->getClosure();
    }
}