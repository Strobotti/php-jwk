<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
class Rsa extends AbstractKey
{
    /**
     * The modulus for the RSA public key.
     *
     * @var string
     */
    private $n;

    /**
     * The exponent for the RSA public key.
     *
     * @var string
     */
    private $e;

    /**
     * Rsa key constructor.
     */
    public function __construct()
    {
        $this->setKeyType(KeyInterface::KEY_TYPE_RSA);
    }

    /**
     * Returns the exponent for the RSA public key.
     *
     * @return string
     */
    public function getExponent(): string
    {
        return $this->e;
    }

    /**
     * Returns the modulus for the RSA public key.
     *
     * @return string
     */
    public function getModulus(): string
    {
        return $this->n;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $assoc = parent::jsonSerialize();
        $assoc['n'] = $this->n;
        $assoc['e'] = $this->e;

        return $assoc;
    }

    /**
     * {@inheritdoc}
     *
     * @return self
     */
    public static function createFromJSON(string $json, KeyInterface $prototype = null): KeyInterface
    {
        if (!$prototype instanceof Rsa) {
            $prototype = new static();
        }

        $instance = parent::createFromJSON($json, $prototype);

        $assoc = \json_decode($json, true);

        foreach ($assoc as $key => $value) {
            if (!\property_exists($instance, $key)) {
                continue;
            }

            $instance->{$key} = $value;
        }

        return $instance;
    }
}
