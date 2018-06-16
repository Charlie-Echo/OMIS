<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
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
				<li><a href="search.php">ค้นหา</a></li>
				<li>
					<div class="dropdown">
					<a href="add.php" class="active">นำเข้า</a>
					  <div class="dropdown-content">
					    <a href="#">เพิ่มวัสดุใหม่</a>
					  </div>
					</div>
				</li>
				<li><a href="selectyearhistory.php">ประวัติ</a></li>
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
				<table id="tb0">
					<col width="35%">
					<col width="15%">
					<col width="25%">
					<col width="10%">
					<col width="15%">
					<tr>
						<th>รายการ</th>
						<th><center>รูป</center></th>
						<th><center>ราคาต่อหน่วย</center></th>
						<th><center>ราคาต่อหน่วย(VAT 7%)</center></th>
						<th><center>จำนวน</center></th>
						<th><center>ราคาสุทธิ</center></th>
					</tr>
					<?php

					for($i=0;$i<=(int)$_SESSION["itemLine"];$i++)
					{
						if($_SESSION["itemName"][$i] != "")
						{
						$strSQL = "SELECT * FROM item WHERE Full_Name = '".$_SESSION["itemName"][$i]."' ";
						$objQuery = mysqli_query($objCon,$strSQL);
						$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
						?>
						<tr>
							<td><?=$objResult["Full_Name"];?></td>
							<td><center><img src="<?=$objResult["Pic"];?>" height="60" width="60"></center></td>
							<td><center><?=number_format($_SESSION["itemPrice"][$i],2);?></center></td>
							<td><center><?=number_format($_SESSION["itemPrice"][$i]*(1.07),2);?></center></td>
							<td><center><?=number_format($_SESSION["itemQty"][$i])." ".$objResult["Unit"];?></center></td>
							<td><center><?=number_format($_SESSION["itemPrice"][$i]*(1.07)*($_SESSION["itemQty"][$i]),2);?></center></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				<br>
				<br>
				<form action="add_save.php" method="post" onsubmit="submit.disabled = true; return true;">
					<table id="tb1" align= "center">
						<col width="30%">
						<col width="70%">
						<tr>
							<th><label>เลขที่รายการสั่งซื้อ:</label></th>
							<th><input type="text" name="orderNO"></th>
						</tr>
						<tr>
							<th><label>จากบริษัท:</label></th>
							<th><input type="text" name="supplier"></th>
						</tr>
						<tr>
							<th><label>วันที่:</label></th>
							<th><input type="date" name="date"></th>
						</tr>
						<tr>
							<th><label>หมายเหตุ:</label></th>
							<th><input type="text" name="note"></th>
						</tr>
						</table>

					<br>
				<center>
					<a class="button1" href="add_cart.php">ย้อนกลับ</a> |
					<input type="submit" name="submit" class="button1" value="ยืนยัน">
				</center>
				</form>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
