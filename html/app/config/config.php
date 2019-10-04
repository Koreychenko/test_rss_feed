<?php

return [
    'determineRouteBeforeAppMiddleware' => false,
    'displayErrorDetails' => true,
    'db' => [
        'driver' => 'mysql',
        'host' => 'db',
        'database' => 'rssfeed',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'port' => 3306,
    ],
    'feedUrl' => 'https://www.theregister.co.uk/software/headlines.atom',
    'top50wordsWikiPage' => 'https://en.wikipedia.org/wiki/Most_common_words_in_English',
    'wordsCache' => false,
];
