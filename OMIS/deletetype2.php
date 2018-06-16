<?php
	require_once('connect.php');
	ob_start();
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
	}
	$ID = $_GET['ID'];
	$fd = $_GET["fd"];
	$td = $_GET["td"];
	$q="DELETE FROM history WHERE ID = '$ID'";
	$result=$objCon->query($q);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}

	$q="DELETE FROM detail WHERE Order_ID = '$ID'";
	$result=$objCon->query($q);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$_SESSION['fd'] = $fd;
	$_SESSION['td'] = $td;
	echo "ลบข้อมูลแล้ว กำลังredirectกลับใน5วินาที";
	sleep(5);
	header("Location: history2.php");
?>
