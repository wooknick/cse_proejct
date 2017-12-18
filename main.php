<?php
include "session.php";
include "./db/db.php";

$member_no=$_SESSION["member_no"];
$account_name="계좌 없음";
$account_exist = false;

$sql="SELECT * FROM account WHERE member_no=$member_no;";
$result = $connect -> query($sql);

if($result->num_rows >= 1){
	$account_exist = true;
	$account_name="계좌를 선택해 주세요.";
}
if(isset($_GET["account_name"])){
	$account_name = $_GET["account_name"];
}
if(isset($_GET["account_no"])){
	$account_no = $_GET["account_no"];
}else{
	$account_no = 0;
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
			function go_detail(stock_code, stock_name){
				document.location='stock_detail.php?account_no=<?php echo $account_no;?>&account_name=<?php echo $account_name;?>&stock_code='+stock_code+'&stock_name='+stock_name;
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
		echo "<a href='main.php?account_no=$account_no_a&account_name=$account_name_a'> $account_name_a </a>";
	}
}
?>	
					</div>
				</div>
			</div>
			<div id="common_content">
<?php
if(!$account_exist){
?>
				<p> + 버튼을 눌러 계좌를 생성해 주세요. </p>
				<div class="common_line">
						<div class="number_box" onclick="logout()" style="cursor:	pointer">
							Logout
						</div>
				</div>
<?php
}else if(isset($_GET["account_no"])){
	$account_no = $_GET["account_no"];
	$sql="SELECT * FROM account WHERE member_no=$member_no and account_no=$account_no;";
	$result = $connect -> query($sql);
	$row = $result->fetch_object();
	$account_rate = $row->account_rate;
	$account_init = $row->account_init; 
	$account_balance = $row->account_balance;
	
	$sql2="SELECT stock_name, stock_quantity, stock_code FROM account_state, stock WHERE account_no=$account_no and stock.stock_no = account_state.stock_no;";
	$result2 = $connect -> query($sql2);
	$total_value=0;
	
	while($row2 = $result2->fetch_object()){
		$stock_name = $row2->stock_name;
		$stock_quantity = $row2->stock_quantity;
		$stock_code = $row2->stock_code;
		$command = "python ./py/beautifulsoup4-4.4.1-py2.7/get_price.py ".$stock_code;
		$price = exec($command);
		$price_string = preg_replace("/[^0-9]/", "", $price);
		$each_value = (int)$price_string * (int)$stock_quantity;
		$total_value = $total_value + $each_value;
		$each_value = number_format($each_value);
	}	
?>
				<div class="common_line">
					<div class="left">
						<p class="item_name"> 계좌번호 </p>
						<a href="./my_deal.php?account_no=<?php echo $account_no; ?>&account_name=<?php echo $account_name; ?>" >
						<div class="number_box" style="cursor:pointer">
							<?php echo $account_no; ?>
						</div>
						</a>
					</div>
					<div class="right">
						<p class="item_name"> 수익률 </p>
						<div class="number_box">
							<?php echo $account_rate; ?> %
						</div>
					</div>
				</div>
				<br>
				<div class="common_line">
					<div class="left">
						<p class="item_name"> 초기 금액 </p>
						<div class="number_box">
							<?php echo number_format($account_init); ?> 원
						</div>
					</div>
					<div class="right">
						<p class="item_name"> 주식 가치 </p>
						<div class="number_box">
							<?php echo number_format($total_value); ?> 원
						</div>
					</div>
				</div>
				<br>
				<div class="common_line">
					<div class="left">
						<p class="item_name"> 보유 현금 </p>
						<div class="number_box">
							<?php echo number_format($account_balance); ?> 원
						</div>
					</div>
					<div class="right">
						<p class="item_name"> 로그아웃 </p>
						<div class="number_box" onclick="logout()" style="cursor:	pointer">
							Logout
						</div>
					</div>
				</div>
				<br>
				<div class="common_line">
<?php
$command = "python ./py/beautifulsoup4-4.4.1-py2.7/get_top3.py";
$get_up_down = exec($command);
$up_down = explode("/",$get_up_down);
?>					

					<div class="full">
						<p class="top3"> 주가 상승중인 종목 Top 3 </p>
						<div class="top3_up" onClick="go_detail(<?php echo "'".$up_down[1]."', '".$up_down[0]."'";?>)"><?php echo $up_down[0];?></div>
						<div class="top3_blank"></div>
						<div class="top3_up" onClick="go_detail(<?php echo "'".$up_down[3]."', '".$up_down[2]."'";?>)"><?php echo $up_down[2];?></div>
						<div class="top3_blank"></div>
						<div class="top3_up" onClick="go_detail(<?php echo "'".$up_down[5]."', '".$up_down[4]."'";?>)"><?php echo $up_down[4];?></div>	
					</div>				
				</div>
				<br>
				<div class="common_line">
					<div class="full">
						<p class="top3"> 주가 하락중인 종목 Top 3 </p>
						<div class="top3_down" onClick="go_detail(<?php echo "'".$up_down[7]."', '".$up_down[6]."'";?>)"><?php echo $up_down[6];?></div>
						<div class="top3_blank"></div>
						<div class="top3_down" onClick="go_detail(<?php echo "'".$up_down[9]."', '".$up_down[8]."'";?>)"><?php echo $up_down[8];?></div>
						<div class="top3_blank"></div>
						<div class="top3_down" onClick="go_detail(<?php echo "'".$up_down[11]."', '".$up_down[10]."'";?>)"><?php echo $up_down[10];?></div>
					</div>
				</div>
<?php
}else{
?>
			<p> ㅡ </p>
<?php
}
?>
			</div>

<?php
if(!isset($_GET["account_no"])){
?>
			<div id="common_blank">
				
			</div>
<?php
}else{
	$account_no = $_GET["account_no"];
	$account_name = $_GET["account_name"];
?>
			<a href="./my_account.php?account_no=<?php echo $account_no; ?>&account_name=<?php echo $account_name; ?>" >
			<div id="common_footer">
				거래하기
			</div>
			</a>
<?php
}
$connect->close();
?>
		</div>
	</body>
</html>