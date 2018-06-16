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
					<center><h3>เปลี่ยนรหัสผ่าน</h3></center>
					<form action="changepassresult.php" method="post">
						<table id="tb1" align= "center">
							<br>
							<tr>
								<th><label>รหัสผ่านเดิม:</label></th>
								<th><input type="password" name="oldpass"></th>
							</tr>
							<tr>
								<th><label>รหัสผ่านใหม่:</label></th>
								<th><input type="password" name="newpass"></th>
							</tr>
							<tr>
								<th><label>ยืนยันรหัสผ่านใหม่:</label></th>
								<th><input type="password" name="connewpass"></th>
							</tr>
						</table>
						<br>
						<center>
							<input type="submit" name="submit" class="button1" value="ดำเนินการ">
							<br><br>
							</form>
							<hr><br>
							<h3>เปลี่ยนข้อมูลผู้ใช้ของหน่วยงาน</h3><br>
						</center>
						<form action="edituser.php" method="post">
							<table id="tb1" align= "center">
								<tr>
									<th><label>ผู้ใช้งาน:</label></th>
									<th><select name="userdata">
										<?php
											$q="SELECT user_ID, branch_name FROM user WHERE user_Group = '2'";
											$result=$objCon->query($q);
											if(!$result){
												echo "Select failed. Error: ".$objCon->error ;
											}
											while($row=$result->fetch_array()){
												echo "<option value='".$row['user_ID']."'>".$row['branch_name']."</option>";
											}
										?>
									</select></th>
								</tr>
							</table>
						<br>
						<center>
							<input type="submit" name="submit" class="button1" value="แก้ไขผู้ใช้หน่วยงาน">
						</center>
					</form>
					<center>
						<br><hr><br>
						<h3>Reset ฐานข้อมูล</h3><br>
						<a onclick="delpage()" class="button1">Reset</a>
					</center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
	</div>
	<script>
		function delpage() {
				var r = confirm("คุณต้องการResetฐานข้อมูลกลับไปเป็นของกุมภาพันธ์นี้หรือไม่? คุณไม่อาจย้อนกลับไปได้");
				if (r == true) {
						window.location = "emergency.php";
				}
				else {
				}
		}
	</script>
	</body>
</html>
