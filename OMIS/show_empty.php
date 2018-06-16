<?php
	//session_start();
	//error_reporting(E_ALL ^ E_NOTICE);
	require_once('connect.php');
	if($_SESSION['ugroup']!=1){
		header("Location: show_empty2.php");
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  	<title>SIIT Office Material Inventory System</title>
	</head>
<div id="wrapper">
	<body>
		<div id="div_header">
		<center><img src="logo.jpg" alt="logo"></center>
		<br>
		<center><h1>Office Material Inventory System</center>
		</div>
		<div id="div_subhead">
			<ul>
				<li><a href="index.php">รายการ</a></li>
				<li><a class="active" href="show.php">โอน</a></li>
				<li><a href="search.php">ค้นหา</a></li>
				<li><a href="add.php">นำเข้า</a></li>
				<li><a href="return.php">รับคืน</a></li>
				<li><a href="history.php">ประวัติ</a></li>
				<li><a href="request.php">คำร้อง</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<center>
					<h1>Cart is empty, please select item.</h1>
					<br><a class="button1" href="index.php">Go to Product</a>
				</center>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
