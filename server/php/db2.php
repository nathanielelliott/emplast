<?php

$db_host = 'localhost';
$db_name = 'djakata_jargon_hunter';
$db_user = 'djakata_jargon2';
$db_pass = 'P@$sW0rd2';
$db_conn_string = "";

$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $link);
?>