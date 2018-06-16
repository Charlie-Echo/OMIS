<?php
	require_once('connect.php');
	$branch = $_SESSION['ubranch'];
	$fd = $_GET["fromdate"];
	$td = $_GET["todate"];
	//$ID = $_GET["ID"];
	$uname = $_SESSION['uname'];
	$costget = 0;
	$costpay = 0;
	//error_reporting(0);

	$strExcelFileName="รายการความเคลื่อนไหว-".$_SESSION['branchfullname']."-".$fd."ถึง".$td.".xls";
	header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
	header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
	header("Pragma:no-cache");
?>

<!DOCTYPE HTML>
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<body>
		<br><br>
		<table id="tb0">
			<tr>
				<th colspan="4"><center><b>รายการรับ</b></center></th>
				<th></th>
				<th colspan="4"><center><b>รายการจ่าย</b></center></th>

			</tr>
			<tr>
				<th><center>รายการ</center></th>
				<th><center>วันที่</center></th>
				<th><center>มูลค่า</center></th>
				<th><center>มูลค่ารวมVAT(7%)</center></th>
				<th></th>
				<th><center>รายการ</center></th>
				<th><center>วันที่</center></th>
				<th><center>มูลค่า</center></th>
				<th><center>มูลค่ารวมVAT(7%)</center></th>
			</tr>
			<?php
				$q="SELECT history.Date, history.ID, history.TRcode, history.NumCount, history.Year, history.Type, SUM(CostPerUnit * Quantity)
				FROM history, detail WHERE history.ID = detail.Order_ID AND detail.status = history.status AND
				(history.status = 'Imported' OR history.status = 'Approved') AND history.Type = detail.Type AND history.Type != '2'
				AND history.From_stock = '$branch' AND history.Date between '$fd' and '$td 23:59:59' GROUP BY history.ID";
				$result=$objCon->query($q);
				if(!$result){
					echo "Select failed. Error: ".$objCon->error ;
				}
				while($row=$result->fetch_array()){		//PHP ใช้ทรัพยากรเยอะที่สุด
					?>
					<tr>
						<td><center>	<!--เริ่มรายการรับ-->
							<?php
								if($row['Type'] == 3){
									echo $row['TRcode']."/".$row['NumCount']."/".$row['Year'];
								}
							?>
						</center></td>
						<td><center>
							<?php
								if($row['Type'] == 3){
									echo $row['Date'];
								}
							?>
						</center></td>
						<td><center>
							<?php
								if($row['Type'] == 3){
									echo number_format($row['SUM(CostPerUnit * Quantity)'],2);
								}
							?>
						</center></td>
						<td><center>
							<?php
								if($row['Type'] == 3){
									$costget += $row['SUM(CostPerUnit * Quantity)']*1.07;
									echo number_format($row['SUM(CostPerUnit * Quantity)']*(107/100),2);
								}
							?>
						</center></td>
						<td></td>			<!--เว้นที่1หลักเพื่อแยกรายการ2พวกออกจากกัน-->
						<td><center>	<!--เริ่มรายการจ่าย-->
							<?php
								if($row['Type'] == 1){
									echo $row['TRcode']."/".$row['NumCount']."/".$row['Year'];
								}
							?>
						</center></td>
						<td><center>
							<?php
								if($row['Type'] == 1){
									echo $row['Date'];
								}
							?>
						</center></td>
						<td><center>
							<?php
								if($row['Type'] == 1){
									echo number_format($row['SUM(CostPerUnit * Quantity)'],2);
								}
							?>
						</center></td>
						<td><center>
							<?php
								if($row['Type'] == 1){
									$costpay += $row['SUM(CostPerUnit * Quantity)']*1.07;
									echo number_format($row['SUM(CostPerUnit * Quantity)']*1.07,2);
								}
							?>
						</center></td>
					</tr>
					<?php
				}
			?>
			<tr></tr>
			<tr>
				<td><b><u>ราคาสุทธิ(รายการรับ):</u></b> <?php echo number_format($costget,2); ?> บาท</td>
				<td></td>
				<td></td>
				<td></td>
				<td><b><u>ราคาสุทธิ(รายการจ่าย):</u></b> <?php echo number_format($costpay,2); ?> บาท</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</body>
</html>
<script>
	window.onbeforeunload = function(){return false;};
	setTimeout(function(){window.close();}, 10000);
</script>
