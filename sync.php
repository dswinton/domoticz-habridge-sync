#!/usr/bin/php
<?php

// CONFIUGRATION

//The path to your ha-bridge installation
$haBridgePath = "/opt/ha-bridge";

//The root URL of your domoticz installation
$domoticzUrl = "http://domoticz.local:8080";


// END CONFIUGRATION

$dbPath = $haBridgePath.'/data/device.db';

//Get device list from Domoticz
echo "Fetching device list from Domoticz @ ".$domoticzUrl."\n";
$domoJson = file_get_contents($domoticzUrl.'/json.htm?type=devices&filter=light&used=true&order=Name');
$dArray = json_decode($domoJson,true);
$domoDevList = $dArray['result'];


//Get current device list from config file
//$currentJson = file_get_contents($haBridgePath.'/data/device.db');
//$cArray = json_decode($currentJson,true);


//Check we got devices
if(!count($domoDevList)){

	echo "No devices returned from Domoticz.  Make sure configuration is correct in sync.php and make sure you have devices added to your favourites in Domoticz.\n";
	exit;

};


$i = 1;
foreach($domoDevList as $dd){

	if($dd['Favorite']){

		//Generate a device entry in ha-bridge format
		$oA[] = array(

         	   'id' => $i,
         	   'uniqueid' => '00:17:88:5E:D3:01-01',
         	   'name' => $dd['Name'],
         	   'deviceType' => 'custom',
         	   'targetDevice' => 'Encapsulated',
         	   'offUrl' => $domoticzUrl.'/json.htm?type=command&param=switchlight&idx='.$dd['idx'].'&switchcmd=Off',
         	   'onUrl' => $domoticzUrl.'/json.htm?type=command&param=switchlight&idx='.$dd['idx'].'&switchcmd=On'

		);
	

		echo 'Added device "' . $dd['Name'] . '"' . "\n";

		$i++;

	};

};

//Encode to JSON and dump to config file
$oT = json_encode($oA);
file_put_contents($dbPath,$oT);

echo "Wrote ".($i-1)." devices to ".$dbPath."\n";

?>
