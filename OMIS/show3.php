<?php
	//session_start();
	//error_reporting(E_ALL ^ E_NOTICE);
	require_once('connect.php');
	//$fromloc = $_SESSION["Fromloc"];
	$branch = $_SESSION['ubranch'];
	/*echo($fromloc);
	echo($branch);*/
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
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">

					<?php
						if(!isset($_SESSION["intLine1"])||($_SESSION["numLine1"]==0)){
							echo "<h1><center>รายการวัสดุว่างเปล่า!<center></h1>";
						}else{ ?>
							<center><h3>รายการจ่ายวัสดุ</h3></center>
						  <form action="update3.php" method="post">
							<table id="tb0">
							  <tr>
								<th><center>รายการ</center></th>
								<th><center>จำนวน</center></th>
								<th><center>ลบ</center></th>
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
									<td><center><input type="number" name="txtQty<?php echo $i;?>" value="<?php echo $_SESSION["strQty1"][$i];?>"></center></td>
									<td><center><a href="delete3.php?Line=<?=$i;?>">ลบ</a></center></td>
								  </tr>

								 <?php
									}
								}
							   ?>
							</table>
							<br>
							<br>
							<center>
								<input type="submit" class="button1" value="บันทึกการแก้ไข">
								<?php
									if((int)$_SESSION["numLine1"] > 0)
									{
								?>
									| <a href="checkout3.php" class="button1">ยืนยัน</a>
								<?php
								}
							}
							?>
							</center>

						</form>
						<br>
						<hr>
						<br>

					<table id="tb0">
					<tr>
						<th><center>ภาพ</center></th>
						<th><center>รหัส</center></th>
						<th><center>รายการ</center></th>
						<th><center>คงเหลือ</center></th>
						<th width="90"><center>จ่าย</center></th>
					</tr>
					<?php
						$q="select * from $branch where QLeft > 0 order by ID";
						$result=$objCon->query($q);
						if(!$result){
						echo "Select failed. Error: ".$objCon->error ;
						}
						$count = 0;
						while($row=$result->fetch_array()){?>
						<tr>
							<center>
								<form action="haha2.php" method="post">
									<td><center><img <?php if($row['Pic'] != 'Pic/noimage.jpg') { echo "class='rotate'"; } ?> src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
									<td><center><?=$row['Code']?></center></td>
									<td><center><?=$row['Full_Name']?></center></td>
									<td><center><?=$row['QLeft']." ".$row['Unit']?></center></td>
									<td><center>
										<input type="hidden" name="ID" value="<?php echo $row['ID'];?>">
										<input type="hidden" name="sumQty" value="<?php echo $row['QLeft'];?>">
										<input type="number" name="txtQty" value="1" id="in1">
										<input type="submit" value="จ่าย">
									</center></td>
								</form>
							</center>
						</tr>
					<?php } ?>
				</table>
				<?php
				mysqli_close($objCon);
				?>


				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
