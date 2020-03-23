<?php

declare(strict_types=1);

namespace Strobotti\JWK;

use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;

/**
 * @package Strobotti\JWK
 * @author  Juha Jantunen <juha@strobotti.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @link    https://github.com/Strobotti/php-jwk
 */
class Converter
{
    /**
     * @param Key $key
     *
     * @return string
     */
    public function keyToPem(Key $key): string
    {
        // TODO implement strategies to support different key types
        $rsa = new RSA();

        $modulus = $this->base64UrlDecode($key->getRsaModulus(), true);

        $rsa->loadKey([
            'e' => new BigInteger(\base64_decode($key->getRsaExponent(), true), 256),
            'n' => new BigInteger($modulus, 256),
        ]);

        return $rsa->getPublicKey();
    }

    /**
     * @param string $pem     A PEM encoded (RSA) Public Key
     * @param array  $options An array of key-options, such as ['kid' => 'eXaunmL', 'use' => 'sig', ...]
     *
     * @return Key
     */
    public function pemToKey(string $pem, array $options = []): Key
    {
        $keyInfo = openssl_pkey_get_details(openssl_pkey_get_public($pem));

        $jsonData = array_merge(
            $options,
            [
                'kty' => 'RSA',
                'n' => $this->base64UrlEncode($keyInfo['rsa']['n']),
                'e' => $this->base64UrlEncode($keyInfo['rsa']['e']),
            ]
        );

        return Key::createFromJSON(json_encode($jsonData));
    }

    /**
     * https://tools.ietf.org/html/rfc4648#section-5.
     *
     * @param string $data
     * @param bool   $strict
     *
     * @return string
     */
    private function base64UrlDecode(string $data, $strict = false): string
    {
        $b64 = \strtr($data, '-_', '+/');

        return \base64_decode($b64, $strict);
    }

    /**
     * https://tools.ietf.org/html/rfc4648#section-5.
     *
     * @param string $data
     *
     * @return string
     */
    private function base64UrlEncode(string $data): string
    {
        return rtrim(\strtr(\base64_encode($data), '+/', '-_'), '=');
    }
}
