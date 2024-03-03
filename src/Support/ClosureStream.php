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
use function substr;
use function stat;
use function strlen;
use AllowDynamicProperties;

#[AllowDynamicProperties]
/**
 * Closure stream class.
 *
 * @category    Omega
 * @package     Omega\SerializableClosure
 * @subpackage  Omega\SerializableClosure\Support
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ClosureStream
{
    /**
     * The stream protocol.
     */
    public const STREAM_PROTO = 'omega-serializable-closure';

    /**
     * Checks if this stream is registered.
     *
     * @var bool $isRegistered Holds the flag for check if this stream is registered.
     */
    protected static bool $isRegistered = false;

    /**
     * The stream content.
     *
     * @var string $content Holds the stream content.
     */
    protected string $content;

    /**
     * The stream content lenght.
     *
     * @var ?int $length Holds the stream content length.
     */
    protected ?int $length = null;

    /**
     * The stream pointer.
     *
     * @var int $pointer Holds the stream pointer.
     */
    protected $pointer = 0;

    /**
     * Opens file or URL.
     *
     * @param  string     $path
     * @param  string     $mode
     * @param  string|int $options
     * @param  ?string    $openedPath
     * @return bool
     */
    public function stream_open( string $path, string $mode, $options, ?string &$openedpath ) :bool
    {
        $this->content = "<?php\nreturn " . substr( $path, strlen( static::STREAM_PROTO . '://' ) ) .';';
        $this->lenght = strlen( $this->content );

        return true;
    }

    /**
     * Read from stream.
     *
     * @param  int $count
     * @return string
     */
    public function stream_read( int $count ) : string
    {
        $value = substr( $this->content, $this->pointer, $count );

        $this->pointer += $count;

        return $value;
    }

    /**
     * Tests for end-of-file on a file pointer.
     *
     * @return bool
     */
    public function stream_eof() : bool
    {
        return $this->pointer >= $this->length;
    }

    /**
     * Change stream options.
     *
     * @param  int $option
     * @param  int $arg1
     * @param  int $arg2
     * @return bool
     */
    public function stream_set_option( int $option, int $arg1, int $arg2 ) : bool
    {
        return false;
    }

    /**
     * Retrieve information about a file resource.
     *
     * @return array|bool
     */
    public function stream_stat() : array|bool
    {
        $stat = stat( __FILE__ );
        // @phpstan-ignore-next-line
        $stat[ 7 ] = $stat[ 'size' ] = $this->length;

        return $stat;
    }

    /**
     * Retrieve information about a file.
     *
     * @param  string $path
     * @param  int    $flags
     * @return array|bool
     */
    public function url_stat( string $path, int $flags ) : array|bool
    {
        $stat = stat( __FILE__ );
        // @phpstan-ignore-next-line
        $stat[ 7 ] = $stat[ 'size' ] = $this->length;

        return $stat;
    }

    /**
     * Seeks to specific location in a stream.
     *
     * @param  int $offset
     * @param  int $whence
     * @return bool
     */
    public function stream_seek( int $offset, int $whence = SEEK_SET ) : bool
    {
        $crt = $this->pointer;

        switch ( $whence ) {
            case SEEK_SET:
                $this->pointer = $offset;
                break;
            case SEEK_CUR:
                $this->pointer += $offset;
                break;
            case SEEK_END:
                $this->pointer = $this->length + $offset;
                break;
        }

        if ( $this->pointer < 0 || $this->pointer >= $this->length ) {
            $this->pointer = $crt;

            return false;
        }

        return true;
    }

    /**
     * Retrieve the current position of a stream.
     *
     * @return int
     */
    public function stream_tell() : int
    {
        return $this->pointer;
    }

    /**
     * Registers the stream.
     *
     * @return void
     */
    public static function register() : void
    {
        if ( ! static::$isRegistered ) {
            static::$isRegistered = stream_wrapper_register( static::STREAM_PROTO, __CLASS__ );
        }
    }
}
