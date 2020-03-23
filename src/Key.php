<?php

declare(strict_types=1);

namespace Strobotti\JWK;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
class Key implements \JsonSerializable
{
    public const KEY_TYPE_RSA = 'RSA';

    public const PUBLIC_KEY_USE_SIGNATURE = 'sig';
    public const PUBLIC_KEY_USE_ENCRYPTION = 'enc';

    public const ALGORITHM_RS256 = 'RS256';

    /**
     * The key type.
     *
     * @var string
     */
    private $kty;

    /**
     * The key ID.
     *
     * @var string
     */
    private $kid;

    /**
     * The public key use.
     *
     * @var string
     */
    private $use;

    /**
     * The algorithm.
     *
     * @var string
     */
    private $alg;

    /**
     * The modulus for the RSA public key.
     *
     * @var null|string
     */
    private $n;

    /**
     * The exponent for the RSA public key.
     *
     * @var null|string
     */
    private $e;

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return $this->kty;
    }

    /**
     * @return string
     */
    public function getKeyId(): string
    {
        return $this->kid;
    }

    /**
     * @return string
     */
    public function getPublicKeyUse(): string
    {
        return $this->use;
    }

    /**
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->alg;
    }

    /**
     * Returns the modulus for the RSA public key.
     *
     * @todo Implement different key types through inheritance
     *
     * @return null|string
     */
    public function getRsaModulus(): ?string
    {
        return $this->n;
    }

    /**
     * Returns the exponent for the RSA public key.
     *
     * @todo Implement different key types through inheritance
     *
     * @return null|string
     */
    public function getRsaExponent(): ?string
    {
        return $this->e;
    }

    /**
     * Returns an array presentation of the key
     *
     * @return array An assoc to be passed to json_encode
     */
    public function jsonSerialize(): array
    {
        $assoc = [
            'kty' => $this->kty,
            'kid' => $this->kid,
            'use' => $this->use,
            'alg' => $this->alg,
        ];

        if (null !== $this->n) {
            $assoc['n'] = $this->n;
        }

        if (null !== $this->e) {
            $assoc['e'] = $this->e;
        }

        return $assoc;
    }

    /**
     * @param string $json
     *
     * @return static
     */
    public static function createFromJSON(string $json): self
    {
        $assoc = \json_decode($json, true);

        $instance = new static();

        foreach ($assoc as $key => $value) {
            if (!\property_exists($instance, $key)) {
                continue;
            }

            $instance->{$key} = $value;
        }

        return $instance;
    }
}
