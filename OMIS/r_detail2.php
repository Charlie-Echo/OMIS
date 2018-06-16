<?php
	require_once('connect.php');
	//session_start();
	$ID = $_GET["ID"];
	//$user = $_GET["user"];
	$branch = $_SESSION['ubranch'];

	$qq="SELECT * from history WHERE ID = $ID and status = 'Waiting'";
    $result=$objCon->query($qq);
	if(!$result){
  		echo "Select failed. Error: ".$objCon->error ;
	}
	$row1=$result->fetch_array();
    if($row1['ID'] == ''){
    	header("location:index2.php");
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
						<th>Item ID</th>
						<th>Item Pic</th>
						<th>Item Name</th>
						<th>Quantity</th>
						<th>เบิกจากคลัง</th>
						<th>เข้าคลัง</th>
						<th>Status</th>
					  </tr>
					  <?php
						//$q="select detail.*,rs_stock.*, history.* from detail,rs_stock,history where detail.Item_ID=rs_stock.ID and detail.Order_ID = $ID and history.status = 'Waiting' and history.user = '$user' and history.ID = $ID";
						$q="select detail.*,$branch.*, history.* from detail,$branch,history where detail.Item_ID = $branch.ID and detail.Order_ID = $ID and history.status = 'Waiting' and history.ID = $ID";

						$result=$objCon->query($q);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$count = 0;
						while($row=$result->fetch_array()){?>
						<tr>
							<center>
								<td><?=$row['ID']?></td>
								<td><img <?php if($row['Pic'] != 'Pic/noimage.jpg') { echo "class='rotate'"; } ?> src="<?=$row['Pic'] ?>" height="100" width="100"></td>
								<td><?=$row['Full_Name']?></td>
								<td><?=$row['Quantity']?></td>
								<td><?=$row['From_stock']?></td>
								<td><?=$row['To_stock']?></td>
								<td><?=$row['status']?></td>
							</center>
						</tr>
					  <?php
							$_SESSION["fromstock"] = $row['From_stock'];
							$_SESSION["tostock"] = $row['To_stock'];
						} ?>
					</table>
					<br><br>
					<table>
						<td style="text-align:center; border:0px;"><a href='reject.php?ID=<?=$ID?>'><img src='rej.png' width='50' height='50'></td>
						<td style="text-align:center; border:0px;"><a href='approve.php?ID=<?=$ID?>'><img src='app.png' width='50' height='50'></td>
					</table>
					<br>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
