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
 * Hmac class.
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
class Hmac implements SignerInterface
{
    /**
     * The secret key.
     *
     * @var string $secret Holds the secret string.
     */
    protected string $secret;

    /**
     * Creates a new signer instance.
     *
     * @param  string $secret
     * @return void
     */
    public function __construct( string $secret )
    {
        $this->secret = $secret;
    }

    /**
     * @inheritdoc
     *
     * @param  string $serialized
     * @return array
     */
    public function sign( string $serialized ) : array
    {
        return [
            'serializable' => $serialized,
            'hash'         => base64_encode( hash_hmac( 'sha256', $serialized, $this->secret, true ) ),
        ];
    }

    /**
     * @inheritdoc
     *
     * @param  array $signature
     * @return bool
     */
    public function verify( array $signature ) : bool
    {
        return hash_equals( base64_encode(
            hash_hmac( 'sha256', $signature[ 'serializable' ], $this->secret, true )
        ), $signature[ 'hash' ] );
    }
}