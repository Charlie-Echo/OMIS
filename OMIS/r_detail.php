<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	//session_start();
	$ID = $_GET["ID"];
	$_SESSION["hID"] = $ID;
	//$user = $_GET["user"];

	$qq="SELECT * from history WHERE ID = $ID and status = 'Waiting'";
    $result=$objCon->query($qq);
	if(!$result){
  		echo "Select failed. Error: ".$objCon->error ;
	}
	$row1=$result->fetch_array();
    if($row1['ID'] == ''){
    	header("location:index.php");
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
					<li style="float:right"><a>ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">
					<table id="tb0">
						<col width="10%">
						<col width="40%">
						<col width="5%">
						<col width="15%">
						<col width="15%">
						<col width="10%">
						<col width="5%">
						<tr>
							<th><center>รูป</center></th>
							<th><center>รายการ</center></th>
							<th><center>จำนวน</center></th>
							<th><center>เบิกจากคลัง</center></th>
							<th><center>เข้าคลัง</center></th>
							<th><center>สถานะ</center></th>
							<th><center>อนุมัติ</center></th>
						</tr>
						<?php
						//$q="select detail.*,rs_stock.*, history.* from detail,rs_stock,history where detail.Item_ID=rs_stock.ID and detail.Order_ID = $ID and history.status = 'Waiting' and history.user = '$user' and history.ID = $ID";
						$q="select detail.*,$branch.*, history.* from detail,$branch,history where detail.Item_ID=$branch.ID
						and detail.Order_ID = $ID and history.status = 'Waiting' and history.ID = $ID AND history.From_stock = '$branch'";

						$result=$objCon->query($q);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$reqItem = 0;
						while($row=$result->fetch_array()){
							$reqItem = $reqItem + 1;

							$tostockcode = $row['To_stock'];
							$qq="select branch_name from user where branch = '$tostockcode'";
							$result11=$objCon->query($qq);
							if(!$result11){
								echo "Select failed. Error: ".$objCon->error ;
							}
							$row11=$result11->fetch_array();
							?>
							<tr>
								<center>
									<td><center><img <?php if($row['Pic'] != 'Pic/noimage.jpg') { echo "class='rotate'"; } ?> src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
									<td><?=$row['Full_Name']?></td>
									<td>
										<center>
										<form action="r_check.php?ID=<?php echo $row['Detail_ID']; ?>&NO=<?php echo $reqItem; ?>&OrderID=<?php echo $ID; ?>" method="post">
											<input type="hidden" name="Full_Name" value="<?php echo $row['Full_Name'];?>">
											<?php
											if($row['QLeft'] > 0){
												if(!isset($_SESSION["newQty"])){?>
													<input type="number" name="<?php echo 'txtQty'.$reqItem;?>" value="<?= $row['Quantity']; ?>" id="in1">
												<?php }elseif(isset($_SESSION["newQty"][$reqItem])){ ?>
													<input type="number" name="<?php echo 'txtQty'.$reqItem;?>" value="<?= $_SESSION["newQty"][$reqItem]; ?>" id="in1">
												<?php }else{ ?>
													<input type="number" name="<?php echo 'txtQty'.$reqItem;?>" value="<?= $row['Quantity']; ?>" id="in1">
												<?php }
											}
											else{
												echo "<b><font color='red'>ของหมด</font></b>";
											}
											?>
										</center>
									</td>
									<td><center><?php
									if($branch == 'rs_stock'){
										echo("คลังใหญ่รังสิต");
									}
									elseif($branch == 'bkd_stock'){
										echo("คลังใหญ่บางกะดี");
									}
									?></center></td>
									<td><center><?=$row11['branch_name']?></center></td>
									<td>
										<?php
										if(!isset($_SESSION["stat"])){
											echo "<b><font color='red'>รอการยืนยัน</font></b>";
										}elseif(isset($_SESSION["stat"][$reqItem]) && ($_SESSION["stat"][$reqItem]) == "Approved"){
											echo "<b><font color='green'>อนุมัติ</font></b>";
										}else{
											echo "<b><font color='red'>รอการยืนยัน</font></b>";
										}
										?>
									</td>
									<?php
										if($row['QLeft'] > 0){
											echo "<td><input type='submit' value='ยืนยัน'></td>";
										}
										else{
											echo "<td><input type='submit' disabled value='ยืนยัน'></td>";
										}
									?>
									</form>
								</center>
							</tr>
							<?php
							$_SESSION["fromstock"] = $row['From_stock'];
							$_SESSION["tostock"] = $row['To_stock'];
							$_SESSION["reqItem"] = $reqItem;
						} ?>
					</table>
					<br><br>
					<?php
					if($reqItem > 0){
						if(isset($_SESSION["stat"])){ ?>
							<table id="tb2">
								<col width="50%">
								<col width="50%">
								<th><center><a class="button1" href="r_cancel.php">ยกเลิก</a></center></th>
								<th><center><a class="button1" href="r_approve.php">ยืนยัน</a></center></th>
							</table>
						<?php }else{ ?>
							<table id="tb2">
								<col width="50%">
								<col width="50%">
								<th><center><a class="button1" href="r_cancel.php">ยกเลิก</a></center></th>
								<th><center><a class="button1" href="r_reject.php">ไม่อนุมัติทั้งหมด</a></center></th>
							</table>
					<?php }
					} ?>
					<br>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
