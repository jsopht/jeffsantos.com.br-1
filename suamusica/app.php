<?php

require 'vendor/autoload.php';

use GuzzleHttp\Stream\Stream;
use Sunra\PhpSimple\HtmlDomParser;
use Tracy\Debugger;

Debugger::enable();

$album['musics'] = [];

if(isset($_GET['q'])) {
    // setcookie('CloudFront-Key-Pair-Id', 'APKAJXI72ADZRFKVIR2Q', 0, '/');
    // setcookie('CloudFront-Policy', 'eyJTdGF0ZW1lbnQiOlt7IlJlc291cmNlIjoiaHR0cHM6Ly9zdHJlYW0uc3VhbXVzaWNhLmNvbS5ici8qIiwiQ29uZGl0aW9uIjp7IkRhdGVMZXNzVGhhbiI6eyJBV1M6RXBvY2hUaW1lIjoxNTE5MzA4MTcyfX19XX0_', 0, '/');
    // setcookie('CloudFront-Signature', 'Z5%7EO61Dy6kBjelmEeYiyRsT9bK5afsYx3tfvzGFyfspm8RzaSJpjV6z6yF12dXlxxbmMTpX5nG7KMnG3QIbI46i%7EM-NX8DB%7ESsHOPvJvLCWqlnY8bs8p6Knu9iuJJioF8xbfk9ylgTQobNHbRg4V8uGmhVrwEx3e3xgbzvR9Z6ZanXmh3D31sTGtU%7EEIens18QuDhuvrSdJ6BZTqfdCnX7M6DYL0ZX9JRotqBImLSm8Bgi4N7wqieiXpa%7E22TCgzfFCI6IBcOugAY7n9vToF1tvz8OeGvsaUA4v1Z3lcOfo9F9djoI8HhQ-2o0mqQH6o3lWwbrRv8ubhxs4K73164g__', 0, '/');

    $client = new \GuzzleHttp\Client();

    $response = $client->request(
        'GET', $_GET['q'], ['decode_content' => 'gzip']
    );

    $response = HtmlDomParser::str_get_html($response->getBody());

    $album['musics']    = json_decode(htmlspecialchars_decode($response->find('input[data-json]')[0]->attr['data-json']));
    $album['title']     = $album['musics'][0]->album;
    $album['thumbnail'] = $response->find('.cover')[0]->src;

    $titleBgs = [
        'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=fb2264421ec008a297430e9e25f94eb3&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1506157786151-b8491531f063?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=20350f2b60dc7d7ac4b5e9526afacf77&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1481886756534-97af88ccb438?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=647d9bcf339347ac2104b4ef7868a9da&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=b194c1e4a335e5b642ff06d08012ccaa&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1485120750507-a3bf477acd63?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=4603ce061304067b3bfaf33962ed00ba&auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1506157786151-b8491531f063?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=20350f2b60dc7d7ac4b5e9526afacf77&auto=format&fit=crop&w=800&q=80'
    ];
} else {
    $titleBgs = ['https://images.unsplash.com/photo-1514525253161-7a46d19cd819?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=be465b88fdf21a6e05ab522458452344&auto=format&fit=crop&w=800&q=60'];
    $album['title'] = 'Adicione algum álbum.';
}

function getMusicUrl($music) {
    return "https://stream.suamusica.com.br/{$music->dono}/{$music->cdid}/" . rawurlencode($music->titulo);
}
