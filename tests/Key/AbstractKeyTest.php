<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key\Tests;

use PHPUnit\Framework\TestCase;
use Strobotti\JWK\Key\AbstractKey;

/**
 * @internal
 */
final class AbstractKeyTest extends TestCase
{
    public function testCreateFromJSON(): void
    {
        $json = <<<'EOT'
{
    "kty": "RSA",
    "use": "sig",
    "alg": "RS256",
    "kid": "86D88Kf"
}
EOT;

        $key = AbstractKeyTest__AbstractKey__Mock::createFromJSON($json);

        static::assertSame($json, "{$key}");
    }
}

final class AbstractKeyTest__AbstractKey__Mock extends AbstractKey
{
}
