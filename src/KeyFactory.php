<?php

declare(strict_types=1);

namespace Strobotti\JWK;

use Strobotti\JWK\Key\KeyInterface;
use Strobotti\JWK\Util\Base64UrlConverter;
use Strobotti\JWK\Util\Base64UrlConverterInterface;

/**
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @see   https://github.com/Strobotti/php-jwk
 * @since 1.0.0
 */
class KeyFactory
{
    /**
     * @var Base64UrlConverterInterface
     */
    private $base64UrlConverter;

    /**
     * KeyFactory constructor.
     */
    public function __construct()
    {
        $this->setBase64UrlConverter(new Base64UrlConverter());
    }

    /**
     * @since 1.0.0
     *
     * @return KeyFactory
     */
    public function setBase64UrlConverter(Base64UrlConverterInterface $base64UrlConverter): self
    {
        $this->base64UrlConverter = $base64UrlConverter;

        return $this;
    }

    /**
     * @since 1.0.0
     */
    public function createFromPem(string $pem, array $options = []): KeyInterface
    {
        $publicKey = \openssl_pkey_get_public($pem);

        if ($publicKey === false) {
            throw new \InvalidArgumentException('Failed to read the provided PEM: ' . \openssl_error_string());
        }

        $keyInfo = \openssl_pkey_get_details($publicKey);

        if ($keyInfo === false) {
            throw new \InvalidArgumentException('Failed to extract key details from the provided PEM');
        }

        $jsonData = \array_merge(
            $options,
            [
                'kty' => 'RSA',
                'n' => $this->base64UrlConverter->encode($keyInfo['rsa']['n']),
                'e' => $this->base64UrlConverter->encode($keyInfo['rsa']['e']),
            ]
        );

        $encoded = \json_encode($jsonData);

        if ($encoded === false) {
            throw new \RuntimeException('Failed to JSON-encode the key data');
        }

        // TODO Only RSA is supported atm
        return Key\Rsa::createFromJSON($encoded);
    }

    /**
     * @since 1.0.0
     */
    public function createFromJson(string $json): KeyInterface
    {
        // TODO Only RSA is supported atm
        return Key\Rsa::createFromJSON($json);
    }
}
