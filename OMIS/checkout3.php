<?php
	require_once('connect.php');
	//$fromloc = $_SESSION["Fromloc"];
	$branch = $_SESSION['ubranch'];
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
				<li><a href="search2.php">เบิกวัสดุ</a></li>

				<li><a class="active" href="show3.php">จ่ายของ</a></li>
				<li><a href="selectyearhistory2.php">ประวัติ</a></li>

				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<table id="tb0">
					<tr>
						<th>รายการ</th>
						<th>จำนวน</th>
					</tr>
					<?php

					for($i=0;$i<=(int)$_SESSION["intLine1"];$i++)
					{
						if($_SESSION["strProductID1"][$i] != "")
						{
						$strSQL = "SELECT * FROM $branch WHERE ID = '".$_SESSION["strProductID1"][$i]."' ";
						$objQuery = mysqli_query($objCon,$strSQL);
						$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
						?>
						<tr>
						<td><?=$objResult["Full_Name"];?></td>
						<td><?=$_SESSION["strQty1"][$i];?></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				<br>
				<form action="save_checkout3.php" method="post" onsubmit="submit.disabled = true; return true;">
					<table id="tb0">
						<tr>
							<th width="90">Note:</th><td><center><textarea name="note" cols="80" rows="3" placeholder="ใส่คำอธิบายการเบิก"></textarea><br></center></td>
						</tr>
					</table>
					<br>
					<br>
					<center>
						<a class="button1" href="show3.php">ย้อนกลับ</a> | 
						<input class="button1" type="submit" value="ยืนยัน">
					</center>
				</form>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
