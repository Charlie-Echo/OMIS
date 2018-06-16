<?php
	require_once('connect.php');
	//session_start();
	$uname = $_SESSION['uname'];
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
				<li><a href="index3.php">รายการ</a></li>
				<li><a href="show3.php">เบิก</a></li>
				<li><a href="search3.php">ค้นหา</a></li>
				<li><a class="active" href="history3.php">ประวัติ</a></li>
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
					$q="select * from history WHERE User='$uname' ";
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
								<td><a href="h_detail3.php?ID=<?=$row['ID']?>">ดูข้อมูล</a></td>
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
