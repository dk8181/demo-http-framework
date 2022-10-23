<?php

declare(strict_types=1);

namespace App;

use Framework\Http\Message\ServerRequest;

function detectLang(ServerRequest $request, string $default): string
{
    if (!empty($request->queryParams['lang']) && is_string($request->queryParams['lang'])) {
        return $request->queryParams['lang'];
    }

    if (!empty($request->parsedBody['lang']) && is_string($request->parsedBody['lang'])) {
        return $request->parsedBody['lang'];
    }

    if (!empty($request->cookieParams['lang'])) {
        return $request->cookieParams['lang'];
    }

    if (!empty($request->headers['Accept-Language'])) {
        return substr((string)$request->headers['Accept-Language'], 0, 2);
    }

    return $default;
}
