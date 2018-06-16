<?php
	require_once('connect.php');
	//session_start();
	$uname = $_SESSION['uname'];
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
		header("Location: selectyearhistory2.php");
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
				<li><a href="search2.php">เบิกวัสดุ</a></li>

				<li><a href="show3.php">จ่ายของ</a></li>
				<li><a class="active" href="selectyearhistory2.php">ประวัติ</a></li>

				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<?php echo "<b>กำลังแสดงประวัติระหว่าง:</b> ".$fd." <b>ถึง:</b> ".$td."<br><br><br>"; ?>
				<div align="right">
					<a href="orderhistory2_excel.php?fromdate=<?php echo($fd);?>&todate=<?php echo($td);?>" class="button1">เปิดรายละเอียดทุกชิ้นใน Excel</a>
				</div>
				<table id="tb0">
					<tr>
						<th><center>เลขใบเบิก</center></th>
						<th><center>วันที่/เวลา</center></th>
						<th><center>ชนิด</center></th>
						<th><center>สถานะ</center></th>
						<th><center>รายละเอียด</center></th>
						<!--<th>วันที่นำเข้า</th>
						<th>ราคา</th> -->
					</tr>
					<?php
					//$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
					$q="select * from history WHERE User='$uname' AND history.Date between '$fd' and '$td 23:59:59' ORDER BY `history`.`Date` DESC";
					$result=$objCon->query($q);
					if(!$result){
  					echo "Select failed. Error: ".$objCon->error ;
					}
					while($row=$result->fetch_array()){
						if($row['From_stock'] == $row['To_stock']){
							$type = "จ่ายออกจากคลัง";
						}
						else{
							$type = "เบิกจากคลังใหญ่";
						}?>
						<tr>
							<center>
								<td><center><?php echo($row['TRcode']."/".$row['NumCount']."/".$row['Year']);?></center></td>
								<td><center><?=$row['Date']?></center></td>
								<td><center><?=$type ?></center></td>
								<td><center><?=$row['status']?><center></td>
								<td><center><a href="h_detail2.php?ID=<?=$row['ID']?>&fd=<?=$fd?>&td=<?=$td?>">ดูข้อมูล</a></center></td>
							</center>
						</tr>
					<?php } ?>
				</table>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
