<?php
session_save_path("../session_save");
session_start();
if( !isset($_SESSION["member_id"]) ){
	echo "
		<script>
			alert('로그인 후 이용해주세요.');
			location.href='../index.php';
		</script>
		";
}
?>