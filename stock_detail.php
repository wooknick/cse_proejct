<?php
include "session.php";
include "./db/db.php";

$member_no=$_SESSION["member_no"];
$account_name="계좌 없음";
$account_exist = false;
$stock_code = $_GET["stock_code"];
$stock_name = $_GET["stock_name"];
$account_no = $_GET["account_no"];
$stock_quantity = "0";

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
			function update_price() {
				stock_code = document.getElementById("code").value;
		        if(window.XMLHttpRequest){
		            xmlhttp = new XMLHttpRequest();
		        }else{
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function(){
		            if (this.readyState == 4 && this.status == 200){
		                document.getElementById("stock_price_value").innerHTML = this.responseText+" 원";
		                document.getElementById("deal_price").value = parseInt(this.responseText.replace(/[^0-9]/g, ''));
		                if(document.getElementById("stock_price_value").className == "ajax_1"){
			            	document.getElementById("stock_price_value").className = "ajax_2"; 
			            	document.getElementById("maximum").className = "ajax_2"  
		                }else{
			                document.getElementById("stock_price_value").className = "ajax_1";
			                document.getElementById("maximum").className = "ajax_1"
		                }
						var price = parseInt(this.responseText.replace(/[^0-9]/g, ''));
						var balance = parseInt(document.getElementById("account_balance").innerHTML.replace(/[^0-9]/g, ''));
						var maximum = parseInt(balance / price);
						document.getElementById("maximum").innerHTML = number_format(maximum);
		            }
		        };
		        xmlhttp.open("POST","./db/price_check_ajax.php",true);
		        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		        xmlhttp.send("stock_code="+stock_code);
			}
			
			window.onload = function(){
				window.setInterval(update_price, 3000);
			}
			function buy(){
				var q = parseInt(document.getElementById("try_quantity").value);
				var max = parseInt(document.getElementById("maximum").innerHTML.replace(/[^0-9]/g, ''));
				if(q > max || q < 0){
					alert("희망 거래량은 음수가 될 수 없으며, 구매의 경우 최대 구매 가능량을 넘을 수 없습니다.");
					document.getElementById("try_quantity").focus();
				}else{
					document.getElementById("what_deal").value = "buy";
				}
			}
			function sell(){
				var q = parseInt(document.getElementById("try_quantity").value);
				var current = parseInt(document.getElementById("current").innerHTML.replace(/[^0-9]/g, ''));
				if(q > current || q < 0){
					alert("희망 거래량은 음수가 될 수 없으며, 판매의 경우 현재 보유량을 넘을 수 없습니다.");
					document.getElementById("try_quantity").focus();
				}else{
					document.getElementById("what_deal").value = "sell";				
				}
			}
			
			function buy_sell(){
				if(document.getElementById("what_deal").value == ""){
					return false;
				}else{
					return confirm("정말 거래하시겠습니까?");
// 					return true;
				}
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
		echo "<a href='my_account.php?account_no=$account_no_a&account_name=$account_name_a&stock_code=$stock_code&stock_name=$stock_name'> $account_name_a </a>";
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
				<div id="stock_name">
					<div id="stock_name_value">
						<?php echo $stock_name;?>
					</div>
				</div>
				<form id="buy_sell" action="./db/deal.php?account_no=<?php echo $account_no; ?>&account_name=<?php echo $account_name; ?>&stock_code=<?php echo $stock_code; ?>&stock_name=<?php echo $stock_name; ?>" method="post" onsubmit="return buy_sell();">
				<div id="stock_price">
					<input type="hidden" name="code" id="code" value="<?php echo $stock_code;?>">
					<div id="stock_price_value" class="ajax_1">
						가져오는중
					</div>
				</div>
				<hr>
<?php
$sql="SELECT account_balance FROM account WHERE account_no = $account_no;";
$result = $connect -> query($sql);
while($row = $result->fetch_object()){
	$account_balance = $row->account_balance;
}
$sql="SELECT stock_quantity FROM account_state WHERE stock_no=(SELECT stock_no FROM stock WHERE stock_code ='$stock_code') and account_no = $account_no;";
$result = $connect -> query($sql);
while($row = $result->fetch_object()){
	$stock_quantity = $row->stock_quantity;
}
?>
				
				<div id="detail_info">
					<div class="detail_line">
						<div class="detail_left">
							현재 보유 현금
						</div>
						<div id="account_balance" class="detail_middle">
							<?php echo number_format($account_balance);?>
						</div>
						<div class="detail_right">
							원
						</div>
					</div>
					<div class="detail_line">
						<div class="detail_left">
							최대 구매 가능량
						</div>
						<div class="detail_middle">
							<span id="maximum" class="ajax_1">0</span>
						</div>
						<div class="detail_right">
							주
						</div>
					</div>
					<div class="detail_line">
						<div class="detail_left">
							현재 보유량
						</div>
						<div class="detail_middle">
							<span id="current"><?php echo number_format($stock_quantity); ?></span>
						</div>
						<div class="detail_right">
							주
						</div>
					</div>
					<div class="detail_line">
						<div class="detail_left">
							희망 거래량
						</div>
						<div class="detail_middle">
							<input id="try_quantity" name="try_quantity" class="detail_input" type="number" required>
						</div>
						<div class="detail_right">
							주
						</div>
					</div>
				</div>
				<hr>
				<br>
				<input type="hidden" id="what_deal" name="what_deal" value="">
				<input type="hidden" id="deal_price" name="deal_price" value="">
				<button class="buy" onClick="buy()">구매하기</button>
				<button class="sell" onClick="sell()">판매하기</button>
				</form>
			</div>
			<div id="common_blank">
				<p> </p>
			</div>
		</div>
	</body>
</html>
<?php
$connect->close();
?>