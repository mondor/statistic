<?php

require('fpdf17/fpdf.php');

define('BATIK_PATH', 'batik-1.7/batik-rasterizer.jar');


$svgs = $_POST['svgs'];
$jsons = $_POST['jsons'];

$typeString = '-m application/pdf';

$width = "-w 800";

$i = 1;

if (count($svgs) > 0) {
 foreach ($svgs as $s) {

  if (!file_put_contents("temp/$i.svg", $s)) {
   echo "can't save temp/$i.svg";
  }

  $outfile = "temp/$i.pdf";

  $output = shell_exec("java -Djava.awt.headless=true -jar " . BATIK_PATH . " $typeString -d $outfile $width temp/$i.svg 2>&1 1> /dev/null");

  //unlink("temp/$i.svg");

  $i++;
 }
}


if(count($jsons) > 0){
 
 foreach($jsons as $i => $json){
  $obj = unserialize($json);
  print_r($obj);
  
 }
 
}


?>
