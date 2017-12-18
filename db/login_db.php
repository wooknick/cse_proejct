<?php
session_save_path("../session_save");
session_start();
include "db.php";

$member_id=$_POST["login_id"];
$member_pw=$_POST["login_passwd"];
$member_name="";
$member_no="";

$sql="SELECT * FROM member WHERE member_id='$member_id' and member_pw='$member_pw';";

$result = $connect -> query($sql);

if($result->num_rows == 1){
	$row = $result->fetch_object();
	$_SESSION["member_id"] = $member_id;
	$_SESSION["member_pw"] = $member_pw;
	$member_name = $row->member_name;
	$member_no = $row->member_no;
	$_SESSION["member_name"] = $member_name;
	$_SESSION["member_no"] = $member_no;
	
	echo "
		<script>
			alert('$member_name 님, 환영합니다.');
			location.href='../main.php';
		</script>
		";
}else{
	echo "
		<script>
			alert('로그인에 실패했습니다. 아이디와 비밀번호를 확인해주세요.');
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

	