<?php
include "session.php";
include "db.php";

$what_deal=$_POST["what_deal"];	//buy 또는 sell
$try_quantity=$_POST["try_quantity"];	// 230
$account_no=$_GET["account_no"];	// 19
$account_name=$_GET["account_name"];	// test
$stock_code=$_GET["stock_code"];	// 006400
$stock_name=$_GET["stock_name"];
$stock_quantity = 0;
$deal_price = $_POST["deal_price"];	//	209000
$stock_no = 0;
$member_no = $_SESSION["member_no"];	// 10

$sql="SELECT stock_no FROM stock WHERE stock_code ='$stock_code';";
$result = $connect -> query($sql);
while($row = $result->fetch_object()){
	$stock_no = $row->stock_no;
}

//account_state 관련 처리(stock_quantity 업데이트, 없으면 생성)
$sql="SELECT * FROM account_state WHERE stock_no=$stock_no and account_no = $account_no;";
$result = $connect -> query($sql);
while($row = $result->fetch_object()){
	$stock_quantity = $row->stock_quantity;
}
if($what_deal == "buy"){
	$modified_quantity = (int)$stock_quantity + (int)$try_quantity;	
}else{
	$modified_quantity = (int)$stock_quantity - (int)$try_quantity;
}
if($result->num_rows >= 1){
	if($modified_quantity == 0){
		$sql = "DELETE FROM account_state WHERE stock_no=$stock_no and account_no=$account_no;";
	}else{
		$sql = "UPDATE account_state SET stock_quantity='$modified_quantity' WHERE stock_no=$stock_no and account_no=$account_no;";
	}
	$connect -> query($sql);
}else{
	$sql = "INSERT INTO account_state(account_no, stock_no, stock_quantity) VALUES($account_no, $stock_no, '$try_quantity');";
	$connect -> query($sql);
}

//account 관련 처리(balance, rate 업데이트)
$sql="SELECT * FROM account WHERE account_no=$account_no;";
$result = $connect -> query($sql);
while($row = $result->fetch_object()){
	$account_balance = $row->account_balance;
	$account_init = $row->account_init;
}

$sql2="SELECT stock_name, stock_quantity, stock_code FROM account_state, stock WHERE account_no=$account_no and stock.stock_no = account_state.stock_no;";
$result2 = $connect -> query($sql2);
$total_value=0;

while($row2 = $result2->fetch_object()){
	$stock_name = $row2->stock_name;
	$stock_quantity = $row2->stock_quantity;
	$stock_code = $row2->stock_code;
	$command = "python ../py/beautifulsoup4-4.4.1-py2.7/get_price.py ".$stock_code;
	$price = exec($command);
	$price_string = preg_replace("/[^0-9]/", "", $price);
	$each_value = (int)$price_string * (int)$stock_quantity;
	$total_value = $total_value + $each_value;
	$each_value = number_format($each_value);
}	

if($what_deal == "buy"){
	$modified_balance=(int)$account_balance - ((int)$deal_price * (int)$try_quantity);
}else{
	$modified_balance=(int)$account_balance + ((int)$deal_price * (int)$try_quantity);	
}
$account_rate = (int)((((int)$modified_balance + (int)$total_value) / (int)$account_init) * 100);
$sql = "UPDATE account SET account_balance='$modified_balance', account_rate='$account_rate' WHERE account_no=$account_no;";
$connect -> query($sql);

//deal 관련 처리( 업데이트)
$sql = "INSERT INTO deal(stock_no, account_no, member_no, deal_price, deal_quantity, what_deal) VALUES($stock_no, $account_no, $member_no, '$deal_price', '$try_quantity', '$what_deal');";
$connect -> query($sql);




echo "
		<script>
			location.href='../stock_detail.php?account_no=$account_no&account_name=$account_name&stock_code=$stock_code&stock_name=$stock_name';
		</script>
		";
$connect->close();
?>

<html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
	</body>
</html>
