<?php
	//session_start();
	require_once('connect.php');
	/*if(!isset($_POST['stockloc'])){ //If intentionally access this page
		if($_SESSION['ugroup']==1){
			header("Location: search.php");
		}
		elseif($_SESSION['ugroup']==2){
			header("Location: search2.php");
		}
	}*/
	$stockloc = $_SESSION["Fromloc"];
	error_reporting(1);
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
				<li><a class="active" href="search2.php">ค้นหารายการ</a></li>
				<li><a href="show2.php">ขอเบิกจากคลังกลาง</a></li>
				<li><a href="show3.php">จ่ายของ</a></li>
				<li><a href="history2.php">ประวัติ</a></li>
				
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a>ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['ubranch']; ?> </b></a></li>
			</ul>
		</div>
			<div id="div_main">
				<div id="div_content">
					<h2>ผลการค้นหาทั้งหมด</h2>
					<table id="tb0">
						<table id="tb0">
							<tr>
								<th>ลำดับที่</th>
								<th>ภาพ</th>
								<th>รหัส</th>
								<th>รายการ</th>
								<!--<th>วันที่นำเข้า</th>
								<th>ราคา</th> -->
								<th>คงเหลือ</th>
								<th>หน่วยนับ</th>
								<th>โอน</th>
							</tr>
						<?php
							$q="select * from $stockloc WHERE 1";
							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$mysqli->error ;
							}
							while($row=$result->fetch_array()){ ?>
								<tr>
								<center>
									<form action="haha.php" method="post">
										<td><?=$row['ID']?></td>
										<td><img src="<?=$row['Pic'] ?>" height="100" width="100"></td>
										<td><?=$row['Code']?></td>
										<td><?=$row['Full_Name']?></td>
										<td><?=$row['QLeft']?></td>
										<td><?=$row['Unit']?></td>
										<td>
											<input type="hidden" name="ID" value="<?php echo $row['ID'];?>">
											<input type="text" name="txtQty" value="1" id="in1">
											<input type="submit" value="เบิก">
										</td>
									</form>
								</center>
							<?php } ?>
						</table>
						<br>
					<center><a href="search2.php" class="button1">ย้อนกลับ</a></center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
