<?php

require 'vendor/autoload.php';

use GuzzleHttp\Stream\Stream;
use Sunra\PhpSimple\HtmlDomParser;
use Tracy\Debugger;

Debugger::enable();

header('Access-Control-Allow-Origin: *');
$_SERVER['HTTP_HOST'] = 'www.suamusica.com.br';
const SITE_URL_BASE = 'http://www.suamusica.com.br';

$client = new \GuzzleHttp\Client();

if(isset($_GET['q'])) {
    $urlAbm = str_replace('https://www.suamusica.com.br/', '', $_GET['q']);
} else {
    $urlAbm = 'WesleySafadaoMossoroRNRerpertorioNovo';
}dump(SITE_URL_BASE . '/' . $urlAbm);
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
    $url = "http://{$url[1]}.files.suamusica.com.br/{$url[2]}/{$url[3]}";
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

// header('Content-type:application/json;charset=utf-8');
// echo json_encode($album); exit;
// $album = json_decode('{"title":"WESLEY SAFADAO - AO VIVO - MOSSORO - RN - 12.12.2016 - #RepertorioNovo","thumbnail":"http:\/\/www.suamusica.com.br\/dirs2\/41261\/1349894\/cd_cover.jpg","abBase":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894","musics":[{"title":"01 - ME LIBERA NEGA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/01%20-%20ME%20LIBERA%20NEGA%20-%20ITALOCDSWS.mp3"},{"title":"02 - CRONOMETRADO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/02%20-%20CRONOMETRADO%20-%20ITALOCDSWS.mp3"},{"title":"03 - PARTIU - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/03%20-%20PARTIU%20-%20ITALOCDSWS.mp3"},{"title":"04 - 6 GRAUS A BAIXO DE ZERO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/04%20-%206%20GRAUS%20A%20BAIXO%20DE%20ZERO%20-%20ITALOCDSWS.mp3"},{"title":"05 - SANTINHA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/05%20-%20SANTINHA%20-%20ITALOCDSWS.mp3"},{"title":"06 - SOU MAS FORTE - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/06%20-%20SOU%20MAS%20FORTE%20-%20ITALOCDSWS.mp3"},{"title":"07 - TROCO O DISCO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/07%20-%20TROCO%20O%20DISCO%20-%20ITALOCDSWS.mp3"},{"title":"08 - ELA DOMINA O RATATA TUM TUM - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/08%20-%20ELA%20DOMINA%20O%20RATATA%20TUM%20TUM%20-%20ITALOCDSWS.mp3"},{"title":"09 - ABSURDOS - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/09%20-%20ABSURDOS%20-%20ITALOCDSWS.mp3"},{"title":"10 - SOLTEIRO SIM SOZINHO NUNCA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/10%20-%20SOLTEIRO%20SIM%20SOZINHO%20NUNCA%20-%20ITALOCDSWS.mp3"},{"title":"11 - OITAVA DOSE - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/11%20-%20OITAVA%20DOSE%20-%20ITALOCDSWS.mp3"},{"title":"12 - MEU CORACAO DEU PT - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/12%20-%20MEU%20CORACAO%20DEU%20PT%20-%20ITALOCDSWS.mp3"},{"title":"13 - SABADAO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/13%20-%20SABADAO%20-%20ITALOCDSWS.mp3"},{"title":"14 - CHUVISCO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/14%20-%20CHUVISCO%20-%20ITALOCDSWS.mp3"},{"title":"15 - VIROU EX PERDEU A VEZ - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/15%20-%20VIROU%20EX%20PERDEU%20A%20VEZ%20-%20ITALOCDSWS.mp3"},{"title":"16 - TO SENSACIONAL - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/16%20-%20TO%20SENSACIONAL%20-%20ITALOCDSWS.mp3"},{"title":"17 - SOLTEIRO DE NOVO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/17%20-%20SOLTEIRO%20DE%20NOVO%20-%20ITALOCDSWS.mp3"},{"title":"18 - FALA AQUI COM MINHA MAO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/18%20-%20FALA%20AQUI%20COM%20MINHA%20MAO%20-%20ITALOCDSWS.mp3"},{"title":"19 - CAMAROTE - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/19%20-%20CAMAROTE%20-%20ITALOCDSWS.mp3"},{"title":"20 - JEITO SAFADO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/20%20-%20JEITO%20SAFADO%20-%20ITALOCDSWS.mp3"},{"title":"21 - A DAMA E O VAGABUNDO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/21%20-%20A%20DAMA%20E%20O%20VAGABUNDO%20-%20ITALOCDSWS.mp3"},{"title":"22 - BEBA MAS - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/22%20-%20BEBA%20MAS%20-%20ITALOCDSWS.mp3"},{"title":"23 - CORACAO MACHUCADO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/23%20-%20CORACAO%20MACHUCADO%20-%20ITALOCDSWS.mp3"},{"title":"24 - BUM BUM GRANADA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/24%20-%20BUM%20BUM%20GRANADA%20-%20ITALOCDSWS.mp3"},{"title":"25 - PARECE QUE O VENTO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/25%20-%20PARECE%20QUE%20O%20VENTO%20-%20ITALOCDSWS.mp3"},{"title":"26 - AMIGA PARCEIRA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/26%20-%20AMIGA%20PARCEIRA%20-%20ITALOCDSWS.mp3"},{"title":"27 - CAPA LOUCA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/27%20-%20CAPA%20LOUCA%20-%20ITALOCDSWS.mp3"},{"title":"28 - SEXTOU - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/28%20-%20SEXTOU%20-%20ITALOCDSWS.mp3"},{"title":"29 - AQUELE 1 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/29%20-%20AQUELE%201%20-%20ITALOCDSWS.mp3"},{"title":"30 - NOVINHA VAI NO CHAO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/30%20-%20NOVINHA%20VAI%20NO%20CHAO%20-%20ITALOCDSWS.mp3"},{"title":"31 - ESTILO NAMORADOR - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/31%20-%20ESTILO%20NAMORADOR%20-%20ITALOCDSWS.mp3"},{"title":"32 - FINAL DE SEMANA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/32%20-%20FINAL%20DE%20SEMANA%20-%20ITALOCDSWS.mp3"},{"title":"33 - PAREDAO - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/33%20-%20PAREDAO%20-%20ITALOCDSWS.mp3"},{"title":"34 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/34%20-%20ITALOCDSWS.mp3"},{"title":"35 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/35%20-%20ITALOCDSWS.mp3"},{"title":"36 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/36%20-%20ITALOCDSWS.mp3"},{"title":"37 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/37%20-%20ITALOCDSWS.mp3"},{"title":"38 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/38%20-%20ITALOCDSWS.mp3"},{"title":"39 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/39%20-%20ITALOCDSWS.mp3"},{"title":"40 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/40%20-%20ITALOCDSWS.mp3"},{"title":"41 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/41%20-%20ITALOCDSWS.mp3"},{"title":"42 - LOKETA - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/42%20-%20LOKETA%20-%20ITALOCDSWS.mp3"},{"title":"43 - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/43%20-%20ITALOCDSWS.mp3"},{"title":"44 - MEU CORACAO DEU PT - ITALOCDSWS.mp3","url":"http:\/\/file2.files.suamusica.com.br\/41261\/1349894\/44%20-%20MEU%20CORACAO%20DEU%20PT%20-%20ITALOCDSWS.mp3"}]}', true);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="referrer" content="no-referrer" />
    <title>Teste</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <style>
        .music-list {
            margin-top: 30px;
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
            background-color: #0275d8;
            padding-bottom: 25px;
        }
        audio {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container music-list">
        <div class="row">
            <div class="col-xs-8 offset-xs-2">
                <form>
                    <div class="form-group">
                        <input type="text" id="ipt-url" class="form-control" placeholder="Enter URL">
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
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

            <div class="col-xs-4 offset-xs-1 player-box">
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
        function log(val) {
            return console.log(val)
        }
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
