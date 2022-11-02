<?php

declare(strict_types=1);

use Framework\Http\Message\Response;
use Framework\Http\Message\ServerRequest;

use function App\detectLang;
use function Framework\Http\createServerRequestFromGlobals;

http_response_code(500);

/** @psalm-suppress MissingFile */
require __DIR__ . './../vendor/autoload.php';

### Page

function home(ServerRequest $request)
{
    $name = $request->getQueryParams()['name'] ?? 'Guest';

    if (!is_string($name)) {
        return new Response(400, '', []);
    }

    $lang = detectLang($request, 'en');
    $body = 'Hello, ' . $name . '! I am gussing your language is ' . $lang;

    return new Response(200,
        $body,
        [
            'Content-Type' => 'text/plain; charset=utf-8',
            'X-Frame-Options' => 'DENY',
        ]
    );
}

### Grab request

$request = createServerRequestFromGlobals();


### Run

$response = home($request);

### Send

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $value) {
    header($name . ':' . $value);
}

echo $response->getBody();
