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
 * Signer interface.
 *
 * The `SignerInterface` defines methods for signing and verifying serialized closures.
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
     * Sign the given serializable data.
     *
     * @param  string $serialized Holds the serializable data to be signed.
     * @return array Return an array containing the signature.
     */
    public function sign( string $serialized ) : array;

    /**
     * Verify the given signature.
     *
     * @param  array $signature Holds the signature to be verified.
     * @return bool Return true if the signature is valid, false otherwise.
     */
    public function verify( array $signature ) : bool;
}