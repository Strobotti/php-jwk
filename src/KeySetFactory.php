<?php

declare(strict_types=1);

namespace Strobotti\JWK;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
class KeySetFactory
{
    /**
     * @var KeyFactory
     */
    private $keyFactory;

    /**
     * KeySet constructor.
     */
    public function __construct()
    {
        $this->keyFactory = new KeyFactory();
    }

    /**
     * @param KeyFactory $keyFactory
     *
     * @return self
     */
    public function setKeyFactory(KeyFactory $keyFactory): self
    {
        $this->keyFactory = $keyFactory;

        return $this;
    }

    /**
     * @param string $json
     *
     * @return KeySet
     */
    public function createFromJSON(string $json): KeySet
    {
        $assoc = \json_decode($json, true);

        $instance = new KeySet();

        foreach ($assoc['keys'] as $keyData) {
            $key = $this->keyFactory->createFromJson(\json_encode($keyData));

            $instance->addKey($key);
        }

        return $instance;
    }

}
