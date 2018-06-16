<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$userid = $_SESSION['uid'];	//ID admin

	$ID = $_POST['userid'];	//รหัสของผู้ใช้ที่จะแก้ไข
	$branchname = $_POST['branchname'];
	$newpass = $_POST['newpass'];
	$confnewpass = $_POST['confirmpass'];

	if(!isset($_POST['spv'])){
		$spv = 'nope';
		//echo "kuy1";
	}
	else {
		$spv = $_POST['spv'];
		//echo "kuy2";
	}
	//echo $spv;

	if($spv == '0'){
		$email = 'nope';
		//echo "kuy1";
	}
	elseif ($spv == '1' || $spv == 'nope') {
		$email = $_POST['email'];
		//echo "kuy2";
	}
	//echo $email;
	$adminpass = $_POST['adminpass'];
	//echo $ID;
	if(!isset($ID) || !isset($newpass) || !isset($confnewpass) || !isset($email) || !isset($adminpass)){
		header("Location: changepass.php");		//เข้าหน้านี้โดยพลการ
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
							$q="SELECT user_Password FROM user WHERE user_ID = '$userid'";	//หารหัสแอดมิน
							$result=$objCon->query($q);
							if(!$result){
								echo "Select failed. Error: ".$objCon->error ;
							}
							$row=$result->fetch_array();
							$oripass = $row['user_Password'];

							if($adminpass != $oripass){			//กรอกรหัสadminไม่ถูก
								echo "<h3><font color='red'>รหัสผ่านผู้ดูแลไม่ถูกต้อง!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
							}
							elseif (strlen($newpass) < 6) {			//รหัสสั้นกว่า6ตัว
								echo "<h3><font color='red'>รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย6ตัว!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
							}
							elseif ($newpass != $confnewpass) {			//รหัสใหม่กับส่วนยืนยันไม่เหมือนกัน
								echo "<h3><font color='red'>รหัสผ่านใหม่ไม่เหมือนกับส่วนยืนยันรหัสผ่านใหม่!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
							}
							/*elseif (strpos($email, '@') == FALSE && $email != 'nope') {			//เมลไม่มี@ หรือเมลปัญญาอ่อน
								echo "<h3><font color='red'>กรุณากรอกอีเมลให้ถูกรูปแบบ!</font><h3> <br> <a href='changepass.php' class='button1'>ย้อนกลับ</a>";
							}*/
							else{			//เปลี่ยนรหัสได้สำเร็จ
								$changepass = "UPDATE user SET user_Password = '$newpass' WHERE user_ID = '$ID'";		//อัพเดตรหัส+อีเมลของuser
								$objQuery = mysqli_query($objCon, $changepass);
								if(!$objQuery){
									echo $objCon->error;
									exit();
								}

								$q="SELECT supervisor, user_Name, branch_name, branch FROM user WHERE user_ID = '$ID'";	//หาผู้ดูแลของuserคนนี้
								$result=$objCon->query($q);
								if(!$result){
									echo "Select failed. Error: ".$objCon->error ;
								}
								$row=$result->fetch_array();
								$spvname = $row['supervisor'];		//สร้างตัวแปรสำหรับหาผู้ดูแล	=>accs
								$searchname = $row['user_Name'];		//สร้างตัวแปรสำหรับหาผู้ดูแล	=>acc
								$branch = $row['branch'];		//สร้างตัวแปรสำหรับหาผู้ดูแล	=>rs_acc
								$searchfname = $row['branch_name'];		//สร้างตัวแปรสำหรับหาผู้ดูแล	=>ฝ่ายบัญชี
								if(strpos($searchname, '_')==TRUE){		//ถ้ามีrs_/bkd_นำหน้าชื่อย่อหน่วยงาน
									$hasearchname = explode("_",$searchname);
									$searchname = $hasearchname[1];
								}
								//echo $searchname;
								//echo "<br>";
								//echo $searchfname;
								//echo "<br>";
//-----------------------------------------------------------------------------------------------------------------------------
								if($spv == '1'){	//ถ้าเลือกให้มีผู้ดูแล
									if($spvname != '-'){ /*echo "kuy1";*/}		//เคสที่1: ถ้ามีอยู่แล้ว = อัพเดตเมลอย่างเดียว
									elseif ($spvname == '-') {		//เคสที่2: ถ้าไม่มีมาก่อน = หาผู้ดูแลในDBว่ามีไหม
										$spvuname = $searchname."s";
										$spvfname = "ผู้ดูแล".$searchfname;
										//echo $spvuname;
										//echo "<br>";
										//echo $spvfname;

										$qq="SELECT user_ID FROM user WHERE user_Name = '$spvuname'";	//หาชื่อผู้ดูแลในdb
										$result1=$objCon->query($qq);
										if(!$result1){
											echo "Select failed. Error: ".$objCon->error ;
										}
										$row1=$result1->fetch_array();
										if($row1['user_ID']==TRUE){		//เคส2.1: มีผู้ดูแลอยู่ก่อนแล้ว ให้เชื่อมกัน
											//echo "kuy11";
											$changepass = "UPDATE user SET supervisor = '$spvuname' WHERE user_ID = '$ID'";		//อัพเดตให้ลิงค์กับsupervisorที่พึ่งสร้าง
											$objQuery = mysqli_query($objCon, $changepass);
											if(!$objQuery){
												echo $objCon->error;
												exit();
											}
											$changepass = "UPDATE user SET email = '$email' WHERE user_Name = '$spvuname'";		//อัพเดตอีเมลให้ตรงกับที่พึ่งใส่
											$objQuery = mysqli_query($objCon, $changepass);
											if(!$objQuery){
												echo $objCon->error;
												exit();
											}
										}
										elseif($row1['user_ID']==FALSE){		//เคส2.2: ไม่มีผู้ดูแลก่อนหน้า(หาไม่เจอ) ให้สร้างใหม่
											//echo "kuy12";
											$addspv = "INSERT INTO user (user_Name, user_Password, user_Group, branch, branch_name, branch_code, supervisor, email)
											VALUES ('$spvuname', '123', '2', '$branch', '$spvfname', '-', 'none', '$email');";	//สร้างผู้ดูแลคนใหม่
											$objQuery = mysqli_query($objCon, $addspv);
											if(!$objQuery){
												echo $objCon->error;
												exit();
											}
											$changepass = "UPDATE user SET supervisor = '$spvuname' WHERE user_ID = '$ID'";		//อัพเดตให้ลิงค์กับsupervisorที่พึ่งสร้าง
											$objQuery = mysqli_query($objCon, $changepass);
											if(!$objQuery){
												echo $objCon->error;
												exit();
											}
											//echo "kuy2";
										}
									}
								}
//-----------------------------------------------------------------------------------------------------------------------------
								elseif ($spv == '0') {	//ถ้าเลือกให้ไม่มีผู้ดูแล
									if($spvname != '-'){		//เคส3: ถ้ามีผู้ดูแลอยู่แล้ว	= แก้ให้ไม่มีsupervisor
										//echo "kuy3";
										$changepass = "UPDATE user SET supervisor = '-' WHERE user_ID = '$ID'";		//อัพเดตรหัส+อีเมล
										$objQuery = mysqli_query($objCon, $changepass);
										if(!$objQuery){
											echo $objCon->error;
											exit();
										}
									}
									elseif ($spvname == '-') {/*echo "kuy4";*/}		//เคส4: ถ้าไม่มีมาก่อน = ไม่ต้องทำอะไร
								}
//-----------------------------------------------------------------------------------------------------------------------------
								elseif ($spv == 'nope') {
									//echo "kuy5";
									$changepass = "UPDATE user SET email = '$email' WHERE user_ID = '$ID'";		//อัพเดตอีเมลให้ตรงกับที่พึ่งใส่
									$objQuery = mysqli_query($objCon, $changepass);
									if(!$objQuery){
										echo $objCon->error;
										exit();
									}
								}
//-----------------------------------------------------------------------------------------------------------------------------
								echo "<h3>เปลี่ยนรหัสผ่านของผู้ใช้ $branchname สำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
							}
						?>
					</center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</div>
	</body>
	</html>
