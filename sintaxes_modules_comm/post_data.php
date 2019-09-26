<?php
require __DIR__ . '/vendor/autoload.php';
use MessagePack\MessagePack;
use MessagePack\Packer;
use MessagePack\PackOptions;
use MessagePack\Type\Binary;
use MessagePack\TypeTransformer\BinaryTransformer;


define("MODULE_COMMMAND_FLAG",            0xFFFF0001);
define("MODULE_COMMMAND_ARGS_FLAG",       0xFFFF0002);
define("MODULE_COMMMAND_EXECUTE_FLAG",    0xFFFF0013);
define("MODULE_COMMMAND_GET_STATE",       0xFFFF0020);
define("MODULE_COMMMAND_GET_DATA",        0xFFFF0021);
define("MODULE_COMMAND_GET_PROCESS_FLOW", 0xFFFF0022);
define("MODULE_COMMMAND_SET_ACTUATOR",    0xFFFF0801);

define("MODULE_COMMMAND_SET_ARGS1", 0xFFFFF001);
define("MODULE_COMMMAND_SET_ARGS2", 0xFFFFF002);
define("MODULE_COMMMAND_SET_ARGS3", 0xFFFFF003);
define("MODULE_COMMMAND_SET_ARGS4", 0xFFFFF004);
define("MODULE_COMMMAND_SET_ARGS5", 0xFFFFF005);
define("MODULE_COMMMAND_SET_ARGS6", 0xFFFFF006);
define("MODULE_COMMMAND_SET_ARGS7", 0xFFFFF007);
define("MODULE_COMMMAND_SET_ARGS8", 0xFFFFF008);



define("MODULE_SENSOR_DTH21_1_1", 0xFFFF1001);
define("MODULE_SENSOR_DTH21_1_2", 0xFFFF1002);
define("MODULE_SENSOR_DTH21_1_3", 0xFFFF1003);
define("MODULE_ACTUATOR_DN20_1_1", 0xFFFF2001);
define("MODULE_ACTUATOR_DN20_1_2", 0xFFFF2002);
define("MODULE_ACTUATOR_DN20_1_3", 0xFFFF2003);



error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
//set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = '192.168.1.15';
$port = 80;

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}


socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 5, 'usec' => 0));
socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 5, 'usec' => 0));

echo "Attempting to connect to '$address' on port '$port'...";
$result = socket_connect($socket, $address, $port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}


//JSON
/*$msg = "\x02{\"command\":\"get_module_data\",\"data\":{".
		"\"argument1\":\"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",".
		"\"argument2\":\"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\",".
		"\"argument3\":\"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\"".
		"}".
	"}\x03";
#$msg = "\n";
*/

//Msgpack
/*$schema = [
    'command' => 'str',
    'values' => 'map',
    'last_name' => 'str',
];*/

$packer = new Packer(PackOptions::FORCE_BIN | PackOptions::DETECT_ARR_MAP);
//$packer->registerTransformer(new BinaryTransformer());

/*$payload = $packer->pack([
      MODULE_COMMMAND_FLAG => MODULE_COMMMAND_SET_ACTUATOR,
      MODULE_ACTUATOR_DN20_1_1 => array(
        MODULE_COMMMAND_SET_ARGS1 => true,
        MODULE_COMMMAND_SET_ARGS2 => 5788633
      )
    ]
);*/


$payload = $packer->pack([
      MODULE_COMMMAND_FLAG => MODULE_COMMMAND_GET_DATA,
      MODULE_COMMMAND_EXECUTE_FLAG => true
    ]
);

/*

MODULE_ACTUATOR_DN20_1_2 => array(
  MODULE_COMMMAND_SET_ARGS3 => false,
  MODULE_COMMMAND_SET_ARGS4 => 156789
)



MODULE_ACTUATOR_DN20_1_2 => $packer->packMap([
  MODULE_COMMMAND_SET_ARGS1 => true,
  MODULE_COMMMAND_SET_ARGS2 => 5788633
]),
MODULE_ACTUATOR_DN20_1_3 => $packer->packMap([
  MODULE_COMMMAND_SET_ARGS1 => true,
  MODULE_COMMMAND_SET_ARGS2 => 5788633
]),
MODULE_ACTUATOR_DN20_1_4 => $packer->packMap([
  MODULE_COMMMAND_SET_ARGS1 => true,
  MODULE_COMMMAND_SET_ARGS2 => 5788633
]),
MODULE_ACTUATOR_DN20_1_5 => $packer->packMap([
  MODULE_COMMMAND_SET_ARGS1 => true,
  MODULE_COMMMAND_SET_ARGS2 => 5788633
]),
MODULE_ACTUATOR_DN20_1_6 => $packer->packMap([
  MODULE_COMMMAND_SET_ARGS1 => true,
  MODULE_COMMMAND_SET_ARGS2 => 5788633
]),*/
/*
$payload = $packer->packExt(MODULE_COMMMAND_FLAG, MODULE_COMMMAND_SET_ACTUATOR);
$argspayload = $packer->packMap(
  array(
    MODULE_ACTUATOR_DN20_1_1 =>  array(
        MODULE_COMMMAND_SET_ARGS1 => true,
        MODULE_COMMMAND_SET_ARGS2 => 5788633
    )
  )
);
$payload .= $argspayload;


$payload .= $packer->packExt(MODULE_COMMMAND_ARGS_FLAG, $argspayload);
$argspayload = $packer->packMap(
  array(
    MODULE_ACTUATOR_DN20_1_2 =>  array(
        MODULE_COMMMAND_SET_ARGS1 => false,
        MODULE_COMMMAND_SET_ARGS2 => "\xc0"
    )
  )
);
$payload .= $argspayload;

$payload = $packer->packExt(MODULE_COMMMAND_FLAG, MODULE_COMMMAND_SET_ACTUATOR);
$argspayload = $packer->packMap(
  array(
    MODULE_ACTUATOR_DN20_1_3 =>  array(
        MODULE_COMMMAND_SET_ARGS1 => true,
        MODULE_COMMMAND_SET_ARGS2 => 3200000
    )
  )
);
$payload .= $argspayload;
*/

//working
/*$msg_packed2 = $packer->packMap(
  [

    MODULE_COMMMAND_ARGS_FLAG =>
          MODULE_ACTUATOR_DN20_1_2 => array(
            MODULE_COMMMAND_SET_ARGS1 => false,
            MODULE_COMMMAND_SET_ARGS2 => "\xc0", // Nil value on MessagePack
          ),
          MODULE_ACTUATOR_DN20_1_3 => array(
            MODULE_COMMMAND_SET_ARGS1 => true,
            MODULE_COMMMAND_SET_ARGS2 => 3200,
          ),
    )
  ]
);
*/





//echo $msg_packed."\n";
//$packed2 = "\x02".$msg_packed2."\x03";
//$array2 = unpack("H*", $packed2);

//$packed2 = "\x02".$payload."\x03";
$packed2 = $payload;
$array2 = unpack("H*", $payload);
$array3 = unpack("C*", $payload);


$foo = NULL;
//foreach($array2 as $byte){
//    $foo = unpack("H", $array2[0])."\n";
//    echo $foo;
//}
//print_r($packed);





echo "streln(pack): ".strlen($packed2)."\n";
echo "array split count(pack): ".sizeof($array2)."\n";
print_r($array2);
print_r($array3);
echo "\n";
echo $payload;

echo "\n";
echo "\n";


echo "Sending HTTP HEAD request...";
socket_write($socket, $payload, strlen($payload)); //msgpag

echo "Reading response:\n\n";
while ($out = socket_read($socket, 2048)) {
    echo $out;
}

echo "\nClosing socket...\n";
//socket_close($socket);

?>
