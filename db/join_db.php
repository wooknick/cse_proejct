<html>
	<head>
		<meta charset="utf-8" />
	</head>
</html>

<?php
include "db.php";

$member_id=$_POST["join_id"];
$member_pw=$_POST["join_passwd"];
$member_name=$_POST["join_name"];

$sql="INSERT INTO member(member_id, member_pw, member_name) VALUES('$member_id', '$member_pw', '$member_name');";

if($connect -> query($sql) === TRUE){
	echo "
		<script>
			location.href='../join_complete.php';
		</script>
		";
}else{
	echo "
		<script>
			alert('회원가입 도중 오류가 발생했습니다. 다시 시도해주세요.');
			history.back();
		</script>
		";
}



$connect->close();
?>
	