<?php

declare(strict_types=1);

namespace Test\Framework\Http\Message;

use Framework\Http\Message\Stream;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class StreamTest extends TestCase
{
    public function testEmpty(): void
    {
        $resource = fopen('php://memory', 'r');

        $stream = new Stream($resource);

        self::assertEquals('', $stream->getContents());
    }

    public function testNotRewinded(): void
    {
        $resource = fopen('php://memory', 'r+');

        fwrite($resource, 'Body');

        $stream = new Stream($resource);

        self::assertEquals('', $stream->getContents());
    }

    public function testRewinded(): void
    {
        $resource = fopen('php://memory', 'r+');

        fwrite($resource, 'Body');

        $stream = new Stream($resource);

        $stream->rewind();

        self::assertEquals('Body', $stream->getContents());
    }

    public function testSeekAndRead(): void
    {
        $resource = fopen('php://memory', 'r+');

        fwrite($resource, 'Very long body');

        $stream = new Stream($resource);

        $stream->seek(5);

        self::assertEquals('long body', $stream->read(9));
    }

    public function testToString(): void
    {
        $resource = fopen('php://memory', 'r+');

        fwrite($resource, 'Body');

        $stream = new Stream($resource);

        self::assertEquals('Body', (string)$stream);
    }
}
