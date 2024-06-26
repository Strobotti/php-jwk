<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key\Tests;

use PHPUnit\Framework\TestCase;
use Strobotti\JWK\Key\Rsa;

/**
 * @internal
 */
final class RsaTest extends TestCase
{
    /**
     * @dataProvider provideCreateFromJSON
     */
    public function testCreateFromJSON(array $expected, string $input): void
    {
        $key = Rsa::createFromJSON($input);

        $this->assertSame($expected['kty'], $key->getKeyType());
        $this->assertSame($expected['kid'], $key->getKeyId());
        $this->assertSame($expected['use'], $key->getPublicKeyUse());
        $this->assertSame($expected['alg'], $key->getAlgorithm());
        $this->assertSame($expected['n'], $key->getModulus());
        $this->assertSame($expected['e'], $key->getExponent());
    }

    public static function provideCreateFromJSON(): \Generator
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
  "e": "AQAB",
  "unsupported": "ignored"
}
EOT
        ];
    }

    public function testToString(): void
    {
        $json = <<<'EOT'
{
    "kty": "RSA",
    "use": "sig",
    "alg": "RS256",
    "kid": "86D88Kf",
    "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
    "e": "AQAB"
}
EOT;

        $key = Rsa::createFromJSON($json);

        $this->assertSame($json, "{$key}");
    }

    public function testSettersAndGetters(): void
    {
        $e = 'AQAB';
        $n = 'iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ';

        $key = new Rsa();
        $key->setExponent($e)
            ->setModulus($n)
        ;

        $this->assertSame($e, $key->getExponent());
        $this->assertSame($n, $key->getModulus());
    }
}
