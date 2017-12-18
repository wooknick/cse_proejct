<?php
include "session.php";
?>


<html>
	<head>
		<meta charset="utf-8">
		<title> 모두의 주식 </title>
		<link href="./css/common.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script language="javascript" src="./js/myscript.js"></script>
	</head>
	<body>
		<div id="wrap">
			<div id="common_top">
				<div id="backward_arrow" onclick="back()"> <img src="./icon/Backward arrow.png"> </div>
				<div id="common_title"> 계좌를 만드세요. </div>
			</div>
			<div id="common_bottom">
				<form id="create_account_form" method="post" action="./db/create_account_db.php">
					<div id="login_buttons">
						<input id="account_name" name="account_name" type="text" class="blank_input" placeholder="계좌명(별명)" required>
						<input id="account_init" name="account_init" type="text" class="blank_input" placeholder="10,000,000원" required><br>
						<label class="radio-inline">
							<input class="radiobtn" type="radio" name="account_public" value="opened" checked> 공개 </input>
						</label>
						<label class="radio-inline">
							<p>    </p>
						</label>
						<label class="radio-inline">
							<input class="radiobtn" type="radio" name="account_public" value="closed"> 비공개 </input>
						</label>
						<hr>
						<input type="submit" class="input" value="계좌 생성하기">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>