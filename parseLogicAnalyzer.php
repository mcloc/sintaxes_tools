<?php


function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
}
function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
      $dec = hexdec($hex[$i].$hex[$i+1]);

      if($dec > 31 && $dec < 126)
        $string .= chr($dec);


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


$txt = file_get_contents($argv[1]);

$msg_arr = explode("\n", $txt);

$SI_MSG = array();
$SO_MSG = array();

// Presuming the text has SI First line (ODDS) SO second and so far (EVEN)
$line_counter = 2;

foreach($msg_arr as $key => $msg_line) {
  $line = str_replace(" ", '', $msg_line);

  //Even Line it should be SI
  if($line_counter % 2 == 0) {
    //echo "EVEN";
    if(count(array_count_values(str_split($line))) != 1)
      $SI_MSG[$line_counter] = hexToStr($line);

  }

  //Even Line it should be SO
  if($line_counter % 2 != 0) {
    //echo "ODD";
    if(count(array_count_values(str_split($line))) != 1)
      $SO_MSG[$line_counter] = hexToStr($line);
  }

  $line_counter++;


}


$output = "";
/*for($i = 0;$i< $line_counter;$i++){
  if(array_key_exists($i, $SI_MSG))
    $output .= "[SI-$i]".$SI_MSG[$i]."\n";
  if(array_key_exists($i, $SO_MSG))
  $output .= "[SO-$i]".$SO_MSG[$i]."\n";
}*/

foreach($SI_MSG as $value)
  $output .= $value;

file_put_contents("logicAnalyzer_output.txt", $output);



?>
