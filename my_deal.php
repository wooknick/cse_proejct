<?php
include "session.php";
include "./db/db.php";

$member_no=$_SESSION["member_no"];
$account_no=$_GET["account_no"];
$account_name=$_GET["account_name"];

$sql="SELECT * FROM account WHERE member_no=$member_no;";
$result = $connect -> query($sql);

if($result->num_rows >= 1){
	$account_exist = true;
	$account_name="계좌를 선택해 주세요.";
}

if(isset($_GET["account_name"])){
	$account_name = $_GET["account_name"];
}

?>

<html>
	<head>
		<meta charset="utf-8">
		<title> 모두의 주식 </title>
		<link href="./css/common.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script language="javascript" src="./js/myscript.js"></script>
		<script>
			window.onload = function(){
				var tv = parseInt(document.getElementById("total_value").innerHTML);
				tv = number_format(tv);
				document.getElementById("total_value").innerHTML = tv;
			}
		</script>
	</head>
	<body>
		<div id="wrap">
			<div id="common_nav">
				<div id="backward_arrow_color" onclick="back()"> <img src="./icon/Backward arrow color.png"> </div>
				<div id="home_button" onclick="to_main()"> <?php echo $_SESSION["member_name"]; ?> 님 </div>
				<div id="add_account" onclick="to_create_account()"> <img src="./icon/Add.png"> </div>
			</div>
			<div id="common_account">
				<div class="dropdown">
					<button onclick="myFunction()" class="dropbtn"><?php echo $account_name; ?></button>
					<div id="myDropdown" class="dropdown-content">
<?php
if($account_exist){
	while($row = $result->fetch_object()){
		$account_name_a = $row->account_name;
		$account_no_a = $row->account_no;
		echo "<a href='my_deal.php?account_no=$account_no_a&account_name=$account_name_a'> $account_name_a </a>";
	}
}
?>	
					</div>
				</div>
			</div>
			<div id="common_content">
				<form id="search_form" method="post" action="./search_list.php?account_no=<?php echo $account_no; ?>&account_name=<?php echo $account_name; ?>">
					<div class="common_line">
						<input id="search" name="search" type="text" class="search_input" placeholder="검색할 종목을 입력하세요.">
						<input type="submit" value="검색" class="search_button">
					</div>
				</form>
				<div id="my_account_content">
					<iframe id="my_account_iframe" src="./get_deal.php?account_no=<?php echo $account_no; ?>&account_name=<?php echo $account_name; ?>" scrolling="yes"></iframe>
				</div>
				<br>
<?php
$sql="SELECT * FROM account WHERE account_no=$account_no;";
$result = $connect -> query($sql);
while($row = $result->fetch_object()){
	$account_balance = $row->account_balance;
}
?>
				
			</div>
			<div id="common_blank">
				<p> [ 거래내역 확인 ] </p>
			</div>
		</div>
	</body>
	
</html>