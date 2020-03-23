<?php

declare(strict_types=1);

namespace Strobotti\JWK;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
class KeySet implements \JsonSerializable
{
    /**
     * @var Key[]
     */
    private $keys = [];

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
     * @return null|Key
     */
    public function getKeyById(string $kid): ?Key
    {
        if (!$this->containsKey($kid)) {
            return null;
        }

        return $this->keys[$kid];
    }

    /**
     * @param Key $key
     *
     * @return KeySet
     */
    public function addKey(Key $key): self
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
     * @param string $json
     *
     * @return static
     */
    public static function createFromJSON(string $json): self
    {
        $assoc = \json_decode($json, true);

        $instance = new static();

        foreach ($assoc['keys'] as $key) {
            $instance->addKey(Key::createFromJSON(\json_encode($key)));
        }

        return $instance;
    }
}
