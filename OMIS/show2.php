<?php
	//session_start();
	//error_reporting(E_ALL ^ E_NOTICE);
	require_once('connect.php');
	$fromloc = $_SESSION["Fromloc"];
	date_default_timezone_set("Asia/Bangkok");
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
					<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">
					<?php if(!isset($_SESSION["intLine"])||($_SESSION["numLine"]==0)){
						echo "<h1><center>รายการวัสดุว่างเปล่า!<center></h1>";
						echo "<br><center><a class='button1' href='search2.php'>ค้นหาวัสดุอื่น</center></a>";
					}else{ ?>
					  <form action="update.php" method="post">
						<table id="tb0">
							<col width="60%">
							<col width="20%">
							<col width="20%">
						  	<tr>
								<th><center>รายการ</center></th>
								<th><center>จำนวน</center></th>
								<th><center>ลบ</center></th>
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
								<td><center><input type="number" name="txtQty<?php echo $i;?>" size="5" value="<?php echo $_SESSION["strQty"][$i];?>"></center></td>
								<td><center><a href="delete.php?Line=<?=$i;?>">ลบ</a></center></td>
							  </tr>

							 <?php
								}
							}
						   ?>
						</table>
						<br>
						<br>
						<center><input type="submit" class="button1" value="บันทึกการแก้ไข"></center>
					</form>
					<center>
						<br><a class="button1" href="search2.php">ค้นหาวัสดุอื่น</a> |
						<a class='button1' href='checkout2.php'>ยืนยัน</a>
						<!-- <?php
							if((int)$_SESSION["numLine"] > 0 && date("l")!="Sunday")
							{
								echo "| <a class='button1' href='checkout2.php'>ยืนยัน</a>";
							}else {
								echo "<br><br><b><h3><font color='red'>ขออภัย! ระบบไม่อนุญาติให้ทำการเบิกในวันพุธของสัปดาห์</font></h3></b>";
							}
						?> -->
					</center>
					<?php }
					mysqli_close($objCon);
					?>


				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
