<?php
require_once('connect.php');
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
				<li><a class="active "href="search.php">ค้นหา</a></li>
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
				<form action="check_search.php" method="post" id="searchform" onsubmit="return checkempty(document.getElementById('search'))">
					<table id="tb1" align= "center">
					<col width="30%">
					<col width="70%">
					<tr>
						<th><label>ป้อนคำค้นหา:</label></th>
						<th><input type="text" name="keyword" autofocus></th>
					</tr>
					</table>
					<br>
					<center>
						<input type="submit" name="submit" class="button1" value="ค้นหา">&nbsp; &nbsp;|&nbsp; &nbsp;
      					<a class="button1" href="check_search.php">ค้นหาทั้งหมด</a>
      					<!-- &nbsp; &nbsp;|&nbsp; &nbsp;
      					<input type="button" onclick="myFunction()" value="Reset form" class="button1"> -->
       				</center>
        		</form>
        <script>
			function myFunction() {
				document.getElementById("searchform").reset();
			}

			/*function checkempty(loc1, loc2){
				if(loc1.checked || loc2.checked){
					return true;
				}
				else{
					alert("โปรดเลือกคลังเก็บวัสดุ!");
					return false;
				}
			}*/
			/*function checkempty(search){
				if(search != ""){
					return true;
				}
				else{
					alert("โปรดเลือกคลังเก็บวัสดุ!");
					return false;
				}
			}*/

        </script>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
