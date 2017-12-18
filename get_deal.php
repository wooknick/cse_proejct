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
$sql="SELECT deal_time, stock_name, deal_quantity, deal_price, what_deal, stock_code FROM deal, stock WHERE account_no=$account_no and deal.stock_no = stock.stock_no;";
$result = $connect -> query($sql);

if($result->num_rows == 0){
	echo "<div class='frame_line'> <br>거래 내역 없음 </div>";
}else{
	while($row = $result->fetch_object()){
		$deal_time = $row->deal_time;
		$stock_name = $row->stock_name;
		$stock_code = $row->stock_code;
		$deal_quantity = $row->deal_quantity;
		$deal_price = $row->deal_price;
		$what_deal = $row->what_deal;
?>
			<div class='frame_line'> 
				<div class='my_deal_deal_time'> <?php echo $deal_time;?></div>
				<div class='my_deal_stock_name' onclick="parent.document.location='stock_detail.php?account_no=<?php echo $account_no;?>&account_name=<?php echo $account_name;?>&stock_code=<?php echo $stock_code;?>&stock_name=<?php echo $stock_name;?>';"><?php echo $stock_name;?></div>
				<div class='my_deal_quantity'><?php echo number_format($deal_quantity);?> 주</div>
				<div class='my_deal_price'><?php echo number_format($deal_price);?> 원</div>
				<div class='my_deal_what'><?php echo $what_deal;?></div>
			</div>
<?php
	}
}
$connect->close();
?>
	</body>
</html>
