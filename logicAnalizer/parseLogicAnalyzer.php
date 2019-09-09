<?php

$string_bytes = array(
  32,
  48,
  49,
  50,
  51,
  52,
  53,
  54,
  55,
  56,
  57,
  58,
  65,
  66,
  67,
  68,
  69,
  70,
  71,
  72,
  73,
  74,
  75,
  76,
  77,
  78,
  79,
  80,
  81,
  82,
  83,
  84,
  85,
  86,
  87,
  88,
  89,
  90,
  97,
  98,
  99,
  100,
  101,
  102,
  103,
  104,
  105,
  106,
  107,
  108,
  109,
  110,
  111,
  112,
  113,
  114,
  115,
  116,
  117,
  118,
  119,
  120,
  121,
  122,
  123,
  124,
  125
);


function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
}
function hexToStr($hex,$string_bytes){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
      $dec = hexdec($hex[$i].$hex[$i+1]);

      if(in_array($dec, $string_bytes))
        $string .= chr($dec);
      //$string .= ord("\\x".$hex[$i]."\\x".$hex[$i+1]);

      /*if($dec > 31 && $dec < 126)
        $string .= "\e[0;36;1m".chr($dec)."\e[0m";
      else
        $string .= dechex($dec);*/
    }
    return $string;
}

if(sizeof($argv) != 2 || $argv[1] == '' || !is_file($argv[1])){
  echo "usage: parseLogicaAnalizer.php FILE_TO_PARSE\n";
  exit;
}

/*$in = "52";
$output = hexToStr($in,$string_bytes)." ";
file_put_contents("logicAnalyzer_output.txt", $output);
die();*/


$txt = file_get_contents($argv[1]);

$msg_arr = explode("\n", $txt);

$SI_MSG = array();
$SO_MSG = array();

// Presuming the text has SI First line (ODDS) SO second and so far (EVEN)
$line_counter = 1;

foreach($msg_arr as $key => $msg_line) {
  $line_counter++;
  $line = str_replace(" ", '', $msg_line);


  if(count(array_count_values(str_split($line))) == 1)
    continue;

  if($line_counter % 2 == 0) {
    //echo "EVEN";
      //$SI_MSG[$line_counter] .= char("\\x".$byte)." ";
      $SI_MSG[$line_counter] = hexToStr($line,$string_bytes)." ";

  }

  //Even Line it should be SO
  if($line_counter % 2 != 0) {
    //echo "ODD";
      $SO_MSG[$line_counter] = hexToStr($line,$string_bytes)." ";
      //$SO_MSG[$line_counter] .= char("\\x".$byte)." ";
  }
  /*
  $line_arr = explode(" ",$msg_line);
  foreach($line_arr as $byte){
    //Even Line it should be SI
    if($line_counter % 2 == 0) {
      //echo "EVEN";
        //$SI_MSG[$line_counter] .= char("\\x".$byte)." ";
        $SI_MSG[$line_counter] .= hexToStr($byte)." ";

    }

    //Even Line it should be SO
    if($line_counter % 2 != 0) {
      //echo "ODD";
        $SO_MSG[$line_counter] .= hexToStr($byte)." ";
        //$SO_MSG[$line_counter] .= char("\\x".$byte)." ";
    }
  }*/



  $line_counter++;


}


$output1 = "";
$output2 = "";
for($i = 0;$i< $line_counter;$i++){
  if(array_key_exists($i, $SI_MSG))
    $output1 .= $SI_MSG[$i];
  if(array_key_exists($i, $SO_MSG))
    $output2 .= $SO_MSG[$i];
}

/*foreach($SI_MSG as $value)
  $output .= $value;*/

file_put_contents("logicAnalyzer_outputSI.txt", $output1);
file_put_contents("logicAnalyzer_outputSO.txt", $output2);



?>
