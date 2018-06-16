<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	//$branch = $_SESSION['ubranch'];
	$userdata = $_POST['userdata'];

	$q="SELECT * FROM user WHERE user_ID = '$userdata'";
	$result=$objCon->query($q);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$row=$result->fetch_array();
	$fillmail = $row['email'];

	if($row['supervisor'] != '-' && $row['supervisor'] != 'none'){
		$fillspv = $row['supervisor'];

		$qq="SELECT email FROM user WHERE user_Name = '$fillspv'";
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}
		$row1=$result1->fetch_array();
		$fillmail = $row1['email'];
	}
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
					<center><h3>แก้ไขรายละเอียดผู้ใช้ของหน่วยงาน</h3></center>
					<form action="edituserresult.php" method="post">
						<table id="tb1" align= "center">
							<br>
							<tr>
								<th><label>ผู้ใช้งาน:</label></th>
								<th><?=$row['branch_name']?></th>
							</tr>
							<tr>
								<th><label>รหัสผ่านใหม่:</label></th>
								<th><input type="password" name="newpass"></th>
							</tr>
							<tr>
								<th><label>ยืนยันรหัสผ่านใหม่:</label></th>
								<th><input type="password" name="confirmpass"></th>
							</tr>
							<?php if($row['supervisor'] != 'none'){ ?>
								<tr>
									<th><label>ผู้ดูแล:</label></th>
									<th>
									  <input type="radio" onclick="document.getElementById('spvmail').disabled = true;"
										name="spv" value="0" <?php if($row['supervisor'] == '-'){ echo "checked";} ?>> ไม่มี
										<input type="radio" onclick="document.getElementById('spvmail').disabled = false;"
										name="spv" value="1" <?php if($row['supervisor'] != '-'){ echo "checked";} ?>> มี
									</th>
								</tr>
							<?php } ?>
							<tr>
								<th><label>อีเมลผู้ดูแลหน่วยงาน:</label></th>
								<th><input type="email" id='spvmail' name="email" value="<?=$fillmail?>" placeholder="ถ้าไม่มีอีเมลให้ใส่เครื่องหมายลบ (-)"></th>
							</tr>
							<tr>
								<th><label>รหัสผ่านของผู้ดูแล:</label></th>
								<th><input type="password" name="adminpass" placeholder="ป้อนรหัสของผู้ใช้งานที่กำลังใช้งานอยู่"></th>
							</tr>
							<input type="hidden" name="userid" value="<?=$userdata?>">
							<input type="hidden" name="branchname" value="<?=$row['branch_name']?>">
						</table>
						<br>
						<center>
							<a href="changepass.php" class="button1">ย้อนกลับ</a> |
							<input type="submit" name="submit" class="button1" value="ดำเนินการ">
						</center>
					</form>
					<br>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
	</div>
	</body>
</html>
