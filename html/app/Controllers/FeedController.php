<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FeedController extends AbstractController
{
    public function getFeedAction(Request $request, Response $response, $args)
    {
        $feed = [
            [
                'title' => 'Title 1',
                'text' => 'Text',
            ]
        ];

        $this->addData('feed', $feed);

        return $this->sendJson($response);
    }
}