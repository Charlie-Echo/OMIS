<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$branch = $_SESSION['ubranch'];
	$ID = $_GET["ID"];
?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  	<title>SIIT Office Material Inventory System</title>
		<!--<script src="jquery-3.1.1.min"></script>-->
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
					<col width="25%">
					<col width="75%">
					<?php
						$searchitem = "SELECT * FROM item WHERE ID = '$ID';";
						$result=$objCon->query($searchitem);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						$pic = $row['Pic'];
						$code = $row['Code'];
						$fullname = $row['Full_Name'];
						$unit = $row['Unit'];
					?>
					<center><h3>แก้ไขรายการวัสดุ</h3></center>
					<form action="edititemresult.php" method="post" enctype="multipart/form-data">
						<table id="tb1" align= "center">
							<br>
							<tr>
								<th><label>รูปวัสดุ:</label></th>
								<th><input type="file" name="fileToUpload" id="fileToUpload"></th>
							</tr>
							<tr>
								<th><label>ลบรูปวัสดุ:</label></th>
								<th><input type="checkbox" name="del" value="del"> ลบ</th>
							</tr>
							<tr>
								<th><label>รหัสวัสดุ:</label></th>
								<th><input type="text" name="newcode" value="<?=$code?>"></th>
							</tr>
							<tr>
								<th><label>ชื่อวัสดุ:</label></th>
  							<th><input type="text" name="newname" value="<?=$fullname?>"></th>
							</tr>
							<tr>
								<th><label>หน่วยของวัสดุ:</label></th>
								<th><input type="text" name="newunit" value="<?=$unit?>"></th>
							</tr>
							<tr>
								<th><label>ลบรายการวัสดุนี้:</label></th>
								<th><input type="checkbox" name="delitem" value="delitem"> ลบรายการ</th>
							</tr>
						</table>
						<br>
						<input type="hidden" name ="id" value="<?=$ID?>">
						<center>
							<input type="submit" name="submit" class="button1" value="ดำเนินการ">
						</center>
					</form>
					<br>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
	</div>
	</body>
</html>
