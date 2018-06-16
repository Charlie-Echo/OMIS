<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
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
		<div id="div_header">
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
					<a href="add.php" class="active">นำเข้า</a>
					  <div class="dropdown-content">
					    <a href="#">เพิ่มวัสดุใหม่</a>
					  </div>
					</div>
				</li>
				<li><a href="history.php">ประวัติ</a></li>
				<li><a href="request.php">คำร้อง</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepass.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
          <form action="add_item.php" method="post" enctype="multipart/form-data">
				<table id="tb1" align= "center">
					  <col width="35%">
					  <col width="65%">
					  <tr>
							 <th><label>รายการสั่งซื้อเลขที่:</label></th>
							 <th><input type="text" name="code"></th>
					  </tr>
						<tr>
							 <th><label>วันที่:</label></th>
							 <th><input type="date" name="date"></th>
					  </tr>
					  <tr>
							 <th><label>จากบริษัท:</label></th>
							 <th><input type="text" name="sup"></th>
					  </tr>
				</table>
				<br>
				<center><input type="submit" name="submit" class="button1" value="ยืนยัน"></center>
          </form>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
