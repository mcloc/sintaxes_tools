<?php

if(sizeof($argv) != 2 || $argv[1] == '' || !is_file($argv[1])){
  echo "usage: parseLogicaAnalizer.php FILE_TO_PARSE\n";
  exit;
}

$input = file_get_contents($argv[1]);

$lines = explode("\n", $input);
$MOSI = array();
$MISO = array();
foreach($lines as $line_number => $raw_value){

  $string   = str_replace('SPI,MOSI:','',$raw_value);
  $string   = str_replace('MISO:','',$string);
  $columns = explode(";", $string);

  $MOSI[] = $columns[0];
  $MISO[] = $columns[1];
}


$stringSI = "";
$stringSO = "";
foreach($MOSI as $line_number => $value){
  $stringSI .= $value;
  $stringSO .= $MISO[$line_number];
}

$ouput = $stringSI."\n".$stringSO;

file_put_contents('saleae-parsed.txt', $ouput);

 ?>
