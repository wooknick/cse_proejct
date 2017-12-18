<?php
session_save_path("../session_save");
session_start();
include "db.php";

$member_no=$_SESSION["member_no"];
$account_name=$_POST["account_name"];
$account_init=$_POST["account_init"];
$account_init=preg_replace("/[^0-9]/", "", $account_init);
$account_balance=$account_init;
if($_POST["account_public"]=="opened"){
	$account_public="true";	
}else{
	$account_public="false";
}
$account_rate="100";

$sql="INSERT INTO account(member_no, account_init, account_balance, account_rate, account_public, account_name) VALUES($member_no, '$account_init', '$account_balance', '$account_rate', $account_public, '$account_name');";

if($connect -> query($sql) === TRUE){
	echo "
		<script>
			alert('성공적으로 계좌가 생성되었습니다.');
			location.href='../main.php';
		</script>
		";
}else{
	echo "
		<script>
			alert('계좌 생성 도중 오류가 발생했습니다. 다시 시도해주세요.');
			history.back();
		</script>
		";
}

$connect->close();
?>

<html>
	<head>
		<meta charset="utf-8" />
	</head>
</html>