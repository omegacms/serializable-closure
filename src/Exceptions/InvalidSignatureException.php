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
 * Invalid signature exception class.
 *
 * THe `InvalidSignatursException` clss thrown when the signature of a serialized closure
 * is invalid or modified.
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
class InvalidSignatureException extends Exception
{
    /**
     * InvalidSignatureException constructor.
     *
     * @param  string $message Holds the exception message to throw.
     * @return void
     */
    public function __construct( string $message = 'Your serialized closure might have been modified or it\'s unsafe to be unserialized.' )
    {
        parent::__construct( $message );
    }
}