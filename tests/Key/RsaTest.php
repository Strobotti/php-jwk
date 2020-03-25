<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key\Tests;

use PHPUnit\Framework\TestCase;
use Strobotti\JWK\Key\Rsa;

final class KeyTest extends TestCase
{
    /**
     * @param array  $expected
     * @param string $input
     *
     * @dataProvider provideCreateFromJSON
     */
    public function testCreateFromJSON(array $expected, string $input): void
    {
        $key = Rsa::createFromJSON($input);

        static::assertSame($expected['kty'], $key->getKeyType());
        static::assertSame($expected['kid'], $key->getKeyId());
        static::assertSame($expected['use'], $key->getPublicKeyUse());
        static::assertSame($expected['alg'], $key->getAlgorithm());
        static::assertSame($expected['n'], $key->getModulus());
        static::assertSame($expected['e'], $key->getExponent());
    }

    /**
     * @return \Generator
     */
    public function provideCreateFromJSON(): \Generator
    {
        yield [
            'expected' => [
                'kty' => 'RSA',
                'kid' => '86D88Kf',
                'use' => 'sig',
                'alg' => 'RS256',
                'n' => 'iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ',
                'e' => 'AQAB',
            ],
            'input' => <<<'EOT'
{
  "kty": "RSA",
  "kid": "86D88Kf",
  "use": "sig",
  "alg": "RS256",
  "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
  "e": "AQAB"
}
EOT
        ];
    }
}
