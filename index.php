<?php
	include "session_join.php";
?>
<html>
	<head>
		<meta charset="utf-8">
		<title> 모두의 주식 </title>
		<link href="./css/common.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script language="javascript" src="./js/myscript.js"></script>
	</head>
	<body>
		<div id="wrap">
			<div id="login_top">
				<div id="login_title"> 모두의 주식 </div>
			</div>
			<div id="login_bottom">
				<form id="login_form" method="post" action="./db/login_db.php">
					<div id="login_buttons">
						<input id="login_id" name="login_id" type="text" class="blank_input" placeholder="example@sogang.ac.kr" required>
						<input id="login_passwd" name="login_passwd" type="password" class="blank_input" placeholder="password" required>
						<hr>
						<input id="login_button" type="submit" class="input" value="로그인">
						<input id="join_button" type="button" class="input" onclick="to_join()" value="회원가입">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>