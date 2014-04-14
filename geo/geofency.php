<?php
include_once '../admin/lib/DB.php'; 
$locationid = addslashes($_REQUEST['id']);
$name	    = addslashes($_REQUEST['name']);
$device     = addslashes($_REQUEST['device']);
$entry	    = addslashes($_REQUEST['entry']);
$latitude   = addslashes($_REQUEST['latitude']);
$longitude  = addslashes($_REQUEST['longitude']);
$radius	    = addslashes($_REQUEST['radius']);
$client     = $_SERVER['REMOTE_ADDR'];

$stmt  = $dbh->prepare("INSERT INTO geodata (name, entry, device, locationid, latitude, longitude, radius, datetime) 
			values ('".$name."','".$entry."', '".$device."', '".$locationid."', '".$latitude."', '".$longitude."', '".$radius."', now());");
$stmt->execute();
if ( $stmt === false ){
	echo "DB Error";
} else {
	echo "Data received successfully from ".$client;
}
$stmt->closeCursor();
?>
