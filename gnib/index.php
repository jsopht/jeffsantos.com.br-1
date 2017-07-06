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


  </body>
</html>
