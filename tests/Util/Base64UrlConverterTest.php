<?php

declare(strict_types=1);

namespace Strobotti\JWK\Key\Tests;

use PHPUnit\Framework\TestCase;
use Strobotti\JWK\Util\Base64UrlConverter;

final class Base64UrlConverterTest extends TestCase
{
    /**
     * @param string $expected
     * @param string $input
     *
     * @dataProvider provideDecode
     */
    public function testDecode(string $expected, string $input): void
    {
        $converter = new Base64UrlConverter();

        $this->assertSame($expected, $converter->decode($input));
    }

    /**
     * @return \Generator
     */
    public function provideDecode(): \Generator
    {
        yield [
            'expected' => '/a+quick+brown+fox/jumped-over/the_lazy_dog/',
            'input' => 'L2ErcXVpY2srYnJvd24rZm94L2p1bXBlZC1vdmVyL3RoZV9sYXp5X2RvZy8',
        ];
    }

    /**
     * @param string $expected
     * @param string $input
     *
     * @dataProvider provideEncode
     */
    public function testEncode(string $expected, string $input): void
    {
        $converter = new Base64UrlConverter();

        $this->assertSame($expected, $converter->encode($input));
    }

    /**
     * @return \Generator
     */
    public function provideEncode(): \Generator
    {
        yield [
            'expected' => 'L2ErcXVpY2srYnJvd24rZm94L2p1bXBlZC1vdmVyL3RoZV9sYXp5X2RvZy8',
            'input' => '/a+quick+brown+fox/jumped-over/the_lazy_dog/',
        ];
    }
}
