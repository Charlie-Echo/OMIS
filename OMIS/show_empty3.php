<?php
	//session_start();
	//error_reporting(E_ALL ^ E_NOTICE);
	require_once('connect.php');
?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  		<title>SIIT Office Material Inventory System</title>
  		<style>
			tx {
				color: white;
			}
		</style>
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
				<li><a href="index2.php">รายการคงคลังย่อย</a></li>
				<li><a href="search2.php">ค้นหารายการ</a></li>
				<li><a href="show2.php">ขอเบิกจากคลังกลาง</a></li>
				<li><a class="active" href="show3.php">จ่ายของ</a></li>
				<li><a href="selectyearhistory2.php">ประวัติ</a></li>

				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
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
