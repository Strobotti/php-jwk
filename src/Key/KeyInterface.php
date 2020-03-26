<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key;

/**
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @see    https://github.com/Strobotti/php-jwk
 * @since 1.0.0
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
     * Converts this key to a string.
     *
     * @since 1.0.0
     *
     * @return bool|string
     */
    public function __toString();

    /**
     * Gets the key type, ie. the value of the `kty` field.
     *
     * @since 1.0.0
     */
    public function getKeyType(): string;

    /**
     * Gets the key id, ie. the value of the `kid` field.
     *
     * @since 1.0.0
     */
    public function getKeyId(): ?string;

    /**
     * Gets the public key use, ie. the value of the `use` field.
     *
     * @since 1.0.0
     */
    public function getPublicKeyUse(): string;

    /**
     * Gets the cryptographic algorithm used to sign the key, ie. the value of the `alg` field.
     *
     * @since 1.0.0
     */
    public function getAlgorithm(): string;
}
