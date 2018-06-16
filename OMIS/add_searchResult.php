<?php
	//session_start();
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
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
			header("Location: add.php");
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
					<li><a href="search.php">ค้นหา</a></li>
					<li>
						<div class="dropdown">
						<a href="add.php" class="active">นำเข้า</a>
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
					<form action="add_searchResult.php" method="post">
						<br>
						<table id="tb1" align= "center">
							<tr>
								<th><label>ป้อนคำค้นหา:</label></th>
								<th><input type="text" name="keyword" autofocus></th>
							</tr>
						</table>
						<br>
						<center>
							<input type="submit" name="submit" class="button1" value="ค้นหา">&nbsp; &nbsp;|&nbsp; &nbsp;
							<a href="add_cart.php" class="button1">ไปยังตะกร้า</a>
						</center>
					</form>
					<br>
					<?php echo "<b>ผลการค้นหา</b>: ".$keyword."<br><br>";?>
					<table id="tb0">
						<table id="tb0">
							<tr>
								<th><center>ภาพ</center></th>
								<th><center>รายการ</center></th>
								<th><center>หน่วยนับ</center></th>
								<th><center>ราคาต่อหน่วย</center></th>
								<th><center>จำนวน</center></th>
								<th><center>เพิ่ม</center></th>
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
								$q="select * from item WHERE 1";
							}
							else{	//otherwise, search and list from most to least match strings
								$q="select *, ($a) as total from item WHERE ($aa) ORDER BY total DESC LIMIT 25"; //OR Date LIKE '%$keyword%'
							}
							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$mysqli->error ;
							}

							while($row=$result->fetch_array()){ ?>
								<tr>
								<center>
								<form action="add_haha.php" method="post">
									<td><center><img src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
									<td><?=$row['Full_Name']?></td>
									<td><center><?=$row['Unit']?></center></td>
									<td><center><input type="number" step="any" name="price" value="0.00" id="in1"></center></td>
									<td>
										<input type="hidden" name="name" value="<?php echo $row['Full_Name'];?>">
										<center><input type="number" name="quantity" value="1" id="in1"></center>
									</td>
									<td><center><input type="submit" value="เพิ่ม"></center></td>
								</form>
								</center>
							<?php } ?>
						</table>
						<br>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
