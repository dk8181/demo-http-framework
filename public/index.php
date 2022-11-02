<?php

declare(strict_types=1);

use Framework\Http\Message\ServerRequest;

use function App\detectLang;
use function Framework\Http\createServerRequestFromGlobals;

http_response_code(500);

/** @psalm-suppress MissingFile */
require __DIR__ . './../vendor/autoload.php';

function home(ServerRequest $request)
{
    $name = $request->getQueryParams()['name'] ?? 'Guest';

    if (!is_string($name)) {
        http_response_code(400);

        return;
    }

    $lang = detectLang($request, 'en');

    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Frame-Options: DENY');
    echo 'Hello, ' . $name . '! I am gussing your language is ' . $lang;
}

$request = createServerRequestFromGlobals();

home($request);
