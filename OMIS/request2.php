<?php
	require_once('connect.php');
	/*session_start();
	if($_SESSION['ugroup']!=1){
		header("Location: index2.php");
	}*/
	$branch = $_SESSION['ubranch'];
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
				<li><a href="index2.php">รายการ</a></li>
				<li><a href="show2.php">เบิก</a></li>
				<li><a href="search2.php">ค้นหา</a></li>
				<li><a href="history2.php">ประวัติ</a></li>
				<li><a class="active" href="request2.php">คำร้อง</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
        <table id="tb0">
					<tr>
						<th>ลำดับที่</th>
						<th>เวลา</th>
						<th>ผู้ใช้</th>
						<th>รายละเอียด</th>
						<!--<th>วันที่นำเข้า</th>
						<th>ราคา</th> -->
					</tr>
					<?php
					//$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
					$q="select * from history where status='Waiting' AND From_stock = '$branch'";
					$result=$objCon->query($q);
					if(!$result){
  					echo "Select failed. Error: ".$objCon->error ;
					}
					$count = 0;
					while($row=$result->fetch_array()){?>
					<tr>
						<center>
								<td><?=$row['ID']?></td>
								<td><?=$row['Date']?></td>
								<td><?=$row['User']?></td>
								<td><a href="r_detail2.php?ID=<?=$row['ID']?>">ดูข้อมูล</a></td>
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
