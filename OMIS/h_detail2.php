<?php
	require_once('connect.php');
	//session_start();
	$ID = $_GET["ID"];
	$branch = $_SESSION['ubranch'];
	/*if(isset($_SESSION['fd']) && isset($_SESSION['td'])){
		$fd = $_SESSION['fd'];
		$td = $_SESSION['td'];
		unset($_SESSION['fd']);
		unset($_SESSION['td']);
	}
	else{
		$fd = $_GET["fd"];
		$td = $_GET["td"];
	}*/
	$fd = $_GET["fd"];
	$td = $_GET["td"];
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
				<table id="tb0">
				  <tr>
						<th><center>ภาพ</center></th>
						<th><center>รายการ</center></th>
						<th><center>จำนวน</center></th>
						<th><center>สถานะ</center></th>
				  </tr>
				  <?php
				  $q="select item.Pic, item.Full_Name, SUM(Quantity), detail.status from detail, item where detail.Item_ID= item.ID and detail.Order_ID = $ID GROUP BY item.ID, detail.status";
				  $result=$objCon->query($q);
				  if(!$result){
					echo "Select failed. Error: ".$objCon->error ;
				  }
				  $count = 0;
				  while($row=$result->fetch_array()){?>
				  <tr>
					<center>
						<td><center><img src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
						<td><?=$row['Full_Name']?></td>
						<td><center><?=$row['SUM(Quantity)']?></center></td>
						<td><center><?=$row['status']?></center></td>
					</center>
				  </tr>
				  <?php } ?>
				</table>
				<br>
				<?php
					$q="select note from history where ID = $ID";
					$result=$objCon->query($q);
					if(!$result){
						echo "Select failed. Error: ".$objCon->error ;
					}
					while($row=$result->fetch_array()){?>
						<table id="tb0">
							<tr>
								<th width="90">Note:</th><td><center><?=$row['note']?><br></center></td>
							</tr>
						</table>
					<?php }
				?>
				<br>
				<?php
					$q="SELECT status FROM history WHERE ID = '$ID'";
					$result1=$objCon->query($q);
					if(!$result1){
						echo "Select failed. Error: ".$objCon->error ;
					}
					$row1=$result1->fetch_array();
				?>
				<center>
					<form action="history2.php" method="post">
						<input type="hidden" name="fromdate" value="<?=$fd?>">
						<input type="hidden" name="todate" value="<?=$td?>">
						<?php
							if($row1['status'] == 'WaitingS'){
								echo '<a onclick="delpage()" class="button1">ลบคำขอนี้</a> | ';
							}
						?>
						<button type="submit" class="button1">ย้อนกลับ</button>
					</form>
				</center>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
	<script>
		function printpage() {
			window.print();
		}
		function delpage() {
				var r = confirm("คุณต้องการลบรายการนี้หรือไม่? คุณไม่อาจย้อนกลับได้");
				if (r == true) {
						window.location = "deletetype3.php?ID=<?=$ID?>&fd=<?=$fd?>&td=<?=$td?>";
				}
				else {
				}
		}
	</script>
</div>
</html>
