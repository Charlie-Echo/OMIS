<?php
	require_once('connect.php');
	$branch = $_SESSION['ubranch'];
	$fd = $_GET["fromdate"];
	$td = $_GET["todate"];
	$ID = $_GET["ID"];
	$uname = $_SESSION['uname'];
	$name ="SELECT $branch.Full_Name, $branch.Code, user.branch_name from $branch, user WHERE $branch.ID = $ID AND user.branch = '$branch'";
	$result=$objCon->query($name);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$row=$result->fetch_array();

	$strExcelFileName="รายการความเคลื่อนไหว-".$row['Full_Name']."-".$_SESSION['branchfullname']."-".$fd."ถึง".$td.".xls";
	header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
	header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
	header("Pragma:no-cache");
?>

<!DOCTYPE HTML>
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<body>
		<?php
		echo("<h3>รายการความเคลื่อนไหวของ: ". $row['Full_Name']."(รหัส: ". $row['Code'].") สาขา: ". $row['branch_name']." </h3>");
		echo("ตั้งแต่วันที่: ".$fd." จนถึงวันที่: ".$td);
		?>
		<br><br>

		<table id="tb0">
			<tr>
				<th><center>ลำดับที่</center></th>
				<th><center>วันที่/เวลา</center></th>
				<th colspan="2"><center><u>รหัส</u></center></th>
				<th><center>ประเภท</center></th>
				<th><center>จากคลัง</center></th>
				<th><center>ถึงคลัง</center></th>
				<th colspan="4"><center><u>รายการรับ</u></center></th>
				<th colspan="4"><center><u>รายการจ่าย</u></center></th>
				<th><center>คงเหลือ</center></th>
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th><center>รายการ</center></th>
				<th><center>เลขสั่งซื้อ</center></th>
				<th></th>
				<th></th>
				<th></th>
				<th><center>ปริมาณ</center></th>
				<th><center>ราคาต่อหน่วย</center></th>
				<th><center>ราคารวมVAT(7%)</center></th>
				<th><center>ราคาสุทธิ</center></th>
				<th><center>ปริมาณ</center></th>
				<th><center>ราคาต่อหน่วย</center></th>
				<th><center>ราคารวมVAT(7%)</center></th>
				<th><center>ราคาสุทธิ</center></th>
				<th></th>
			</tr>
			<?php
			$ftqty = 0;
			$costfirsttime = 0;
			$qty = "SELECT * from history, detail WHERE (history.Type = 1 OR history.Type = 3 OR detail.Type = 1 OR detail.Type = 3) AND
			history.From_stock = '$branch' AND detail.Order_ID = history.ID AND detail.Item_ID = '$ID'
			AND history.Date between '2018-01-01' and '$fd 00:00:01' AND
			(detail.status = 'Approved' OR history.status = 'Approved' OR detail.status = 'Imported' OR history.status = 'Imported')";
			$result1=$objCon->query($qty);
			if(!$result1){
				echo "Select failed. Error: ".$objCon->error ;
			}
			while($row1=$result1->fetch_array()){
				if($row1['Type'] == 1){
					$ftqty -= $row1['Quantity']; //row1 = first time variable
				}
				elseif($row1['Type'] == 3){
					$ftqty += $row1['Quantity']; //row1 = first time variable
				}	//นับจำนวนของก่อนเริ่มเช็คเวลา
			}

			$costft = "SELECT detail.CostPerUnit from history, detail WHERE (history.Type = '3' AND detail.Type = '3') AND
			history.From_stock = '$branch' AND detail.Order_ID = history.ID AND detail.Item_ID = '$ID' AND history.Date between '2018-01-01' and '$fd 00:00:01'
			ORDER BY history.Date DESC LIMIT 1";
			$result2=$objCon->query($costft);
			if(!$result2){
				echo "Select failed. Error: ".$objCon->error ;
			}
			$row2=$result2->fetch_array();
			$costfirsttime = $row2['CostPerUnit'];	//ราคาของการImportครั้งสุดท้ายก่อนเริ่มเช็คเวลา

			?>

			<td><center>1</center></td>
			<td></td>
			<td><b><center>ยอดยกมา</center></b></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><center><?php echo(number_format($ftqty));	?></center></td>
			<td>
				<center>
					<?php
					if($ftqty > 0){
						echo(number_format($costfirsttime,2));
					}
					else {
						echo ("0");
					}
					?>
				</center>
				<td>
					<center>
						<?php
						if($ftqty > 0){
							echo(number_format($costfirsttime*(107/100),2));
						}
						else {
							echo ("0");
						}
						?>
					</center>
				</td>
				<td>
					<center>
						<?php
						if($ftqty > 0){
							echo(number_format($costfirsttime*(107/100)*$ftqty,2));
						}
						else {
							echo ("0");
						}
						?>
					</center>
				</td>
				<td><center>-</center></td>
				<td><center>-</center></td>
				<td><center>-</center></td>
				<td><center>-</center></td>
				<td><center><?php echo($ftqty);	?></center></td>

				<?php
				$q="SELECT * from history, detail WHERE (history.Type = 1 OR history.Type = 3 OR detail.Type = 1 OR detail.Type = 3)
				AND history.From_stock = '$branch' AND detail.Order_ID = history.ID AND detail.Item_ID = '$ID'
				AND (detail.status = 'Approved' OR history.status = 'Approved' OR detail.status = 'Imported' OR history.status = 'Imported')
				AND history.Date between '$fd' and '$td 23:59:59'";	//ทำรายการที่2เป็นต้นไป		ถ้าJoinกันได้จะefficientกว่านี้
				$result=$objCon->query($q);
				if(!$result){
					echo "Select failed. Error: ".$objCon->error ;
				}

				$i=2;
				while($row=$result->fetch_array()){		//PHP ใช้ทรัพยากรเยอะที่สุด
					if(!isset($costfirsttime)){
						$costfirsttime = $row['CostPerUnit'];
					}
					$tostockcode = $row['To_stock'];
					$qq="SELECT branch_name FROM user WHERE branch = '$tostockcode'";	//ถ้าJoinกันได้จะefficientกว่านี้
					$result11=$objCon->query($qq);
					if(!$result11){
						echo "Select failed. Error: ".$objCon->error ;
					}
					$row11=$result11->fetch_array();
					?>
					<tr>
						<center>
							<td><center><?php echo($i);	//ลำดับที่	?></center></td>
							<td><center><?=$row['Date']; 	//วันที่/เวลา	?></center></td>
							<td><center><?php echo($row['TRcode']."/".$row['NumCount']."/".$row['Year']); 	//รหัส	 ?></center></td>
							<td><center>
								<?php	//เลขใบสั่งซื้อ
								if($row['Type'] == 3 && $row['order_number'] != ''){
									echo($row['order_number']);
								}
								else{
									echo("-");
								}
								?>
							</center></td>
							<td><center>
								<?php	//ประเภท
								if($row['Type'] == 1){
									echo("จ่ายออก");
								}
								elseif($row['Type'] == 3){
									echo("นำเข้า");
								}
								?>
							</center></td>
							<td><center>
								<?php	//จากคลัง
								if($branch == 'rs_stock'){
									echo("คลังใหญ่รังสิต");
								}
								elseif($branch == 'bkd_stock'){
									echo("คลังใหญ่บางกะดี");
								}
								?>
							</center></td>
							<td><center>
								<?php	//ถึงคลัง
								/*if($row['Type'] == 1){
								echo($row11['branch_name']);
							}
							elseif($row['Type'] == 3){
							echo("-");
						}*/
						echo($row11['branch_name']);
						?>
					</center></td>
					<td><center>
						<?php	//เริ่มรายการรับ
						if($row['Type'] == 1){
							echo("-");
						}
						elseif($row['Type'] == 3){
							echo(number_format($row['Quantity']));
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							echo("-");
						}
						elseif($row['Type'] == 3){
							echo(number_format($row['CostPerUnit'],2));
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							echo("-");
						}
						elseif($row['Type'] == 3){
							echo(number_format($row['CostPerUnit']*(107/100),2));
							$costfirsttime = $row['CostPerUnit'];
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							echo("-");
						}
						elseif($row['Type'] == 3){
							echo(number_format($row['CostPerUnit']*(107/100)*$row['Quantity'],2));
						}
						?>
					</center></td>
					<td><center>
						<?php	//เริ่มรายการจ่าย
						if($row['Type'] == 1){
							echo(number_format($row['Quantity']));
						}
						elseif($row['Type'] == 3){
							echo("-");
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							echo(number_format($row['CostPerUnit'],2));
						}
						elseif($row['Type'] == 3){
							echo("-");
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							echo(number_format($row['CostPerUnit']*(107/100),2));
						}
						elseif($row['Type'] == 3){
							echo("-");
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							echo(number_format($row['CostPerUnit']*(107/100)*$row['Quantity'],2));
						}
						elseif($row['Type'] == 3){
							echo("-");
						}
						?>
					</center></td>
					<td><center>
						<?php
						if($row['Type'] == 1){
							$ftqty -= $row['Quantity'];
						}
						elseif($row['Type'] == 3){
							$ftqty += $row['Quantity'];
						}
						echo(number_format($ftqty));
						?>
					</center></td>
				</center>
			</tr>
			<?php
			$i++;
		}
		?>
		</table>
		<br>
		<div align="right"><b><u>ราคาสุทธิรวม:</u></b> <?php echo(number_format($costfirsttime*$ftqty*(107/100),2)); ?> บาท</div>
	</body>
</html>
<script>
	window.onbeforeunload = function(){return false;};
	setTimeout(function(){window.close();}, 10000);
</script>
