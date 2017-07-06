<?php
$url = 'https://burghquayregistrationoffice.inis.gov.ie/Website/AMSREG/AMSRegWeb.nsf/(getApps4DTAvailability)?openpage&&cat=Study&sbcat=All&typ=New&_=1491146093977';
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);


$dates = json_decode($result)->slots;
function dump($value) {
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <!-- Metas -->
    <meta name="description" content="GNIB Appointment by Jefferson Santos"/>
    <meta name="author" content="GNIB Appointment by Jefferson Santos"/>
    <meta name="copyright" content="Santos Jefferson © 2017 Todos os Direitos Reservados"/>
    <meta name="application-name" content="jeffsantos.com.br"/>

    <meta property="ogtitle:" content="GNIB Appointment by Jefferson Santos"/>
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="https://jeffsantos.com.br/img/jefflssantos.jpg"/>
    <meta property="og:url" content="https://jeffsantos.com.br/gnib"/>
    <meta property="og:description" content="GNIB Appointment by Jefferson Santos"/>
    <meta property="article:author" content="https://www.facebook.com/Jeff.lssantos"/>
    <meta property="fb:admins" content="100001302304071"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="GNIB Appointment by Jefferson Santos"/>
    <meta name="twitter:description" content="GNIB Appointment by Jefferson Santos"/>
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
    
    <title>GNIB Appointment</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>
    <section class="container">
      <div class="row my-5">
        <div class="col-sm-12 col-md-6 offset-md-3">
          <h3 class="text-center my-3"><a href="https://burghquayregistrationoffice.inis.gov.ie/Website/AMSREG/AMSRegWeb.nsf/AppSelect?OpenForm" target="_blank" class="">GNIB</a></h3>
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
  </body>
</html>
