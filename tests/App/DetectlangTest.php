<?php

declare(strict_types=1);

namespace Test\App;

use Framework\Http\Message\ServerRequest;
use Framework\Http\Message\Stream;

use Framework\Http\Message\Uri;
use PHPUnit\Framework\TestCase;

use function App\detectLang;

/**
 * @internal description
 */
final class DetectLangTest extends TestCase
{
    public function testDefault(): void
    {
        $input = fopen('php://memory', '+r');
        fwrite($input, 'Body');

        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: new Uri('http://app.test/home?name=John'),
            method: 'GET',
            queryParams: ['name' => 'John'],
            headers: ['X-Header' => 'Value'],
            cookieParams: ['Cookie' => 'Val'],
            body: new Stream($input ?: fopen('php://input', 'r')),
            parsedBody: ['title' => 'Title']
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('en', $lang);
    }

    public function testQueryParam(): void
    {
        $input = fopen('php://memory', '+r');
        fwrite($input, 'Body');

        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: new Uri('http://app.test/home'),
            method: 'GET',
            queryParams: ['lang' => 'de'],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:['lang' => 'pt'],
            body: new Stream($input ?: fopen('php://input', 'r')),
            parsedBody: ['lang' => 'fr']
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('de', $lang);
    }

    public function testBodyParam(): void
    {
        $input = fopen('php://memory', '+r');
        fwrite($input, 'Body');

        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: new Uri('http://app.test/home'),
            method: 'POST',
            queryParams: [],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:['lang' => 'pt'],
            body: new Stream($input ?: fopen('php://input', 'r')),
            parsedBody: ['lang' => 'fr']
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('fr', $lang);
    }

    public function testCookie(): void
    {
        $input = fopen('php://memory', '+r');
        fwrite($input, 'Body');

        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: new Uri('http://app.test/home'),
            method: 'GET',
            queryParams: [],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:['lang' => 'pt'],
            body: new Stream($input ?: fopen('php://input', 'r')),
            parsedBody: []
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('pt', $lang);
    }

    public function testHeader(): void
    {
        $input = fopen('php://memory', '+r');
        fwrite($input, 'Body');

        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: new Uri('http://app.test/home'),
            method: 'GET',
            queryParams: [],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:[],
            body: new Stream($input ?: fopen('php://input', 'r')),
            parsedBody: []
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('ru', $lang);
    }
}
