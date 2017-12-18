<?php
include "session.php";
include "./db/db.php";
?>

<html>
	<head>
		<meta charset="utf-8">
		<title> 모두의 주식 </title>
		<link href="./css/frame.css" rel="stylesheet">
	</head>
	<body>
<?php
$account_no = $_GET["account_no"];
$account_name = $_GET["account_name"];
$sql="SELECT stock_name, stock_quantity, stock_code FROM account_state, stock WHERE account_no=$account_no and stock.stock_no = account_state.stock_no;";
$result = $connect -> query($sql);
$total_value=0;

if($result->num_rows == 0){
	echo "<div class='frame_line'> <br>거래 내역 없음 </div>";
}else{
	while($row = $result->fetch_object()){
		$stock_name = $row->stock_name;
		$stock_quantity = $row->stock_quantity;
		$stock_code = $row->stock_code;
?>
			<div class='frame_line'> 
				<div class='my_account_stock_name' onclick="parent.document.location='stock_detail.php?account_no=<?php echo $account_no;?>&account_name=<?php echo $account_name;?>&stock_code=<?php echo $stock_code;?>&stock_name=<?php echo $stock_name;?>';"><?php echo $stock_name;?></div>
				<div class='my_account_stock_quantity'><?php echo $stock_quantity;?> 주</div>
				<div class='my_account_stock_price'>
<?php
		$command = "python ./py/beautifulsoup4-4.4.1-py2.7/get_price.py ".$stock_code;
		$price = system($command);
		$price_string = preg_replace("/[^0-9]/", "", $price);
		$each_value = (int)$price_string * (int)$stock_quantity;
		$total_value = $total_value + $each_value;
		$each_value = number_format($each_value);
?>
				원</div>
				<div class='my_account_stock_total'><?php echo $each_value;?> 원</div>
			</div>
<?php
	}
}
echo "
	<script>
		parent.document.getElementById('total_value').innerHTML=$total_value;
	</script>
";
$connect->close();
?>
	</body>
</html>
