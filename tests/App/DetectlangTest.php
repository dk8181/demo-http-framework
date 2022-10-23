<?php

declare(strict_types=1);

namespace Test\App;

use PHPUnit\Framework\TestCase;

use function App\detectLang;

/**
 * @internal description
 */
final class DetectLangTest extends TestCase
{
    public function testDefault(): void
    {
        $request = [];
        $lang = detectLang($request, 'en');

        self::assertEquals('en', $lang);
    }

    public function testQueryParam(): void
    {
        $request = [
            'queryParams' => ['lang' => 'de'],
            'parsedBody' => ['lang' => 'fr'],
            'cookieParams' => ['lang' => 'pt'],
            'headers' => ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
        ];

        $lang = detectLang($request, 'en');

        self::assertEquals('de', $lang);
    }

    public function testBodyParam(): void
    {
        $request = [
            'queryParams' => [],
            'parsedBody' => ['lang' => 'fr'],
            'cookieParams' => ['lang' => 'pt'],
            'headers' => ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
        ];

        $lang = detectLang($request, 'en');

        self::assertEquals('fr', $lang);
    }

    public function testCookie(): void
    {
        $request = [
            'queryParams' => [],
            'parsedBody' => [],
            'cookieParams' => ['lang' => 'pt'],
            'headers' => ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
        ];

        $lang = detectLang($request, 'en');

        self::assertEquals('pt', $lang);
    }

    public function testHeader(): void
    {
        $request = [
            'queryParams' => [],
            'parsedBody' => [],
            'cookieParams' => [],
            'headers' => ['Accept-Language' => 'ru-ru,ru;q=0.8,en;q=0.4'],
        ];

        $lang = detectLang($request, 'en');

        self::assertEquals('ru', $lang);
    }
}
