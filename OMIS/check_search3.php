<?php
	//session_start();
	require_once('connect.php');
	$branch = $_SESSION['ubranch'];
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
		$stockloc = $_SESSION["Fromloc"];

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
		else{
			header("Location: login.php");
		}
	}
	error_reporting(1)
?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  		<title>SIIT Office Material Inventory System</title>
  		<style>
			tx {
				color: white;
			}
		</style>
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
				<li><a href="index2.php">รายการคงคลังย่อย</a></li>
				<li><a href="search2.php">เบิกวัสดุ</a></li>

				<li><a class="active" href="show3.php">จ่ายของ</a></li>
				<li><a href="history2.php">ประวัติ</a></li>

				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a>ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['ubranch']; ?> </b></a></li>
			</ul>
		</div>
			<div id="div_main">
				<div id="div_content">

					<form action="check_search2.php" method="post" id="searchform" onsubmit="return checkempty(document.getElementById('search'))">
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
							<a href="show2.php" class="button1">ไปยังตะกร้า</a>&nbsp; &nbsp; &nbsp;
							<input type="submit" name="submit" class="button1" value="ค้นหา">
						</center>
					</form>

					<?php echo "<b>ผลการค้นหา</b>: ".$keyword."<br><br>";?>
					<table id="tb0">
						<table id="tb0">
							<tr>
								<th>ภาพ</th>
								<th>รหัส</th>
								<th>รายการ</th>
								<!--<th>วันที่นำเข้า</th>
								<th>ราคา</th> -->
								<th>คงเหลือ</th>
								<th>หน่วยนับ</th>
								<th>จ่าย</th>
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
								//$q="select * from $branch WHERE 1";
								$q="select *, SUM(QLeft) as sum_qty from $branch where QLeft > 0 group by Full_Name order by ID";
							}
							else{	//otherwise, search and list from most to least match strings
								//$q="select *, ($a) as total from $branch WHERE ($aa) ORDER BY total DESC"; //OR Date LIKE '%$keyword%'
								$q="select *, ($a) as total, SUM(QLeft) as sum_qty from $branch where ($aa) and QLeft > 0 group by Full_Name order by ID";
							}
							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$mysqli->error ;
							}
							while($row=$result->fetch_array()){ ?>
								<tr>
								<center>
									<form action="haha2.php" method="post">
										<td><img src="<?=$row['Pic'] ?>" height="100" width="100"></td>
										<td><?=$row['Code']?></td>
										<td><?=$row['Full_Name']?></td>
										<td><?=$row['sum_qty']?></td>
										<td><?=$row['Unit']?></td>
										<td>
											<input type="hidden" name="ID" value="<?php echo $row['ID'];?>">
											<input type="hidden" name="sumQty" value="<?php echo $row['sum_qty'];?>">
											<input type="text" name="txtQty" value="1" id="in1">
											<input type="submit" value="จ่าย">
										</td>
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
