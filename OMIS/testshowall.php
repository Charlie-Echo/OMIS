<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
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
			<div id="div_header" class="noprint">
				<center><img src="logo.jpg" alt="logo"></center>
				<br>
				<center><h1>Office Material Inventory System</center>
			</div>
			<div id="div_subhead">
				<ul>
					<li><a class="active" href="index.php">รายการ</a></li>
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
					<li><a href="request.php">คำร้อง</a></li>
					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li style="float:right"><a href="changepass.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
			</div>
		<div id="div_main">
			<div id="div_content">
				<center><h2>รายการวัสดุทั้งหมด</h2></center>
				<div align="right">
					<button onclick="printpage()" class="button1">พิมพ์รายงาน(ทั้งหมด)</button>
				</div>
				<table id="tb0">
					<tr>
						<th><center>ลำดับที่</center></th>
						<th><center>ภาพ</center></th>
						<th><center>รหัส</center></th>
						<th><center>รายการ</center></th>
						<th><center>คงเหลือ</center></th>
						<th><center>ราคา(บ.)</center></th>
						<th><center>ราคารวมVAT(7%, บ.)</center></th>
						<th><center>ราคาสุทธิ(บ.)</center></th>
						<th><center>ความเคลื่อนไหว</center></th>
					</tr>
					<?php
					$finalprice = 0;
					$q="select * from $branch";
					$result=$objCon->query($q);
					if(!$result){
  						echo "Select failed. Error: ".$objCon->error ;
					}

					while($row=$result->fetch_array()){
						$ID = $row['ID'];
						$qq="select detail.CostPerUnit from detail, history where detail.Type = 3 AND history.Type = 3 AND history.From_stock = '$branch' AND detail.Item_ID = $ID AND detail.Order_ID = history.ID ORDER BY Detail_ID DESC LIMIT 1";
						$result1=$objCon->query($qq);
						if(!$result1){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row1=$result1->fetch_array();
						//echo($row1['CostPerUnit'])
					?>
					<tr>
						<center>
							<form action="haha.php" method="post">
								<td><center><?=$row['ID']?></center></td>
								<td><center><img src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
								<td><center><?=$row['Code']?></center></td>
								<td><?=$row['Full_Name']?></td>
								<td><center><?php echo($row['QLeft']." ".$row['Unit']);?></center></td>
								<td><center><?php echo(number_format($row1['CostPerUnit'],2));?></center></td>
								<td><center><?php echo(number_format($row1['CostPerUnit']*1.07,2));?></center></td>
								<td>
									<center>
										<?php
											echo(number_format($row1['CostPerUnit']*(1.07*$row['QLeft']),2));
											$finalprice += $row1['CostPerUnit']*(1.07*$row['QLeft']);
										?>
									</center>
								</td>
								<td><center><a href="selectyear.php?ID=<?=$row['ID']?>">ดูข้อมูล</a></center></td>
							</form>
						</center>
					</tr>
					<?php } ?>
				</table>
				<br>
				<div align="right"><b><u>ราคาสุทธิรวม:</u></b> <?php echo number_format($finalprice,2) ; ?> บาท</div>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</div>
	</body>
	<script>
		function printpage() {
			window.print();
		}
	</script>
</html>
