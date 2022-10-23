<?php

declare(strict_types=1);

namespace Test\App;

use PHPUnit\Framework\TestCase;

use function App\detectLang;

/**
 * @internal description
 */
final class DetectLangTEst extends TestCase
{
    public function testDefault(): void
    {
        $request = [];
        $lang = detectLang($request, 'en');

        self::assertEquals('en', $lang);
    }
}
