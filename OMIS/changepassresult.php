<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$branch = $_SESSION['ubranch'];
	$oldpass = $_POST['oldpass'];
	$newpass = $_POST['newpass'];
	$connewpass = $_POST['connewpass'];
	if($oldpass == '' || $newpass == '' || $connewpass == ''){
		header("Location: changepass.php");
	}
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
					<center>
					<?php
						$uname = $_SESSION['uname'];
						$q="select user_ID, user_Password from user where branch = '$branch' AND user_Name = '$uname'";
						$result=$objCon->query($q);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						$oripass = $row['user_Password'];
						$id = $row['user_ID'];

						if($oldpass != $oripass){			//กรอกรหัสเก่าไม่ถูก
							echo "<h3><font color='red'>รหัสผ่านเดิมไม่ถูกต้อง!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif (strlen($newpass) < 6) {			//รหัสสั้นกว่า6ตัว
							echo "<h3><font color='red'>รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย6ตัว!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif ($newpass != $connewpass) {			//รหัสใหม่กับส่วนยืนยันไม่เหมือนกัน
							echo "<h3><font color='red'>รหัสผ่านใหม่ไม่เหมือนกับส่วนยืนยันรหัสผ่านใหม่!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif ($newpass == $oripass) {			//เปลี่ยนรหัสเป็นของเดิม
							echo "<h3><font color='red'>รหัสผ่านใหม่เหมือนกับรหัสผ่านเดิม!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
						}
						else{			//เปลี่ยนรหัสได้สำเร็จ
							$changepass = "UPDATE user SET user_Password = '$newpass' WHERE branch = '$branch' AND user_ID = '$id'";
							$objQuery = mysqli_query($objCon, $changepass);
							if(!$objQuery){
								echo $objCon->error;
								exit();
							}
							echo "<h3>เปลี่ยนรหัสผ่านของผู้ใช้ $uname สำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
							echo $id;
							echo $uname;
						}
					?>
					</center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
	</div>
	</body>
</html>
