<?php

declare(strict_types=1);

namespace Strobotti\JWK;

use Strobotti\JWK\Key\KeyInterface;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
class KeySet implements \JsonSerializable
{
    /**
     * @var KeyFactory
     */
    private $keyFactory;

    /**
     * @var KeyInterface[]
     */
    private $keys = [];

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
     * @param string $kid
     *
     * @return bool
     */
    public function containsKey(string $kid): bool
    {
        return \array_key_exists($kid, $this->keys);
    }

    /**
     * @param string $kid
     *
     * @return null|KeyInterface
     */
    public function getKeyById(string $kid): ?KeyInterface
    {
        if (!$this->containsKey($kid)) {
            return null;
        }

        return $this->keys[$kid];
    }

    /**
     * @param KeyInterface $key
     *
     * @return KeySet
     */
    public function addKey(KeyInterface $key): self
    {
        if ($this->containsKey($key->getKeyId())) {
            throw new \InvalidArgumentException(\sprintf(
                'Key with id `%s` already exists in the set',
                $key->getKeyId()
            ));
        }

        $this->keys[$key->getKeyId()] = $key;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $ret = [];

        foreach ($this->keys as $key) {
            $ret[$key->getKeyId()] = $key->jsonSerialize();
        }

        return [
            'keys' => \array_values($ret),
        ];
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }
}
