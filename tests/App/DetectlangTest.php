<?php

declare(strict_types=1);

namespace Test\App;

use Framework\Http\Message\ServerRequest;
use PHPUnit\Framework\TestCase;

use function App\detectLang;

/**
 * @internal description
 */
final class DetectLangTest extends TestCase
{
    public function testDefault(): void
    {
        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: '/home',
            method: 'GET',
            queryParams: ['name' => 'John'],
            headers: ['X-Header' => 'Value'],
            cookieParams: ['Cookie' => 'Val'],
            body: 'body',
            parsedBody: ['title' => 'Title']
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('en', $lang);
    }

    public function testQueryParam(): void
    {
        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: '/home',
            method: 'GET',
            queryParams: ['lang' => 'de'],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:['lang' => 'pt'],
            body: 'body',
            parsedBody: ['lang' => 'fr']
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('de', $lang);
    }

    public function testBodyParam(): void
    {
        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: '/home',
            method: 'POST',
            queryParams: [],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:['lang' => 'pt'],
            body: 'body',
            parsedBody: ['lang' => 'fr']
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('fr', $lang);
    }

    public function testCookie(): void
    {
        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: '/home',
            method: 'GET',
            queryParams: [],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:['lang' => 'pt'],
            body: 'body',
            parsedBody: []
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('pt', $lang);
    }

    public function testHeader(): void
    {
        $request = new ServerRequest(
            serverParams: ['HOST' => 'app.test'],
            uri: '/home',
            method: 'GET',
            queryParams: [],
            headers: ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
            cookieParams:[],
            body: 'body',
            parsedBody: []
        );

        $lang = detectLang($request, 'en');

        self::assertEquals('ru', $lang);
    }
}
