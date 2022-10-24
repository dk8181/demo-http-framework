<?php

namespace Framework\Http;

use Framework\Http\Message\ServerRequest;

function createServerRequestFromGlobals(): ServerRequest
{
    return new ServerRequest(
        serverParams: $_SERVER,
        uri: $_SERVER['REQUEST_URI'],
        method: $_SERVER['REQUEST_METHOD'],
        queryParams: $_GET,
        headers: [
            'Host' => $_SERVER['HTTP_HOST'],
            'Content-Type' => $_SERVER['CONTENT-TYPE'] ?? '',
            'Content-Length' => $_SERVER['CONTENT-LENGTH'] ?? '',
            'Accept-Language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
        ],
        cookieParams: $_COOKIE,
        body: file_get_contents('php://input'),
        parsedBody: $_POST ?: null
    );
}
