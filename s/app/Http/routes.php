<?php

use GuzzleHttp\Client;

$client = new \GuzzleHttp\Client();

$app->get('/', function () use ($app, $client) {
    // dd(json_decode($client->get('http://s1.jeffsantos.com.br')->getBody()));
    return response()->json(
        json_decode($client->get('http://s1.jeffsantos.com.br')->getBody())
    );
});
