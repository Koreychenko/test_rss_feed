<?php

namespace App\Controllers;

use Slim\Psr7\Response;

class AbstractController
{

    private $responseData = [];

    /**
     * Adds a value to the response JSON array
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->responseData[$key] = $value;

        return $this;
    }

    /**
     * Adds an error to errors array
     *
     * @param $value
     * @return $this
     */
    public function addError($value)
    {
        if (!array_key_exists('errors', $this->responseData)) {
            $this->responseData['errors'] = [];
        }
        $this->responseData['errors'][] = $value;

        return $this;
    }

    /**
     * Sends response as JSON
     *
     * @param Response $response
     * @return \Psr\Http\Message\MessageInterface|\Slim\Psr7\Message
     */
    public function sendJson(Response $response)
    {
        $payload = json_encode($this->responseData);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}