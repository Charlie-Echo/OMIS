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
		<h2>ข้อมูลการเบิกวัสดุของหน่วยงาน<?=$_SESSION['branchfullname']?>ตั้งแต่:  <?=$fd?> ถึง: <?=$td?></h2>
		<table id="tb0">
			<tr>
				<th><center><b>รายการ</b></center></th>
				<th><center><b>จำนวน</b></center></th>
			</tr>
			<?php
				$q="SELECT item.Full_Name, SUM(detail.Quantity) FROM item, detail, history WHERE
				detail.Item_ID = item.ID AND history.Type = detail.Type AND history.Type = 1 AND
				detail.Order_ID = history.ID AND history.To_stock = '$branch' AND history.status = 'Approved' GROUP BY item.Full_Name";
				$result=$objCon->query($q);
				if(!$result){
					echo "Select failed. Error: ".$objCon->error ;
				}
				while($row=$result->fetch_array()){		//PHP ใช้ทรัพยากรเยอะที่สุด
					?>
					<tr>
						<td><center>	<!--เริ่มรายการรับ-->
							<?php
									echo $row['Full_Name'];
							?>
						</center></td>
						<td><center>
							<?php
									echo $row['SUM(detail.Quantity)'];
							?>
						</center></td>
					</tr>
					<?php
				}
			?>
		</table>
	</body>
</html>
<script>
	window.onbeforeunload = function(){return false;};
	setTimeout(function(){window.close();}, 10000);
</script>
