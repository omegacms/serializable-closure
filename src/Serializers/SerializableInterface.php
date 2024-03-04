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
use Closure;

/**
 * Interface for serializable closures in Omega CMS.
 *
 * The `SerializableInterface` defines methods that should be implemented by classes
 * aiming to serialize closures in Omega CMS.
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
interface SerializableInterface
{
    /**
     * Resolve the closure with the given arguments.
     *
     * @return mixed Return the result of the closure invocation.
     */
    public function __invoke() : mixed;

    /**
     * Gets the closure that got serialized/unserialized.
     *
     * @return Closure Return the serialized/unserialized closure.
     */
    public function getClosure() : Closure;
}