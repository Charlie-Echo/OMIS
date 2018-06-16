<?php
	require_once('connect.php');
	/*session_start();
	if($_SESSION['ugroup']!=1){
		header("Location: history2.php");
	}*/
	$branch = $_SESSION['ubranch'];
	if(isset($_POST["fromdate"])&&isset($_POST["todate"])){
		$fd = $_POST["fromdate"];
		$td = $_POST["todate"];
	}
	elseif(isset($_SESSION['fd']) && isset($_SESSION['td'])){
		$fd = $_SESSION['fd'];
		$td = $_SESSION['td'];
		unset($_SESSION['fd']);
		unset($_SESSION['td']);
	}
	else {
		header("Location: selectyearhistory.php");
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
				<?php echo "<b>กำลังแสดงประวัติระหว่าง:</b> ".$fd." <b>ถึง:</b> ".$td."<br><br><br>"; ?>
				<div align="right">
					<a href="orderhistory_excel.php?fromdate=<?php echo($fd);?>&todate=<?php echo($td);?>" class="button1">เปิดใน Excel</a>
				</div>
				<table id="tb0">
					<tr>
						<th><center>เลขสั่งซื้อ</center></th>
						<th><center>นำเข้า/จ่ายออก</center></th>
						<th><center>วันที่/เวลา</center></th>
						<th><center>หน่วยงาน</center></th>
						<th><center>สถานะ</center></th>
						<th><center>รายละเอียด</center></th>
					</tr>
					<?php
					//$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
					$q="select history.*, user.branch_name from history, user where history.From_stock = '$branch'
					AND (history.status = 'Imported' OR history.status = 'Approved') AND history.User = user.user_Name
					AND history.Date between '$fd' and '$td 23:59:59' ORDER BY history.Date DESC"; //where status = 'Imported'
					$result=$objCon->query($q);
					if(!$result){
  					echo "Select failed. Error: ".$objCon->error ;
					}
					$count = 0;
					while($row=$result->fetch_array()){?>
					<tr>
						<center>
								<td><center><?=$row['order_number']?></center></td>
								<td><center><?php echo($row['TRcode']."/".$row['NumCount']."/".$row['Year']);?></center></td>
								<td><center><?=$row['Date']?></center></td>
								<td><center><?=$row['branch_name']?></center></td>
								<td><center><?=$row['status']?></center></td>
								<td>
									<center>
										<a href="h_detail.php?ID=<?=$row['ID']?>&Type=<?=$row['status']?>&orderNO=<?=$row['order_number']?>
										&fd=<?=$fd?>&td=<?=$td?>">ดูข้อมูล</a>
									</center>
							</td>
						</center>
					</tr>
					<?php } ?>
				</table>
				<br>
				<center><a href="selectyearhistory.php" class="button1">ดูช่วงเวลาอื่น</a></center>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
