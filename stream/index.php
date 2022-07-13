<?php
 //max_execution_time  120 / 504 Gateway Time-out
include_once '../app/config.php';

$ip = IP; // IP Radio in /app/config.php

if($_GET['port']){
	ini_set('display_errors', 1); // CHANGE VALUE TO 1 FOR RELEASES //

	echo $tenPercentOfFileInBytes;
	$streamToOpen = $ip; //ip server radio
	$port = $_GET['port']; // port radio
	$path = "/;"; // stream example ip:port/;

	header("Content-type: audio/mpeg");
	$socket = fsockopen($streamToOpen,$port);
	$ips = ipAddr();
	fputs($socket, "GET $path HTTP/1.0\r\n");
	fputs($socket, "Host: $streamToOpen\r\n");
	fputs($socket, "User-Agent: $ips\r\n");
	fputs($socket, "Accept: */*\r\n");
	fputs($socket, "Connection: close\r\n\r\n");

	while (!feof($socket)) {
	$buffer = fgets($socket, 4096);
	echo $buffer;
	}

	$totalSize = 0;
	for ($i=0; $i < $tenPercentOfFileInBytes; ) {
	$buffer = fgets($socket);
	$strSize = strlen($buffer);
	$totalSize = $totalSize + $strSize;
	echo "$strSize \n";
	$i = $i + $strSize;
	echo $buffer;
	}

	fclose($socket);
}else{
	echo 'Example : /port (domain/stream/8000)';
}
function ipAddr(): string {
			return array_key_exists("HTTP_CF_CONNECTING_IP", $_SERVER) 
				? $_SERVER["HTTP_CF_CONNECTING_IP"] 
				: $_SERVER['HTTP_USER_AGENT'];
		}
?>