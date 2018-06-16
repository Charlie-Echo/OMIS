<?php
	require_once('connect.php');
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
	}
	/*session_start();
	if($_SESSION['ugroup']==''){
		header("Location: login.php");
	}*/
	$branch = $_SESSION['ubranch'];
	$findbranch = explode("_", $branch);
	if($findbranch[0] == "rs"){
		$_SESSION["Fromloc"] = "rs_stock";
	}
	elseif($findbranch[0] == "bkd"){
		$_SESSION["Fromloc"] = "bkd_stock";
	}
	/*echo($branch."<br>");
	echo($findbranch[0]."<br>");
	echo($_SESSION["Fromloc"]);*/
	if($_SESSION["supervisor"] == "none"){
		header("Location: supervisor_check.php");
	}
	$sup = $_SESSION["supervisor"];
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
					<li><a class="active" href="index2.php">รายการคงคลังย่อย</a></li>
					<li><a href="search2.php">เบิกวัสดุ</a></li>
					<li><a href="show3.php">จ่ายของ</a></li>
					<li><a href="selectyearhistory2.php">ประวัติ</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<table id="tb0">
					<tr>
						<th><center>ภาพ</center></th>
						<th><center>รายการ</center></th>
						<th><center>คงเหลือ</center></th>
					</tr>
					<center><h1>รายการวัสสดุคงคลังย่อย</h1></center>
					<?php
						$q="select Pic, Full_Name, QLeft, Unit from $branch where QLeft > 0 order by ID";
						$result=$objCon->query($q);
						if(!$result){
						echo "Select failed. Error: ".$objCon->error ;
						}
						$count = 0;
						while($row=$result->fetch_array()){?>
						<tr>
							<center>
								<form action="haha2.php" method="post">
									<td><center><img <?php if($row['Pic'] != 'Pic/noimage.jpg') { echo "class='rotate'"; } ?> src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
									<td><center><?=$row['Full_Name']?></center></td>
									<td><center><?=$row['QLeft']." ".$row['Unit']?></center></td>
								</form>
							</center>
						</tr>
					<?php } ?>
				</table>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
