# Installation

To start this project you need to have running docker and docker-compose tool

Clone project:

    git clone git@github.com:Koreychenko/test_rss_feed.git
    cd test_rss_feed

Install project and apply migrations:

    docker-compose up -d    
    docker-compose exec fpm composer install
    php vendor/bin/phinx migrate -c config-phinx.php
    
Now you can open your project in the browser:

    http://127.0.0.1
    
Running tests:

    docker-compose exec fpm composer test
    
You will see code coverage report on:

    http://127.0.0.1/coverage-report/index.html
    
Settings:
To cover all business logic with tests, we don't use words get cache.
But in production, you should enable it in `/app/config/config.php` with settings
parameter `wordsCache` to `true` , 