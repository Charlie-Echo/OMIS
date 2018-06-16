<?php
	require_once('connect.php');
	//session_start();
  if(!isset($_SESSION['ugroup'])){
    header("Location: login.php");
  }
  if($_SESSION['ugroup']==1){
    header("Location: index.php");
  }
  if($_SESSION['supervisor']!='none'){
    header("Location: index2.php");
  }
  $ubranch = $_SESSION['ubranch'];
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
        <li><a class="active" href="supervisor_check.php">ยืนยันการเบิก</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepassS.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<table id="tb0">
					<tr>
						<th><center>เลขใบเบิก</center></th>
						<th><center>วันที่/เวลา</center></th>
						<th><center>สถานะ</center></th>
						<th><center>รายละเอียด</center></th>
						<!--<th>วันที่นำเข้า</th>
						<th>ราคา</th> -->
					</tr>
					<?php
					$newubranch = "_".$ubranch;
					//$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
					$q="select * from history WHERE status='WaitingS' AND To_stock LIKE '%$newubranch%' order by date desc";
					$result=$objCon->query($q);
					if(!$result){
  					echo "Select failed. Error: ".$objCon->error ;
					}
					while($row=$result->fetch_array()){?>
						<tr>
							<center>
								<td><center><?php echo($row['TRcode']."/".$row['NumCount']."/".$row['Year']);?></center></td>
								<td><center><?=$row['Date']?></center></td>
								<td><center><?=$row['status']?><center></td>
								<td><center><a href="s_detail.php?ID=<?=$row['ID']?>">ดูข้อมูล</a></center></td>
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
