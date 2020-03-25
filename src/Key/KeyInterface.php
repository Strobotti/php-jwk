<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 *
 * @method array jsonSerialize()
 */
interface KeyInterface extends \JsonSerializable
{
    public const KEY_TYPE_RSA = 'RSA';
    public const KEY_TYPE_OKP = 'OKP';
    public const KEY_TYPE_EC = 'EC';

    public const PUBLIC_KEY_USE_SIGNATURE = 'sig';
    public const PUBLIC_KEY_USE_ENCRYPTION = 'enc';

    public const ALGORITHM_RS256 = 'RS256';

    /**
     * Gets the key type, ie. the value of the `kty` field
     *
     * @return string
     */
    public function getKeyType(): string;

    /**
     * Gets the key id, ie. the value of the `kid` field
     *
     * @return null|string
     */
    public function getKeyId(): ?string;

    /**
     * Gets the public key use, ie. the value of the `use` field
     *
     * @return string
     */
    public function getPublicKeyUse(): string;

    /**
     * Gets the cryptographic algorithm used to sign the key, ie. the value of the `alg` field
     *
     * @return string
     */
    public function getAlgorithm(): string;

    /**
     * @return string|bool
     */
    public function __toString();
}
