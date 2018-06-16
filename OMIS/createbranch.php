<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$branch = $_SESSION['ubranch'];
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
					<li><a href="request.php">คำร้อง</a></li>
					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li style="float:right">
						<div class="dropdown">
							<a class="active" href="changepass.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a>
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
					<center><h3>สร้างหน่วยงานใหม่</h3></center>
					<form action="createbranchresult.php" method="post">
						<table id="tb1" align= "center">
							<br>
							<tr>
								<th><label>ชื่อย่อหน่วยงาน:</label></th>
								<th>
									<input type="text" name="newbranchname" placeholder="เป็นตัวพิมพ์เล็ก เช่น acc"><br><br>
									ถ้ามีทั้งรังสิตและบางกะดี ให้พิมพ์ rs_ หรือ bkd_ ตามด้วยชื่อย่อ
								</th>
							</tr>
							<tr>
								<th><label>ชื่อเต็มหน่วยงาน:</label></th>
								<th><input type="text" name="branchfname" placeholder="เช่น ฝ่ายรับเข้าศึกษาและประชาสัมพันธ์"></th>
							</tr>
							<tr>
								<th><label>วิทยาเขตของหน่วยงาน:</label></th>
								<th>
									<input type="radio" name="campus" value="rs_"> รังสิต
  								<input type="radio" name="campus" value="bkd_"> บางกะดี<br>
								</th>
							</tr>
							<tr>
								<th><label>รหัสหน่วยงาน:</label></th>
								<th><input type="text" name="branchcode" placeholder="เช่น 006"></th>
							</tr>
							<tr>
								<th><label>มีSupervisorหรือไม่?:</label></th>
									<th>
										<input type="radio" name="spv" value="yes"> มี
										<input type="radio" name="spv" value="-"> ไม่มี<br>
								</th>
							</tr>
							<tr>
								<th><label>Email ของ Supervisor :</label></th>
								<th><input type="text" name="spvemail" placeholder="ถ้าไม่มีSupervisor ไม่ต้องกรอกช่องนี้"></th>
							</tr>
						</table>
						<br>
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
