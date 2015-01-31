<?php // configexample.php

// connect to MySQL database

$dbhost = 'localhost';
$dbname = 'db';
$dbuser = 'dbuser';
$dbpass = 'password';
$appname = 'J-Ello';

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

?>