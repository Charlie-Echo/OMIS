<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$branch = $_SESSION['ubranch'];

	$perpage = 25;
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	else {
		$page = 1;
	}
	 $start = ($page - 1) * $perpage;
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
					<li style="float:right"><a href="manual.pdf">คู่มือการใช้งาน</a></li>
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
				<center><h1>รายการวัสดุทั้งหมด</h1></center>
				<div align="right">
					<a href="index_excel.php" class="button1">เปิดใน Excel(หน้าเดียว)</a> |
					<button onclick="printpage()" class="button1">พิมพ์รายงาน(หน้าเดียว)</button>
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
						<th><center>แก้ไขรายการ</center></th>
					</tr>
					<?php
					$finalprice = 0;
					$q="select * from $branch limit $start , $perpage";
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
						$sql2 = "select * from $branch ";
						$query2 = mysqli_query($objCon, $sql2);
						$total_record = mysqli_num_rows($query2);
						$total_page = ceil($total_record / $perpage);
					?>
					<tr>
						<center>
							<form action="haha.php" method="post">
								<td><center><?=$row['ID']?></center></td>
								<td><center><img src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
								<td><center><?=$row['Code']?></center></td>
								<td><?=$row['Full_Name']?></td>
								<td>
									<center>
										<?php
											echo($row['QLeft']." ".$row['Unit']);
											if($row['QLeft'] == 0){
												echo "<br><font color = 'red'><b>ของหมด</b></font>";
											}
										?>
									</center>
								</td>
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
								<td><center><a href="edititem.php?ID=<?=$row['ID']?>">แก้ไข</a></center></td>
							</form>
						</center>
					</tr>
					<?php } ?>
				</table>
				<!-- </div> -->
				<br>
				<div align="right"><b><u>ราคาสุทธิ(หน้านี้):</u></b> <?php echo number_format($finalprice,2) ; ?> บาท</div>
				<br>
				<nav class="noprint">
					<ul id="ul2" class="pagination">
					<?php
						if($page != 1){ ?>
							<li>
									<a href="index.php?page=<?php echo $page-1;?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
							</li>
					<?php } ?>
						<center>
							<?php
								for($i=1;$i<=$total_page;$i++){
									if($i==$page){
										echo '<li><a class="active" href="index.php?page='.$i.'"> '.$i.'</a></li>';
									}
									else{
										echo '<li><a href="index.php?page='.$i.'"> '.$i.'</a></li>';
									}
			 					}
							?>
						</center>
						<?php
							if($page != $total_page){ ?>
								<li>
									<a href="index.php?page=<?php echo $page+1;?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
						<?php } ?>
						<li><a href="indexshowall.php"><b>ดูทั้งหมด</b></a></li>
					</ul>
				</nav>
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
