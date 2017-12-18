<?php
//echo $_POST["try_id"];

/*
error_reporting(E_ALL);
ini_set("display_errors", 1);

//DB 연결
$hostname = "localhost";
$username = "cs20110882";
$password = "dbpass";
$dbname = "db20110882";

$connect = new mysqli($hostname, $username, $password, $dbname) 
     or die("DB Connection Failed");
//DB 연결 끝
*/
include "db.php";

$stock_code = $_POST["stock_code"];
$command = "python ../py/beautifulsoup4-4.4.1-py2.7/get_price.py ".$stock_code;
$output = system($command);
$connect->close() ;

?>