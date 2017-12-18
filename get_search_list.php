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
$search = $_GET["search"];
$sql="SELECT * FROM stock WHERE stock_name like '%$search%';";
$result = $connect -> query($sql);
if($result->num_rows >= 1){
	while($row = $result->fetch_object()){
		$stock_name = $row->stock_name;
		$stock_code = $row->stock_code;
?>
		<div class='frame_line'> 
			<div class='my_account_search_stock'><?php echo $stock_name;?>( <?php echo $stock_code;?> )</div>
			<div class='my_account_search_link' onclick="parent.document.location='stock_detail.php?account_no=<?php echo $account_no;?>&account_name=<?php echo $account_name;?>&stock_code=<?php echo $stock_code;?>&stock_name=<?php echo $stock_name;?>';">상세 보기</div>
		</div>
<?php
	}
}else{
	echo "결과 없음";
}$connect->close();
?>
	</body>
</html>