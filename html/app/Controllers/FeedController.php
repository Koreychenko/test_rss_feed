<?php

namespace App\Controllers;

use Feed;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use DOMDocument;
use DOMXPath;

class FeedController extends AbstractController
{

    protected $feedUrl;
    protected $top50wordsWikiPage;

    /**
     * FeedController constructor.
     * @param $feedUrl
     * @param $top50wordsWikiPage
     */
    public function __construct($feedUrl, $top50wordsWikiPage)
    {
        $this->feedUrl = $feedUrl;
        $this->top50wordsWikiPage = $top50wordsWikiPage;
    }

    /**
     * Returns Feed data
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\MessageInterface|\Slim\Psr7\Message
     * @throws \FeedException
     */
    public function getFeedAction(Request $request, Response $response, $args)
    {
        $restrictedWords = $this->getRestrictedWordsList();

        $rss = Feed::load($this->feedUrl);
        $feed = [];
        $text = '';
        foreach ($rss->entry as $item) {
            $feedItem = [
                'id' => strval($item->id),
                'updated' => strval($item->updated),
                'author' => [
                    'name' => strval($item->author->name),
                    'uri' => strval($item->author->uri),
                ],
                'link' => strval($item->link->attributes()['href']),
                'title' => strval($item->title),
                'body' => strval(strip_tags(html_entity_decode($item->summary)))
            ];

            $feed[] = $feedItem;

            array_walk_recursive($feedItem, function ($str, $item) use (&$text) {
                $text .= strtolower($str) . ' ';
            });
        }

        $text = explode(' ', $text);

        $text = array_diff($text, $restrictedWords);

        $wordCounts = array_count_values($text);

        arsort($wordCounts);
        $wordCounts = array_slice($wordCounts, 0, 10);
        $this->addData('feed', $feed);

        $wordCounts = array_map(function ($count, $word) {
            return [
                'word' => $word,
                'count' => $count
            ];
        }, $wordCounts, array_keys($wordCounts));

        $this->addData('mostFrequentWords', $wordCounts);

        return $this->sendJson($response);
    }

    /**
     * Get a list of the most frequent English words from Wikipedia
     *
     * @return array
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getRestrictedWordsList(): array
    {
        $cache = new FilesystemAdapter();

        $wordList = $cache->get('restrictedWordsList', function (ItemInterface $item) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $this->top50wordsWikiPage);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

            $data = curl_exec($ch);
            curl_close($ch);


            $dom = new DOMDocument();
            $dom->loadHTML($data);

            $domXpath = new DOMXPath($dom);

            $words = $domXpath->query('//*[@id="mw-content-text"]/div/table[1]/tbody/tr/td[1]/a');

            $wordList = [];

            $i = 1;
            foreach ($words as $word) {
                $wordList[] = $word->nodeValue;
                $i++;
                if ($i == 50) {
                    break;
                }
            }

            return $wordList;
        });

        return $wordList;
    }
}