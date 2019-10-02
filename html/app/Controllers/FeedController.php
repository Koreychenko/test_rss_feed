<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FeedController extends AbstractController
{
    public function getFeedAction(Request $request, Response $response, $args)
    {
        $url = 'https://workable.com/nr?l=https%3A%2F%2Fwww.theregister.co.uk%2Fsoftware%2Fheadlines.atom';
        $rss = \Feed::loadRss($url);
        $feed = [];
        foreach ($rss->item as $item) {
            $feed[] = [
                'id' => $item->id,
                'updated' => $item->updated,
                'author' => [
                    'name' => $item->author->name,
                    'uri' => $item->author->uri,
                ],
                'link' => $item->link,
                'title' => $item->title,
                'body' => $item->body
                ];
        }

        $this->addData('feed', $feed);

        return $this->sendJson($response);
    }
}