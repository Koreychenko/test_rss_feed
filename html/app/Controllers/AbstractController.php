<?php

namespace App\Controllers;

use Illuminate\Database\Query\Builder;
use Slim\Psr7\Response;

class AbstractController {

    private $responseData = [];

    public function addData($key, $value)
    {
        $this->responseData[$key] = $value;

        return $this;
    }

    public function addError($value)
    {
        if (!array_key_exists('errors', $this->responseData)) {
            $this->responseData['errors'] = [];
        }
        $this->responseData['errors'][] = $value;

        return $this;
    }

    public function sendJson(Response $response)
    {
        $payload = json_encode($this->responseData);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function getJsonData($request)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }

}