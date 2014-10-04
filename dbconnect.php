<?php
$database = "";
$username = "";
$password = "";

$link = mysql_connect("localhost", $username, $password) or die ("Unable to connect to database.");
mysql_select_db($database, $link) or die ("Unable to to select database.");
?>
