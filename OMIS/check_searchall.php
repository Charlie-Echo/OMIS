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
	if(isset($_POST['submit'])){
		$keyword = $_POST['keyword'];
		$stockloc = $_SESSION['ubranch'];

		$text_to_segment = trim($keyword);
        //echo '<b>ประโยคที่ต้องการตัดคือ: </b>' . $text_to_segment . '<br/>';
        include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'SplitThai/THSplitLib/segment.php');
        $segment = new Segment();
        //echo '<hr/>';
        $result = $segment->get_segment_array($text_to_segment);
		$arrlength = count($result);
        /*$wordarray = implode(' ', $result);
		echo $wordarray[0];
		echo $result[0];
		echo("<br>");
		echo $result[1];
		echo $arrlength;*/
		//echo($stockloc);
	}
	elseif(!isset($_POST['submit'])){ //If intentionally access this page
		if($_SESSION['ugroup']==1){
			header("Location: search.php");
		}
		elseif($_SESSION['ugroup']==2){
			header("Location: search2.php");
		}
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
					<li><a href="add.php">นำเข้า</a></li>
					<li><a href="history.php">ประวัติ</a></li>
					<li><a href="request.php">คำร้อง</a></li>
					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">
					<?php echo "<b>ผลการค้นหา</b>: ".$keyword."<br><br>";?>
					<table id="tb0">
						<table id="tb0">
							<tr>
								<th>ลำดับที่</th>
								<th>ภาพ</th>
								<th>รหัส</th>
								<th>รายการ</th>
								<!--<th>วันที่นำเข้า</th>
								<th>ราคา</th> -->
								<th>คงเหลือ</th>
								<th>หน่วยนับ</th>
								<th>เลขที่ใบเสร็จ</th>
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
								$q="select * from $stockloc WHERE 1";
							}
							else{	//otherwise, search and list from most to least match strings
								$q="select *, ($a) as total from $stockloc WHERE ($aa) ORDER BY total DESC"; //OR Date LIKE '%$keyword%'
							}
							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$mysqli->error ;
							}
							while($row=$result->fetch_array()){ ?>
								<tr>
								<center>
									<td><?=$row['ID']?></td>
									<td><img src="<?=$row['Pic'] ?>" height="100" width="100"></td>
									<td><?=$row['Code']?></td>
									<td><?=$row['Full_Name']?></td>
									<td><?=$row['QLeft']?></td>
									<td><?=$row['Unit']?></td>
									<td><?=$row['ReceiptNo']?></td>
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
