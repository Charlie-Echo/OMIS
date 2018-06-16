<?php
	require_once('connect.php');
	//session_start();
	$fromloc = $_SESSION["Fromloc"];
	date_default_timezone_set("Asia/Bangkok");
	// if(date("l")== "Wednesday"){
	// 	header("location: index2.php");
	// }
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
	}
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
					<li><a class="active" href="search2.php">เบิกวัสดุ</a></li>

					<li><a href="show3.php">จ่ายของ</a></li>
					<li><a href="selectyearhistory2.php">ประวัติ</a></li>

					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<table id="tb0">
					<tr>
						<th><center>รายการ</center></th>
						<th><center>จำนวน</center></th>
					</tr>
					<?php

					for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
					{
						if($_SESSION["strProductID"][$i] != "")
						{
						$strSQL = "SELECT * FROM $fromloc WHERE ID = '".$_SESSION["strProductID"][$i]."' ";
						$objQuery = mysqli_query($objCon,$strSQL);
						$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
						?>
						<tr>
						<td><?=$objResult["Full_Name"];?></td>
						<td><center><?=$_SESSION["strQty"][$i];?></center></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				<br>
				<br>
				<center>
					<a class="button1" href="show2.php">ย้อนกลับ</a> | 
					<a class="button1" onclick="clickAndDisable(this);" href="save_checkout2.php">ยืนยัน</a>
				</center>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
		<script>
		   function clickAndDisable(link) {
			 // disable subsequent clicks
			 link.onclick = function(event) {
				event.preventDefault();
			 }
		   }
		</script>
	</body>
</div>
</html>
