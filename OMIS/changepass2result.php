<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
	}

	$branch = $_SESSION['ubranch'];
	$oldpass = $_POST['oldpass'];
	$newpass = $_POST['newpass'];
	$connewpass = $_POST['connewpass'];
	if($oldpass == '' || $newpass == '' || $connewpass == ''){
		header("Location: changepass2.php");
	}
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

					<li><a href="show3.php">จ่ายของ</a></li>
					<li><a href="selectyearhistory2.php">ประวัติ</a></li>

					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li style="float:right"><a href="changepass2.php" class="active">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">
					<center>
					<?php
						$q="select user_ID, user_Password from user where branch = '$branch'";
						$result=$objCon->query($q);
						if(!$result){
	  					echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						$oripass = $row['user_Password'];
						$id = $row['user_ID'];
						$uname = 	$_SESSION['uname'];

						if($oldpass != $oripass){			//กรอกรหัสเก่าไม่ถูก
							echo "<h3><font color='red'>รหัสผ่านเดิมไม่ถูกต้อง!</font><h3> <br> <a href='changepass2.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif (strlen($newpass) < 6) {			//รหัสสั้นกว่า6ตัว
							echo "<h3><font color='red'>รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย6ตัว!</font><h3> <br> <a href='changepass2.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif ($newpass != $connewpass) {			//รหัสใหม่กับส่วนยืนยันไม่เหมือนกัน
							echo "<h3><font color='red'>รหัสผ่านใหม่ไม่เหมือนกับส่วนยืนยันรหัสผ่านใหม่!</font><h3> <br> <a href='changepass2.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif ($newpass == $oripass) {			//เปลี่ยนรหัสเป็นของเดิม
							echo "<h3><font color='red'>รหัสผ่านใหม่เหมือนกับรหัสผ่านเดิม!</font><h3> <br> <a href='changepass2.php' class='button1'>ย้อนกลับ</a>";
						}
						else{			//เปลี่ยนรหัสได้สำเร็จ
							$changepass = "UPDATE user SET user_Password = '$newpass' WHERE branch = '$branch' AND user_ID = '$id'";
							$objQuery = mysqli_query($objCon, $changepass);
							if(!$objQuery){
								echo $objCon->error;
								exit();
							}
							echo "<h3>เปลี่ยนรหัสผ่านของผู้ใช้ $uname สำเร็จ!<h3> <br> <a href='index2.php' class='button1'>กลับไปหน้าแรก</a>";
						}
					?>
					</center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</body>
	</div>
</html>
