<?php

use GuzzleHttp\Client;

$client = new \GuzzleHttp\Client();

$app->get('/', function () use ($app) {
    return 'asd';
});
