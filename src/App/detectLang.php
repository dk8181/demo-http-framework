<?php

declare(strict_types=1);

namespace App;

/**
 * @param array{
 *     queryParams: array<string, string|array>,
 *     parsedBody: array<string, string|array>|null,
 *     headers: array<string, string>,
 *     cookieParams: array<string, string>,
 *     serverParams: array<string, string>
 * } $request
 */
function detectLang(array $request, string $default): string
{
    if (!empty($request['queryParams']['lang']) && is_string($request['queryParams']['lang'])) {
        return $request['queryParams']['lang'];
    }

    if (!empty($request['parsedBody']['lang']) && is_string($request['parsedBody']['lang'])) {
        return $request['parsedBody']['lang'];
    }

    if (!empty($request['cookieParams']['lang'])) {
        return $request['cookieParams']['lang'];
    }

    if (!empty($request['headers']['Accept-Language'])) {
        return substr($request['headers']['Accept-Language'], 0, 2);
    }

    return $default;
}
