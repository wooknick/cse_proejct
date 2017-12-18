<?php
session_save_path("session_save");
session_start();
if( isset($_SESSION[member_id]) ){
	echo "
		<script>
			location.href='./main.php';
		</script>
		";
    exit;
}
?>