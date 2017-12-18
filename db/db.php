<?php
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
?>