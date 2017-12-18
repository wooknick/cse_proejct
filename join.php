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
		<script>
			function check_id() {
				try_id = document.forms["join_form"]["join_id"].value;
			    if (try_id == "") {
			        document.getElementById("join_id_check").innerHTML = "사용할 아이디를 입력해주세요.";
			        document.getElementById("join_id_check").style.color = "red";
			        return;
			    }else{ 
			        if(window.XMLHttpRequest){
			            xmlhttp = new XMLHttpRequest();
			        }else{
			            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			        }
			        xmlhttp.onreadystatechange = function(){
			            if (this.readyState == 4 && this.status == 200){
			                document.getElementById("join_id_check").innerHTML = this.responseText;
							if(document.getElementById("join_id_check").innerHTML == "사용할 수 있는 아이디입니다."){
								document.getElementById("join_id_check").style.color = "blue";
							}else{
								document.getElementById("join_id_check").style.color = "red";
							}
			            }
			        };
			        xmlhttp.open("POST","./db/id_check_ajax.php",true);
			        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			        xmlhttp.send("try_id="+try_id);
			    }
			}
			
			function check_passwd() {
				try_passwd = document.forms["join_form"]["join_passwd"].value;
				try_passwd_repeat = document.forms["join_form"]["join_passwd_repeat"].value;
				if (try_passwd == "" || try_passwd_repeat == "") {
			        document.getElementById("join_passwd_check").innerHTML = "비밀번호를 입력해주세요.";
			        document.getElementById("join_passwd_check").style.color = "red";
			        return;
			    }else if (try_passwd == try_passwd_repeat) {
			        document.getElementById("join_passwd_check").innerHTML = "비밀번호가 일치합니다.";
			        document.getElementById("join_passwd_check").style.color = "blue";
			        return;
			    }else{ 
				    document.getElementById("join_passwd_check").innerHTML = "비밀번호가 일치하지 않습니다.";
			        document.getElementById("join_passwd_check").style.color = "red";
			        return;
				}
			}
			
			
			function make_submit_possible() {
				if(document.getElementById("join_id_check").innerHTML == "사용할 수 있는 아이디입니다." && document.getElementById("join_passwd_check").innerHTML == "비밀번호가 일치합니다."){
					document.getElementById("join_submit").disabled = false;
				}else{
					document.getElementById("join_submit").disabled = true;
				}
			}
			
		</script>
	</head>
	<body>
		<div id="wrap">
			<div id="common_top">
				<div id="backward_arrow" onclick=back();> <img src="./icon/Backward arrow.png"> </div>
				<div id="common_title"> 회원으로 가입하세요. </div>
			</div>
			<div id="common_bottom">
				<form id="join_form" name="join_form" method="post" action="./db/join_db.php" onsubmit="return check_form()">
					<div id="login_buttons">
						<input id="join_id" name="join_id" type="text" class="blank_input" placeholder="example@sogang.ac.kr" oninput="check_id()" onchange="make_submit_possible()" required>
						<p id="join_id_check">사용할 아이디를 입력해주세요.</p>
						<input id="join_passwd" name="join_passwd" type="password" class="blank_input" placeholder="password" required>
						<input id="join_passwd_repeat" name="join_passwd_repeat" type="password" class="blank_input" placeholder="repeat password" oninput="check_passwd()" onchange="make_submit_possible()" required>
						<p id="join_passwd_check">비밀번호를 입력해주세요.</p>
						<input id="join_name" name="join_name" type="text" class="blank_input" placeholder="이름" required>
						<hr>
						<input id="join_submit" type="submit" class="input" value="가입하기" disabled>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>