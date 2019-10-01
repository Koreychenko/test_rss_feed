<?php

namespace App\Controllers;

use Illuminate\Database\Query\Builder;
use Slim\Psr7\Response;

class AbstractController {

    protected $table;
    private $responseData = [];

    public function __construct(
        Builder $table
    ) {
        $this->table = $table;
    }

    /**
     * @return Builder
     */
    public function getTable(): Builder
    {
        return $this->table;
    }

    public function addData($key, $value)
    {
        $this->responseData[$key] = $value;

        return $this;
    }

    public function sendJson(Response $response)
    {
        $payload = json_encode($this->responseData);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

}