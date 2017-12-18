<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="utf-8"/>
</head>

<?php
ini_set("display_errors", "1");
session_save_path("session_save");
session_start();
session_destroy();

echo "
		<script>
			alert('로그아웃되었습니다.');
			location.href='./index.php';
		</script>
	";
?>


