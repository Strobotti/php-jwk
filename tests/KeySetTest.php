<?php

declare(strict_types=1);

namespace Strobotti\JWK\Tests;

use PHPUnit\Framework\TestCase;
use Strobotti\JWK\Key\Rsa;
use Strobotti\JWK\KeySet;

/**
 * @internal
 */
final class KeySetTest extends TestCase
{
    /**
     * @dataProvider provideCreateFromJSON
     */
    public function testToString(string $expected, KeySet $keySet): void
    {
        $this->assertSame($expected, "{$keySet}");
    }

    public static function provideCreateFromJSON(): \Generator
    {
        $keyJson = <<<'EOT'
{
    "kty": "RSA",
    "use": "sig",
    "alg": "RS256",
    "kid": "86D88Kf",
    "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
    "e": "AQAB"
}
EOT;

        yield [
            'expected' => <<<'EOT'
{
    "keys": [
        {
            "kty": "RSA",
            "use": "sig",
            "alg": "RS256",
            "kid": "86D88Kf",
            "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
            "e": "AQAB"
        }
    ]
}
EOT
                ,
            'keySet' => (new KeySet())
                ->addKey(Rsa::createFromJSON($keyJson)),
        ];
    }

    public function testAddKeyThrowsErrorOnDuplicateKid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $keyJson = <<<'EOT'
{
    "kty": "RSA",
    "use": "sig",
    "alg": "RS256",
    "kid": "86D88Kf",
    "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
    "e": "AQAB"
}
EOT;
        $keySet = new KeySet();
        $keySet->addKey(Rsa::createFromJSON($keyJson))
            ->addKey(Rsa::createFromJSON($keyJson))
        ;
    }

    public function testGetKeyById(): void
    {
        $keyJson = <<<'EOT'
{
    "kty": "RSA",
    "use": "sig",
    "alg": "RS256",
    "kid": "86D88Kf",
    "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
    "e": "AQAB"
}
EOT;

        $key = Rsa::createFromJSON($keyJson);

        $keySet = new KeySet();
        $keySet->addKey($key);

        $this->assertSame($key, $keySet->getKeyById('86D88Kf'));

        $this->assertNull($keySet->getKeyById('asdf'));
    }

    public function testCountable(): void
    {
        $keyset = new KeySet();
        $this->assertCount(0, $keyset);

        $keyset->addKey(new Rsa());
        $this->assertCount(1, $keyset);

        $keyset->addKey(new Rsa());
        $this->assertCount(2, $keyset);
    }

    public function testIteratorAggregate(): void
    {
        $keyset = new KeySet();

        $count = 0;

        foreach ($keyset as $key) {
            ++$count;
        }

        $this->assertSame(0, $count);

        $keyset->addKey(new Rsa());
        $keyset->addKey(new Rsa());
        $keyset->addKey(new Rsa());

        foreach ($keyset as $index => $key) {
            $this->assertInstanceOf(Rsa::class, $key);
            $this->assertSame($index, $count);

            ++$count;
        }

        $this->assertSame(3, $count);
    }
}
