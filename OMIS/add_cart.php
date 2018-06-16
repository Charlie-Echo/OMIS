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
					    <a href="add_new.php">เพิ่มวัสดุใหม่</a>
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
				<form action="add_update.php" method="post">
					<?php if(!isset($_SESSION["numLine"]) || ((int)$_SESSION["numLine"] == 0)){
						echo "<h1><center>รายการวัสดุว่างเปล่า!<center></h1>";
					}else{ ?>
						<table id="tb0">
							<col width="45%">
							<col width="20%">
							<col width="20%">
							<col width="15%">
							<tr>
								<th><center>รายการ</center></th>
								<th><center>รูป</center></th>
								<th><center>ราคาต่อหน่วย</center></th>
								<th><center>จำนวน</center></th>
								<th><center>ลบรายการ</center></th>
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
										<td><center><input type="number" step="any" id='in2' name="price<?php echo $i;?>" value="<?php echo $_SESSION["itemPrice"][$i];?>"></center></td>
										<td><center><input type="number" id='in2' name="quantity<?php echo $i;?>" value="<?php echo $_SESSION["itemQty"][$i];?>"></center></td>
										<td><center><a href="add_delete.php?Line=<?=$i;?>">ลบ</a></center></td>
									</tr>

									<?php
								}
							}
							?>
						</table>
						<br>
						<center><input type="submit" class="button1" value="บันทึกการแก้ไข"></center>
					</form>
					<center>
						<br><a class="button1" href="add.php">ค้นหาวัสดุอื่น</a>
						<?php
						if((int)$_SESSION["numLine"] > 0)
						{
							?>
							| <a href="add_checkout.php">ยืนยัน</a>
							<?php
						}
						?>
					</center>
				<?php
					mysqli_close($objCon);
				}
				?>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
