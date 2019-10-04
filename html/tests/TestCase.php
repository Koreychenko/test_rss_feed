<?php


namespace App\Tests;


use Slim\Psr7\Headers;
use Slim\Psr7\NonBufferedBody;
use Slim\Psr7\Request;
use Slim\Psr7\Uri;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function formatRequest(string $method, string $uri, array $headers = [], $bodyString = null)
    {
        $headers['Content-Type'] = 'application/json';

        $headers = new Headers($headers);

        $body = new NonBufferedBody();

        $uri = new Uri('http', '127.0.0.1', '80', $uri);

        $request = new Request(strtoupper($method), $uri, $headers, [], [], $body);

        if ($bodyString) {
            $request = $request->withParsedBody($bodyString);
        }

        return $request;
    }

    public function getResponse($call) {
        ob_start();
        $call();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

}