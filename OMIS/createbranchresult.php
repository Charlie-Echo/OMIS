<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}

	$nbn = $_POST['newbranchname'];
	$bfn = $_POST['branchfname'];
	$campus = $_POST['campus'];
	if (strpos($nbn, '_') !== false) {	//ถ้ามี _ อยู่แล้ว
    $branch = $nbn;
	}
	else{			//ถ้าไม่มี _ มาก่อน
		$branch = $campus.$nbn;
	}
	$spv = $_POST['spv'];
	$bc = $_POST['branchcode'];
	if($spv == 'yes'){
		$spvemail = $_POST['spvemail'];
		$spvname = $nbn."s";
	}
	else {
		$spvemail = '-';
		$spvname = '-';
	}
	//echo $branch;
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
						$searchuser = "SELECT user_Name FROM user WHERE user_Name = '$nbn';";
						$result=$objCon->query($searchuser);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						$seusern = $row['user_Name'];
//-------------------------------------------------------------------------------------------------------------------------------------
						$searchuser = "SELECT branch FROM user WHERE branch = '$branch';";
						$result=$objCon->query($searchuser);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						$seuserb = $row['branch'];
//-------------------------------------------------------------------------------------------------------------------------------------
						$searchuser = "SELECT branch_name FROM user WHERE branch_name = '$bfn';";
						$result=$objCon->query($searchuser);
						if(!$result){
							echo "Select failed. Error: ".$objCon->error ;
						}
						$row=$result->fetch_array();
						$seuserf = $row['branch_name'];
//-------------------------------------------------------------------------------------------------------------------------------------
						if($nbn == '' || $bfn == '' || $campus == '' || $bc == '' || $spv == ''){			//กรอกไม่ครบ
							echo "<h3><font color='red'>กรุนากรอกข้อมูลให้ครบ ยกเว้นช่องสุดท้าย!</font><h3> <br> <a href='createbranch.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif(isset($seusern)){	//ชื่อย่อมีคนใช้แล้ว
							echo "<h3><font color='red'>ชื่อหน่วยงานนี้มีคนใช้แล้ว! กรุณาลองเพิ่ม rs_ หรือ bkd_ ข้างหน้า</font><h3> <br> <a href='createbranch.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif(isset($seuserb)){	//หน่วยงานนี้มีคนใช้แล้ว
							echo "<h3><font color='red'>หน่วยงานนี้มีบัญชีในศูนย์รังสิตหรือบางกะดีแล้ว!</font><h3> <br> <a href='createbranch.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif(isset($seuserf)){	//ชื่อเต็มซ้ำ
							echo "<h3><font color='red'>ชื่อเต็มหน่วยงานมีคนใช้แล้ว กรุณาเพิ่มคำว่ารังสิตหรือบางกะดีต่อท้าย!</font><h3> <br> <a href='createbranch.php' class='button1'>ย้อนกลับ</a>";
						}
						else{			//สร้างหน่วยงานได้สำเร็จ
							$adduser = "INSERT INTO user (user_Name, user_Password, user_Group, branch, branch_name, branch_code, supervisor, email)
							VALUES ('$nbn', '123', '2', '$branch', '$bfn', '$bc', '$spvname', '-');";	//สร้างผู้ใช้
							$objQuery = mysqli_query($objCon, $adduser);
							if(!$objQuery){
								echo $objCon->error;
								exit();
							}

							$createtable = "CREATE TABLE $branch (
								ID int(11) PRIMARY KEY,
								Pic varchar(255) NOT NULL COLLATE utf8_general_ci,
								Code varchar(255) NOT NULL COLLATE utf8_general_ci,
								Full_Name varchar(255) NOT NULL COLLATE utf8_general_ci,
								QLeft int(255),
								Unit varchar(255) NOT NULL COLLATE utf8_general_ci,
								ReceiptNo varchar(255) NOT NULL COLLATE utf8_general_ci
							)";
							$objQuery = mysqli_query($objCon, $createtable);
							if(!$objQuery){
								echo $objCon->error;
								exit();
							}

							if($spv == 'yes'){	//สร้างsupervisor ถ้าเซ็ตว่ามี
								$spvfname = "ผู้ดูแล".$bfn;
								$addspv = "INSERT INTO user (user_Name, user_Password, user_Group, branch, branch_name, branch_code, supervisor, email)
								VALUES ('$spvname', '123', '2', '$branch', '$spvfname', '-', 'none', '$spvemail');";
								$objQuery = mysqli_query($objCon, $addspv);
								if(!$objQuery){
									echo $objCon->error;
									exit();
								}
							}
							echo "<h3>เพิ่มหน่วยงาน $bfn สำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
						}
					?>
					</center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
	</div>
	</body>
</html>
