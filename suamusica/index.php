<?php

require 'vendor/autoload.php';

use GuzzleHttp\Stream\Stream;
use Sunra\PhpSimple\HtmlDomParser;
use Tracy\Debugger;

Debugger::enable();

header('Access-Control-Allow-Origin: *');
$_SERVER['HTTP_HOST'] = 'www.suamusica.com.br';
const SITE_URL_BASE = 'https://www.suamusica.com.br';

$client = new \GuzzleHttp\Client();

if(isset($_GET['q'])) {
    $urlAbm = str_replace('https://www.suamusica.com.br/', '', $_GET['q']);
} else {
    $urlAbm = 'WesleySafadaoMossoroRNRerpertorioNovo';
}

// dump(SITE_URL_BASE . '/' . $urlAbm);

$response = $client->request(
    'GET',
    SITE_URL_BASE . '/' . $urlAbm,
    ['decode_content' => 'gzip']
);

$response = HtmlDomParser::str_get_html($response->getBody());

$thumbnail = SITE_URL_BASE . $response->find('.cover')[0]->src;
$abBase = getBaseUrl($response->find('.cover')[0]->src);

function getBaseUrl($url) {
    $url = str_replace('dirs', 'file', $url);
    $url = explode('/', $url);
    $url = "https://{$url[1]}.files.suamusica.com.br/{$url[2]}/{$url[3]}";
    $url = str_replace('file.', 'file1.', $url);
    return $url;
}

$album = [
    'title'     => trim($response->find('.top_post_title h2')[0]->plaintext),
    'thumbnail' => $thumbnail,
    'abBase'    => $abBase,
];

$rowMusics = $response->find('.musicas_do .addSingle');
foreach ($rowMusics as $i => $music) {
    $musics[$i] = [
        'title' => $music->getAttribute('data-arquivo'),
        'url'   => $abBase . '/' . rawurlencode($music->getAttribute('data-arquivo'))
    ];
}

$album['musics'] = $musics;

?>
<!DOCTYPE html>
<html>
<head>
<meta name="referrer" content="no-referrer" />
    <title>Sua Música</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <style>
        body, button, h1, h2, h3, h4, h5, h6, input, optgroup, select, textarea {
            font-family: "Source Sans Pro","Helvetica Neue",Calibre,Helvetica,Arial,sans-serif;
            font-weight: 300;
        }

        .form-control {
            padding: 0.8rem .75rem;
            font-size: 1.3rem;
        }

        .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
            background-color: #2a7ebd;
            border: 0;
        }

        .music-list {
            margin-top: 30px;
        }
        .player-box p {
            text-align: center;
            display: block;
            color: white;
            padding-top: 15px;

        }
        .list-group .music-box,
        .player-box p {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden !important;
            text-overflow: ellipsis;
            cursor: pointer;
        }
        .title {
            background-color: #f2f2f2;
        }

        audio, img {
            margin: 0 auto;
                display: block;
        }
        .player-box {
            padding-bottom: 25px;
        }
        audio {
            margin-top: 15px;
        }

        .bg-blue {
            background: -moz-linear-gradient(45deg,rgba(15,184,188,1) 0,rgba(60,89,189,1) 100%);
            background: -webkit-gradient(linear,left bottom,right top,color-stop(0,rgba(15,184,188,1)),color-stop(100%,rgba(60,89,189,1)));
            background: -webkit-linear-gradient(45deg,rgba(15,184,188,1) 0,rgba(60,89,189,1) 100%);
            background: -o-linear-gradient(45deg,rgba(15,184,188,1) 0,rgba(60,89,189,1) 100%);
            background: -ms-linear-gradient(45deg,rgba(15,184,188,1) 0,rgba(60,89,189,1) 100%);
            background: linear-gradient(45deg,rgba(15,184,188,1) 0,rgba(60,89,189,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3c59bd', endColorstr='#0FB8BC', GradientType=1 );
        }
    </style>
</head>
<body class="bg-blue">
    <div class="container music-list">
        <div class="row">
            <div class="col-sm-12">
                <form>
                    <div class="form-group">
                        <input type="text" id="ipt-url" class="form-control" placeholder="Enter URL">
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-7">
                <div class="list-group">
                  <button type="button" class="list-group-item list-group-item-action title">
                        <h5 class="center-block"><?= $album['title']; ?> </h5>
                  </button>
                  <?php foreach ($album['musics'] as $i => $music): ?>
                    <button type="button" class="list-group-item list-group-item-action music-box <?= $i == 0 ? 'active' : '' ?>">
                        <span><?= str_replace('.mp3', '', $music['title']) ;?></span>
                        <div class="hidden music-data">
                            <input type="hidden" class="music-url" value="<?= $music['url'] ?>">
                        </div>
                    </button>
                  <?php endforeach ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4 offset-lg-1 bg-blue player-box">
                <p class="list-group-item list-group-item-action active current-playing"><?= str_replace('.mp3', '', $album['musics'][0]['title']) ?></p>
                <img src="<?= $album['thumbnail'] ?>" class="img-fluid" alt="Responsive image">
                <audio id="player" controls preload="none">
                    <source src="<?= $album['musics'][0]['url'] ?>" id="mp3-source" type="audio/mp3">
                </audio>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>

        $('form input').bind("paste", function(e) {
            var pastedData = e.originalEvent.clipboardData.getData('text');
            window.location.replace(location.toString().replace(location.search, "") + "?q=" + pastedData);
        })

        document.querySelector('#player').load()

        $('.music-box').click(function() {
            $this = $(this)
            $('.current-playing').text($this.find('span').text());
            $('.music-box').removeClass('active')
            $this.addClass('active')
            $('#mp3-source').attr('src', $this.find('.music-url').val())
            document.querySelector('#player').load()
            document.querySelector('#player').play()
        })

        document.querySelector('#player').onended = function() {
            $('.list-group .active').next().click();
        };
    </script>
</body>
</html>
