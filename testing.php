<?php
$db_host = '127.0.0.1'; //Instead of localhost because it is a non standard port
$db_port = 8889; //MAMP's port for MySQL
$db_name = 'buyingiq';
$db_user = 'root'; //Of course I have my own username in here
$db_pass = 'root'; //Same as above
$table_n = 'audit';

$str = "mysql:host=$db_host;port=$db_port;dbname=$db_name";

$dbh = new PDO( $str, $db_user, $db_pass);

?>