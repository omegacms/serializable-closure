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
namespace Omega\SerializableClosure\Support;

/**
 * @use
 */
use SplObjectStorage;

/**
 * Closure scope class.
 *
 * The `ClosureScope` class manages the serialization scope for closures,
 * keeping track of the number of serializations and closures that need to
 * be serialized within the current scope.
 * *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @subpackage  Omega\SerializableClosure\Support
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ClosureScope extends SplObjectStorage
{
    /**
     * The number of serializations in current scope.
     *
     * @var int $serializations Holds the number of serializations in current scope.
     */
    public int $serializations = 0;

    /**
     * The number of closures that have to be serialized.
     *
     * @var int $toSerialize Holds the number of closure that have to be serialized.
     */
    public int $toSerialize = 0;
}