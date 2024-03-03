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
namespace Omega\SerializableClosure\Signers;

/**
 * Signer interface,
 *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @subpackage  Omega\SerializableClosure\Signers
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
interface SignerInterface
{
    /**
     * Sign the given serializable.
     *
     * @param  string  $serializable
     * @return array
     */
    public function sign( string $serializable ) : array;

    /**
     * Verify the given signature.
     *
     * @param  array  $signature
     * @return bool
     */
    public function verify( array $signature ) : bool;
}
