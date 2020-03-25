<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
abstract class AbstractKey implements KeyInterface
{
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
     * {@inheritdoc}
     */
    public function getKeyType(): string
    {
        return $this->kty;
    }

    /**
     * {@inheritdoc}
     */
    public function getKeyId(): string
    {
        return $this->kid;
    }

    /**
     * {@inheritdoc}
     */
    public function getPublicKeyUse(): string
    {
        return $this->use;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlgorithm(): string
    {
        return $this->alg;
    }

    /**
     * @param string $kty
     *
     * @return self
     */
    protected function setKeyType(string $kty): self
    {
        $this->kty = $kty;

        return $this;
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
            'use' => $this->use,
            'alg' => $this->alg,
        ];

        if (null !== $this->kid) {
            $assoc['kid'] = $this->kid;
        }

        return $assoc;
    }

    /**
     * @param string            $json
     * @param KeyInterface|null $prototype
     *
     * @return KeyInterface
     */
    public static function createFromJSON(string $json, KeyInterface $prototype = null): KeyInterface
    {
        $assoc = \json_decode($json, true);

        if ($prototype) {
            $instance = clone $prototype;
        } else {
            $instance = new static();
        }

        foreach ($assoc as $key => $value) {
            if (!\property_exists($instance, $key)) {
                continue;
            }

            try {
                $instance->{$key} = $value;
            } catch (\Throwable $e) {
                // only set what you can
            }
        }

        return $instance;
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
