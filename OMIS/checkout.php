<?php
	require_once('connect.php');
	/*session_start();
	if($_SESSION['ugroup']!=1){
		header("Location: checkout2.php");
	}*/
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
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepass.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<table id="tb0">
					<tr>
						<th>ProductID</th>
						<th>ProductName</th>
						<th>Qty</th>
					</tr>
					<?php

					for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
					{
						if($_SESSION["strProductID"][$i] != "")
						{
						$strSQL = "SELECT * FROM rs_stock WHERE ID = '".$_SESSION["strProductID"][$i]."' ";
						$objQuery = mysqli_query($objCon,$strSQL);
						$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
						?>
						<tr>
						<td><?=$_SESSION["strProductID"][$i];?></td>
						<td><?=$objResult["Full_Name"];?></td>
						<td><?=$_SESSION["strQty"][$i];?></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				<br>
				<br>
				<center>
					<a class="button1" href="show.php">ย้อนกลับ</a> &nbsp &nbsp &nbsp
					<a class="button1" href="save_checkout.php">ยืนยัน</a>
				</center>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
