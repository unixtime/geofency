<?php
/*** connect to database ***/
/*** pgsql hostname ***/
$pgsql_hostname = 'localhost';
/*** pgsql username ***/
$pgsql_username = 'geoadmin';
/*** pgsql password ***/
$pgsql_password = 'GeoAdmin123';
/*** database name ***/
$pgsql_dbname = 'geodb';
/*** select the users name from the database ***/
$dbh = new PDO("pgsql:host=$pgsql_hostname;dbname=$pgsql_dbname", $pgsql_username, $pgsql_password);
/*** set the error mode to excptions ***/
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*** select the users name from the database ***/
#$dbh = new PDO("pgsql:host=$pgsql_hostname;dbname=$pgsql_dbname", $pgsql_username, $pgsql_password);
/*** set the error mode to excptions ***/
#$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
