<?php

declare(strict_types=1);

namespace Test\Framework\Http\Message;

use Framework\Http\Message\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ResponseTest extends TestCase
{
    public function testCreate(): void
    {
        $response = new Response(
            $status = 200,
            $body = 'Body',
            $headers = [
                'X-Header-1' => 'Value-1',
                'X-Header-2' => 'Value-2',
            ]
        );

        self::assertEquals($body, $response->getBody());
        self::assertEquals($status, $response->getStatusCode());
        self::assertEquals($headers, $response->getHeaders());
    }
}
