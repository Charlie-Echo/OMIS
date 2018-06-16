<?php
	require_once('connect.php');
	/*session_start();
	if($_SESSION['ugroup']!=1){
		header("Location: history2.php");
	}*/
	$branch = $_SESSION['ubranch'];
	$ID = $_GET["ID"];
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
				<li><a href="search.php">ค้นหา</a></li>
				<li>
					<div class="dropdown">
					<a href="add.php">นำเข้า</a>
						<div class="dropdown-content">
							<a href="add_new.php">เพิ่มวัสดุใหม่</a>
						</div>
					</div>
				</li>
				<li><a class="active" href="selectyearhistory.php">ประวัติ</a></li>
				<li><a href="request.php">คำร้อง</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right">
					<div class="dropdown">
						<a href="changepass.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a>
						<div class="dropdown-content">
							<a href="createbranch.php">เพิ่มหน่วยงานใหม่</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<col width="25%">
				<col width="75%">
				<center><h3>โปรดเลือกช่วงเวลาค้นหารายการความเคลื่อนไหว</h3></center>
				<form action="itemlog.php" method="post">
					<table id="tb1" align= "center">
						<br>
						<input type="hidden" name="ID" value="<?php echo($ID);?>">
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
						<a href="index.php" class="button1">ย้อนกลับ</a> | 
						<input type="submit" name="submit" class="button1" value="ดำเนินการ">
					</center>
				</form>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
