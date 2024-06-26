<?php

declare(strict_types=1);

namespace Strobotti\JWK\Tests;

use PHPUnit\Framework\TestCase;
use Strobotti\JWK\KeySet;
use Strobotti\JWK\KeySetFactory;

/**
 * @internal
 */
final class KeySetFactoryTest extends TestCase
{
    /**
     * @dataProvider provideCreateFromJSON
     */
    public function testCreateFromJSON(string $input): void
    {
        $factory = new KeySetFactory();

        $keys = $factory->createFromJSON($input);
        $json = $keys->jsonSerialize();

        $this->assertSame(\json_decode($input, true), $json);
    }

    public function testInvalidJsonReturnsEmptyKeySet(): void
    {
        $invalidJson = '{}';

        $factory = new KeySetFactory();

        $keySet = $factory->createFromJSON($invalidJson);
        $this->assertInstanceOf(KeySet::class, $keySet);
        $this->assertCount(0, $keySet);
    }

    public static function provideCreateFromJSON(): \Generator
    {
        yield [
            'input' => <<<'EOT'
{
  "keys": [
    {
      "kty": "RSA",
      "use": "sig",
      "alg": "RS256",
      "kid": "86D88Kf",
      "n": "iGaLqP6y-SJCCBq5Hv6pGDbG_SQ11MNjH7rWHcCFYz4hGwHC4lcSurTlV8u3avoVNM8jXevG1Iu1SY11qInqUvjJur--hghr1b56OPJu6H1iKulSxGjEIyDP6c5BdE1uwprYyr4IO9th8fOwCPygjLFrh44XEGbDIFeImwvBAGOhmMB2AD1n1KviyNsH0bEB7phQtiLk-ILjv1bORSRl8AK677-1T8isGfHKXGZ_ZGtStDe7Lu0Ihp8zoUt59kx2o9uWpROkzF56ypresiIl4WprClRCjz8x6cPZXU2qNWhu71TQvUFwvIvbkE1oYaJMb0jcOTmBRZA2QuYw-zHLwQ",
      "e": "AQAB"
    },
    {
      "kty": "RSA",
      "use": "sig",
      "alg": "RS256",
      "kid": "eXaunmL",
      "n": "4dGQ7bQK8LgILOdLsYzfZjkEAoQeVC_aqyc8GC6RX7dq_KvRAQAWPvkam8VQv4GK5T4ogklEKEvj5ISBamdDNq1n52TpxQwI2EqxSk7I9fKPKhRt4F8-2yETlYvye-2s6NeWJim0KBtOVrk0gWvEDgd6WOqJl_yt5WBISvILNyVg1qAAM8JeX6dRPosahRVDjA52G2X-Tip84wqwyRpUlq2ybzcLh3zyhCitBOebiRWDQfG26EH9lTlJhll-p_Dg8vAXxJLIJ4SNLcqgFeZe4OfHLgdzMvxXZJnPp_VgmkcpUdRotazKZumj6dBPcXI_XID4Z4Z3OM1KrZPJNdUhxw",
      "e": "AQAB"
    }
  ]
}
EOT
        ];
    }
}
