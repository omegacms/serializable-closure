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
use Omega\SerializableClosure\Serializers\SerializableInterface;
use Omega\SerializableClosure\Serializers\Native;

/**
 * Unsigned serializable closure class.
 *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class UnsignedSerializableClosure
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
     * @param  Closure $closure
     * @return void
     */
    public function __construct( Closure $closure )
    {
        $this->serializable = new Native( $closure );
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
     */
    public function __unserialize( array $data ) : void
    {
        $this->serializable = $data[ 'serializable' ];
    }
}