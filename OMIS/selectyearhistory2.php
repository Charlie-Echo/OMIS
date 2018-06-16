<?php
	require_once('connect.php');
	$branch = $_SESSION['ubranch'];
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
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
				<li><a href="index2.php">รายการคงคลังย่อย</a></li>
				<li><a href="search2.php">เบิกวัสดุ</a></li>

				<li><a href="show3.php">จ่ายของ</a></li>
				<li><a class="active" href="selectyearhistory2.php">ประวัติ</a></li>

				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<col width="25%">
				<col width="75%">
				<center><h3>โปรดเลือกช่วงเวลาค้นหาประวัติ</h3></center>
				<form action="history2.php" method="post">
					<table id="tb1" align= "center">
						<br>
						<tr>
							<th><label>ค้นหาตั้งแต่วันที่:</label></th>
							<th><input type="date" name="fromdate"></th>
						</tr>
						<tr>
							<th><label>จนถึงวันที่:</label></th>
							<th><input type="date" name="todate"></th>
						</tr>
					</table>
					<br>
					<center>
						<a href="index2.php" class="button1">ย้อนกลับ</a> | 
						<input type="submit" name="submit" class="button1" value="ดำเนินการ">
					</center>
				</form>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
