<?php

declare(strict_types=1);

namespace Test\Framework\Http\Message;

use Framework\Http\Message\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class UriTest extends TestCase
{
    public function testCreate(): void
    {
        $uri = new Uri($string = 'https://john:secret@info.org:8080/home?a=2&b=3#first');

        self::assertEquals('https', $uri->getScheme());
        self::assertEquals('john:secret', $uri->getUserInfo());
        self::assertEquals('info.org', $uri->getHost());
        self::assertEquals('8080', $uri->getPort());
        self::assertEquals('/home', $uri->getPath());
        self::assertEquals('a=2&b=3', $uri->getQuery());
        self::assertEquals('first', $uri->getFragment());

        self::assertEquals($string, (string)$uri);
    }
}
