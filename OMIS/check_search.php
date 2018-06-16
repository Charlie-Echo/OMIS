<?php
	//session_start();
	require_once('connect.php');
	/*if(!isset($_POST['stockloc'])){ //If intentionally access this page
		if($_SESSION['ugroup']==1){
			header("Location: search.php");
		}
		elseif($_SESSION['ugroup']==2){
			header("Location: search2.php");
		}
	}*/
	$stockloc = $_SESSION['ubranch'];
	if(isset($_POST['submit'])){
		$keyword = $_POST['keyword'];

		$text_to_segment = trim($keyword);
        //echo '<b>ประโยคที่ต้องการตัดคือ: </b>' . $text_to_segment . '<br/>';
        include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'SplitThai/THSplitLib/segment.php');
        $segment = new Segment();
        //echo '<hr/>';
        $result = $segment->get_segment_array($text_to_segment);
		$arrlength = count($result);
	}
	elseif(!isset($_POST['submit'])){ //If intentionally access this page
		$keyword = "";
	}
	error_reporting(1)
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
					<li><a class="active" href="search.php">ค้นหา</a></li>
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
					<form action="check_search.php" method="post" id="searchform" onsubmit="return checkempty(document.getElementById('search'))">
						<table id="tb1" align= "center">
							<col width="30%">
							<col width="70%">
							<tr>
								<th><label>ป้อนคำค้นหา:</label></th>
								<th><input type="text" name="keyword" autofocus></th>
							</tr>
						</table>
						<br>
						<center>
							<input type="submit" name="submit" class="button1" value="ค้นหา">&nbsp; &nbsp;|&nbsp; &nbsp;
							<a class="button1" href="check_search.php">ค้นหาทั้งหมด</a>
						</center>
					</form>
					<br>
					<?php echo "<b>ผลการค้นหา</b>: ".$keyword."<br><br>";?>
					<table id="tb0">
						<table id="tb0">
							<tr>
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
							for($i=0; $i < $arrlength; $i++){ //Find total match
								$a .= "(Full_Name LIKE '%".$result[$i]."%')";
								if($i < $arrlength - 1){
									$a = $a."+";
								}
							}
							//echo $a;
							for($i=0; $i < $arrlength; $i++){ //Create MySQL search condition
								$aa .= "Full_Name LIKE '%".$result[$i]."%'";
								if($i < $arrlength - 1){
									$aa = $aa." OR ";
								}
							}
							//echo $aa;

							if($keyword==""){	//If user enter nothing, this will show all items
								$q="select * from $stockloc";
							}
							else{	//otherwise, search and list from most to least match strings
								$q="select *, ($a) as total from $stockloc WHERE ($aa) ORDER BY total DESC LIMIT 25"; //OR Date LIKE '%$keyword%'
							}

							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$mysqli->error ;
							}
							while($row=$result->fetch_array()){
								$ID = $row['ID'];
								$qq="select detail.CostPerUnit from detail, history where detail.Type = 3 AND history.Type = 3 AND history.From_stock = '$stockloc' AND detail.Item_ID = $ID AND detail.Order_ID = history.ID ORDER BY Detail_ID DESC LIMIT 1";
								$result1=$objCon->query($qq);
								if(!$result1){
									echo "Select failed. Error: ".$objCon->error ;
								}
								$row1=$result1->fetch_array();
								//echo($row1['CostPerUnit']);
								?>
								<tr>
								<center>
									<td><center><img src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
									<td><center><?=$row['Code']?></center></td>
									<td><?=$row['Full_Name']?></td>
									<td><center><?=$row['QLeft']." ".$row['Unit']?></center></td>
									<td><center><?php echo(number_format($row1['CostPerUnit'],2));?></center></td>
									<td><center><?php echo(number_format($row1['CostPerUnit']*1.07,2));?></center></td>
									<td><center><?php echo(number_format($row1['CostPerUnit']*(1.07*$row['QLeft']),2));?></center></td>
									<td><center><a href="selectyear.php?ID=<?=$row['ID']?>">ดูข้อมูล</a></center></td>
									<td><center><a href="edititem.php?ID=<?=$row['ID']?>">แก้ไข</a></center></td>
								</center>
							<?php } ?>
						</table>
						<br>
					<center><a href="search.php" class="button1">ย้อนกลับ</a></center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
