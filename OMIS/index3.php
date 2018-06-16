<?php
	require_once('connect.php');

	$branch = $_SESSION['ubranch'];
	$findbranch = explode("_", $branch);
	$_SESSION["Fromloc"] = $_SESSION['ubranch'];

	/*echo($branch."<br>");
	echo($findbranch[0]."<br>");
	echo($_SESSION["Fromloc"]);*/
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
				<li><a class="active" href="index3.php">รายการ</a></li>
				<li><a href="show3.php">เบิก</a></li>
				<li><a href="search3.php">ค้นหา</a></li>
				<li><a href="history3.php">ประวัติ</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
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
						<th width="90">โอน</th>
					</tr>
					<?php
					//$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
					$q="select * from $branch";
					$result=$objCon->query($q);
					if(!$result){
  					echo "Select failed. Error: ".$objCon->error ;
					}
					$count = 0;
					while($row=$result->fetch_array()){?>
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
									<input type="submit" value="จ่าย">
								</td>
							</form>
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
