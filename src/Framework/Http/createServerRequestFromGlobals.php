<?php

namespace Framework\Http;

use Framework\Http\Message\ServerRequest;

function createServerRequestFromGlobals(): ServerRequest
{
    $headers = [
        $_SERVER['CONTENT-TYPE'] ?? '',
        $_SERVER['CONTENT-LENGTH'] ?? '',
    ];

    foreach ($_SERVER as $serverName => $serverValue) {
        if (str_starts_with($serverName, 'HTTP_')) {
            $name = ucwords(strtolower(str_replace('_', '-', substr($serverName, 5))), '-');
            $headers[$name] = $serverValue;
        }
    }

    return new ServerRequest(
        serverParams: $_SERVER,
        uri: $_SERVER['REQUEST_URI'],
        method: $_SERVER['REQUEST_METHOD'],
        queryParams: $_GET,
        headers: $headers,
        cookieParams: $_COOKIE,
        body: file_get_contents('php://input'),
        parsedBody: $_POST ?: null
    );
}