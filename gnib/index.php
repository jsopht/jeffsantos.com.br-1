<?php

$type = 'New';

if (queryHas('renew')) {
  $type = 'Renewal';
}

$url = "https://burghquayregistrationoffice.inis.gov.ie/Website/AMSREG/AMSRegWeb.nsf/(getApps4DTAvailability)?openpage&&cat=Study&sbcat=All&typ={$type}&_=1491146093977";

$dates = request($url)->slots;

if (count($dates) < 2) {
  $dates = ['Appointment dates not available now, try later.'];
}

function request($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL,$url);
  $response = curl_exec($ch);
  curl_close($ch);

  return json_decode($response);
}

function queryHas($val) {
  if (isset($_GET[$val]) && $_GET[$val] == 'true') {
    return true;
  }

  return false;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Metas -->
    <meta name="description" content="GNIB Appointment by @jefflssantos"/>
    <meta name="author" content="GNIB Appointment by @jefflssantos"/>
    <meta name="copyright" content="Santos Jefferson © 2017 Todos os Direitos Reservados"/>
    <meta name="application-name" content="jeffsantos.com.br"/>

    <meta property="ogtitle:" content="GNIB Appointment by @jefflssantos"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="https://jeffsantos.com.br/img/jefflssantos.jpg"/>
    <meta property="og:url" content="https://jeffsantos.com.br/gnib"/>
    <meta property="og:description" content="GNIB Appointment by @jefflssantos"/>
    <meta property="article:author" content="https://www.facebook.com/Jeff.lssantos"/>
    <meta property="fb:admins" content="100001302304071"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="GNIB Appointment by @jefflssantos"/>
    <meta name="twitter:description" content="GNIB Appointment by @jefflssantos"/>
    <meta name="twitter:image" content="https://jeffsantos.com.br/img/jefflssantos.jpg">

    <link rel="apple-touch-icon" sizes="57x57" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://jeffsantos.com.br/img/favicon/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="https://jeffsantos.com.br/img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://jeffsantos.com.br/img/favicon/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="https://jeffsantos.com.br/img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="https://jeffsantos.com.br/img/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="https://jeffsantos.com.br/img/favicon/manifest.json">
    <link rel="mask-icon" href="https://jeffsantos.com.br/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="https://jeffsantos.com.br/img/favicon/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>GNIB Appointment by @jefflssantos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <style>
      body, h1, h2, h3, h4, h5, h6,
      button, input, optgroup, select, textarea {
        font-family: "Source Sans Pro","Helvetica Neue",Calibre,Helvetica,Arial,sans-serif;
        font-weight: 300;
      }

      body {
        font-size: 16px;
        line-height: 24px;
        background-color: #f5f5f5;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
      }
    </style>
  </head>
  <body>
    <section class="container">

      <div class="row">
        <div class="col-sm-12 my-5 text-center">
          <h3 class="mb-0"><strong class="">GNIB Appointment</strong></h3>
          <a href="https://www.facebook.com/jefflssantos"><small class="text-muted">by Jefferson Santos</small></a>
        </div>
      </div>

      <div class="row">

        <div class="col-sm-12 col-md-6 col-lg-4 my-2">
          <form>
            <div class="form-group">
              <label for="input-type">I have a GNIB card or I have been registered before:</label>
              <select class="form-control" id="input-type" name="renew">
                <option value="false">No</option>
                <option value="true" <?php if(queryHas('renew')): ?> selected <?php endif; ?> >Yes</option>
              </select>
            </div>
            <div class="form-group">
              <label for="input-countdown">Auto Refresh <?php if(queryHas('refresh')): ?><?php endif; ?></label>
              <select class="form-control" id="input-countdown" name="refresh">
                <option value="false">No</option>
                <option value="true" <?php if(queryHas('refresh')): ?> selected <?php endif; ?> >Yes</option>
              </select>
            </div>
          </form>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-8 my-2">
          <div class="text-right mb-2">
            <?php if(queryHas('refresh')): ?>
                Refresh in <span class="btn btn-outline-warning btn-sm">00:<span id="countdown">59</span></span>
              <?php endif; ?>
          </div>
          <div class="list-group">
            <?php foreach ($dates as $date): ?>
              <a href="https://burghquayregistrationoffice.inis.gov.ie/Website/AMSREG/AMSRegWeb.nsf/AppSelect?OpenForm" target="_blank" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="w-100 text-center">
                  <h5 class="py-3 mb-0 lead date"><?= $date ?></h5>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

      </div>

    </section>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-99029729-1', 'auto');
      ga('send', 'pageview');
    </script>

    <?php if(queryHas('refresh')): ?>
      <script>
        var i = 59;
        setInterval(function() {
          if (i == 0) {
            return location.reload();
          }
          document.querySelector('#countdown').innerHTML -= 1;
          i--;
        }, 1000)
      </script>
    <?php endif; ?>

    <script>
      document.querySelector('form').onchange = function() {
        this.submit();
      }
    </script>
  </body>
</html>
