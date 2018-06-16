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
				<li><a href="selectyearhistory.php">ประวัติ</a></li>
				<li><a class="active" href="request.php">คำร้อง</a></li>
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
					<tr>
						<th><center>รายการ</center></th>
						<th><center>เวลา</center></th>
						<th><center>ผู้ใช้</center></th>
						<th><center>รายละเอียด</center></th>
						<!--<th>วันที่นำเข้า</th>
						<th>ราคา</th> -->
					</tr>
					<?php
					//$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
					$q="select * from history where status='Waiting' AND From_stock = '$branch' ORDER BY Date DESC";
					$result=$objCon->query($q);
					if(!$result){
  						echo "Select failed. Error: ".$objCon->error ;
					}
					$count = 0;
					while($row=$result->fetch_array()){
						$tostockcode = $row['User'];
						$qq="select branch_name from user where user_Name = '$tostockcode'";
						$result11=$objCon->query($qq);
						if(!$result11){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row11=$result11->fetch_array();
					?>
					<tr>
						<center>
								<td><center><?=$row['TRcode']."/".$row['NumCount']."/".$row['Year']?></center></td>
								<td><center><?=$row['Date']?></center></td>
								<td><center><?=$row11['branch_name']?></center></td>
								<td><center><a href="r_detail.php?ID=<?=$row['ID']?>">ดูข้อมูล</a></center></td>
						</center>
					</tr>
					<?php }
						unset($_SESSION["detailID"]);
						unset($_SESSION["newQty"]);
						unset($_SESSION["stat"]);
						unset($_SESSION["hID"]);
						unset($_SESSION["reqItem"]);
						unset($_SESSION["Full_Name"]);
					?>
				</table>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
