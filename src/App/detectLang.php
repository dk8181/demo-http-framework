<?php

declare(strict_types=1);

namespace App;

use Framework\Http\Message\ServerRequest;

function detectLang(ServerRequest $request, string $default): string
{
    if (!empty($request->getQueryParams()['lang']) && is_string($request->getQueryParams()['lang'])) {
        return $request->getQueryParams()['lang'];
    }

    if (!empty($request->getParsedBody()['lang']) && is_string($request->getParsedBody()['lang'])) {
        return $request->getParsedBody()['lang'];
    }

    if (!empty($request->getCookieParams()['lang'])) {
        return $request->getCookieParams()['lang'];
    }

    if (!empty($request->getHeaders()['Accept-Language'])) {
        return substr((string)$request->getHeaders()['Accept-Language'], 0, 2);
    }

    return $default;
}
