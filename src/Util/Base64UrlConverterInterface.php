<?php

declare(strict_types=1);

namespace Strobotti\JWK\Util;

/**
 * Base64UrlConverter is a util for converting to and from Bas64url formatted data.
 *
 * @see https://tools.ietf.org/html/rfc4648#section-5
 *
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
interface Base64UrlConverterInterface
{
    /**
     * Decodes Base64url formatted data to a string
     *
     * @param string $data
     * @param bool   $strict
     *
     * @return string
     */
    public function decode(string $data, $strict = false): string;

    /**
     * Encodes a string to a base64url formatted data
     *
     * @param string $data
     *
     * @return string
     */
    public function encode(string $data): string;
}
