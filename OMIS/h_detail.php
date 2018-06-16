<?php
	require_once('connect.php');
	//session_start();
	$ID = $_GET["ID"];
	$Type = $_GET["Type"];
	$orderNO = $_GET["orderNO"];
	$branch = $_SESSION['ubranch'];
	$itemname = array();
	$i = 0;
	$price = 0;
	$fd = $_GET["fd"];
	$td = $_GET["td"];
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

					<?php if(!$orderNO==""){
						$q="select TRcode, NumCount, Year from history where ID = $ID";
						$result=$objCon->query($q);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						echo("<h3>รายการที่: ".$row['TRcode']."/".$row['NumCount']."/".$row['Year']."</h3><br>");

					?>	<!--ถ้ามีเลข Order_ID -->
						<table id="tb3">
							<?php
							$p="select * from import_list where Order_ID = '$ID'";
							$result2=$objCon->query($p);
							if(!$result2){
								echo "Select failed. Error: ".$objCon->error ;
							}
							while($row2=$result2->fetch_array()){?>
								<tr>
									<center>
										<th><img src="pencil.png" width="15" height="15"> รายการสั่งซื้อเลขที่: <?=$row2['Number']?></th>
										<th><img src="pencil.png" width="15" height="15"> จากบริษัท: <?=$row2['Supplier']?></th>
									</center>
								</tr>
								<tr>
									<center>
										<th><img src="pencil.png" width="15" height="15"> วันที่นำเข้า: <?=$row2['Date']?></th>
										<th><img src="pencil.png" width="15" height="15"> หมายเหตุ: <?=$row2['Note']?></th>
									</center>
								</tr>
							<?php } ?>
						</table>
						<br>

						<?php
							$qqq="select $branch.ID from $branch, detail where $branch.ID = detail.Item_ID AND detail.Order_ID = $ID";
							$result11=$objCon->query($qqq);
							if(!$result11){
								echo "Select failed. Error: ".$objCon->error ;
							}
							while($row11=$result11->fetch_array()){
								$itemname[$i] = $row11['ID'];
								$i++;
							}
							$i = 0;

							for($i=0;$i<count($itemname);$i++){
								$qq="select Full_Name from $branch where ID = $itemname[$i]";
								$result1=$objCon->query($qq);
								if(!$result1){
									echo "Select failed. Error: ".$objCon->error ;
								}
								$row1=$result1->fetch_array();
								$itemname[$i] = $row1['Full_Name'];
							}
						?>
						<div align="right">
							<a onclick="delpage()" class="button1">ลบใบสั่งซื้อนี้</a>
						</div>
						<table id="tb0">
							<tr>
								<th><center>รายการ</center></th>
								<th><center>จำนวน</center></th>
								<th><center>ราคาต่อหน่วย(บาท)</center></th>
								<th><center>ราคาต่อหน่วย(VAT 7%)</center></th>
								<th><center>ราคาสุทธิ</center></th>
							</tr>
							<?php
							$i = 0;
							$q="select * from detail where detail.Order_ID = $ID";
							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$objCon->error ;
							}
							while($row=$result->fetch_array()){?>
								<tr>
									<center>
										<td><?php echo($itemname[$i]);?></td>
										<td><center><?=$row['Quantity']?></center></td>
										<td><center><?=number_format($row['CostPerUnit'],2)?></center></td>
										<td><center><?=number_format($row['CostPerUnit']*(1.07),2)?></center></td>
										<td><center>
											<?php
												echo(number_format($row['CostPerUnit']*(1.07)*$row['Quantity'],2));
												$price += $row['CostPerUnit']*(1.07)*$row['Quantity'];
											?>
										</center></td>
									</center>
								</tr>
							<?php $i++;
							} ?>
						</table>
						<br>
						<div align="right"><b><u>ราคาสุทธิ:</u></b> <?php echo(number_format($price,2)); ?> บาท</div>

					<?php } elseif($orderNO==""){
						$q="select TRcode, NumCount, Year from history where ID = $ID";
						$result=$objCon->query($q);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						echo("<h3>รายการที่: ".$row['TRcode']."/".$row['NumCount']."/".$row['Year']."</h3><br>");

					?>	<!--ถ้าไม่มีมีเลข Order_ID -->
						<table id="tb0">
							<tr>
								<th><center>ภาพ</center></th>
								<th><center>รายการ</center></th>
								<th><center>จำนวน</center></th>
								<th><center>ราคาต่อหน่วย</center></th>
								<th><center>ราคารวมVAT(7%)</center></th>
								<th><center>ราคาสุทธิ</center></th>
								<th><center>สถานะ</center></th>
							</tr>
							<?php
							$q="select detail.*, $branch.* from detail, $branch where detail.Item_ID = $branch.ID and detail.Order_ID = $ID ORDER BY detail.Item_ID";
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
										<td><center><?=number_format($row['Quantity'],2)?></center></td>
										<td><center><?=number_format($row['CostPerUnit'],2)?></center></td>
										<td><center><?php echo(number_format($row['CostPerUnit']*(107/100),2));?></center></td>
										<td>
											<center>
												<?php
													echo(number_format($row['CostPerUnit']*(107/100 * $row['Quantity']),2));
													$price += ($row['CostPerUnit']*(107/100 * $row['Quantity']));
												?>
											</center>
										</td>
										<td><center><?=$row['status']?></center></td>
									</center>
								</tr>
							<?php } ?>
						</table>
						<br>
						<div align="right"><b><u>ราคาสุทธิ:</u></b> <?php echo(number_format($price,2)); ?> บาท</div>
					<?php } ?>
					<center>
						<form action="history.php" method="post">
							<input type="hidden" name="fromdate" value="<?=$fd?>">
							<input type="hidden" name="todate" value="<?=$td?>">
							<button onclick="printpage()" class="button1">พิมพ์รายงาน</button> |
							<button type="submit" class="button1">ย้อนกลับ</button>
						</form>
					</center>

					<script>
						function printpage() {
							window.print();
						}
						function delpage() {
						    var r = confirm("คุณต้องการลบรายการนี้หรือไม่? คุณไม่อาจย้อนกลับไปได้");
						    if (r == true) {
						        window.location = "deletetype1.php?ID=<?=$ID?>&fd=<?=$fd?>&td=<?=$td?>";
						    }
								else {
						    }
						}
					</script>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
