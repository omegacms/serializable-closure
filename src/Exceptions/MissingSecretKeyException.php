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
namespace Omega\SerializableClosure\Exceptions;

/**
 * @use
 */
use Exception;

/**
 * Missing secret key exception class.
 *
 * The `MissingSecretException' class thrown when a serializable closure is missing the
 * required secret key.
 *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @subpackage  Omega\SerializableClosure\Exceptions
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class MissingSecretKeyException extends Exception
{
    /**
     * MissingSecretKeyException constructor.
     *
     * @param  string $message Holds the exception message to throw.
     * @return void
     */
    public function __construct( string $message = 'No serializable closure secret key has been specified.' )
    {
        parent::__construct( $message );
    }
}