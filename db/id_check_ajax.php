<?php
//echo $_POST["try_id"];

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
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

$try_id = "";
$try_id = $_POST["try_id"];

$sql = "SELECT * FROM member WHERE member_id = '".$try_id."';";

$result = $connect->query($sql);

if($result->num_rows > 0){
	echo "아이디가 중복됩니다. 다른 아이디를 입력해주세요.";
}else{
	echo "사용할 수 있는 아이디입니다.";
}

$connect->close() ;

?>