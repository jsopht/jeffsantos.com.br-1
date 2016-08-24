<?php

$date1 = new DateTime("2010-07-06");
$date2 = new DateTime("2010-07-09");

$diff = $date2->diff($date1)->format("%a");

echo $diff;