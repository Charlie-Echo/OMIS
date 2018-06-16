<?php
	require_once('connect.php');
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
	}
	if($_SESSION['supervisor']!='none'){
		header("Location: index2.php");
	}
	$branch = $_SESSION['ubranch'];
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
					<li><a href="supervisor_check.php">ยืนยันการเบิก</a></li>
					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li class="active" style="float:right"><a href="changepassS.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">
					<col width="25%">
					<col width="75%">
					<center><h3>เปลี่ยนรหัสผ่าน</h3></center>
					<form action="changepassSresult.php" method="post">
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
						</center>
					</form>
					<br>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</div>
	</body>
</html>
