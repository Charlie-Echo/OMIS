<?php
require_once('connect.php');
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

				<li><a class="active" href="show3.php">จ่ายของ</a></li>
				<li><a href="selectyearhistory2.php">ประวัติ</a></li>

				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
				<li style="float:right"><a href="changepass2.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['ubranch']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<form action="check_search3.php" method="post" id="searchform" onsubmit="return checkempty(document.getElementById('search'))">
					<table id="tb1" align= "center">
					<col width="30%">
					<col width="70%">
					<tr>
						<th><label>ป้อนคำค้นหา:</label></th>
						<th><input type="text" name="keyword" autofocus></th>
					</tr>
					<!--<tr>
						<th><label>จาก(คลัง):</label></th>
						<th><input type="radio" id="loc1" name="stockloc" value="rs_stock"> รังสิต
  						<input type="radio" id="loc2" name="stockloc" value="bkd_stock"> บางกะดี<br>
					</tr>-->
					</table>
					<br>
					<center>
								<a href="show3.php" class="button1">ไปยังตะกร้า</a>&nbsp; &nbsp; &nbsp;
       					<input type="submit" name="submit" class="button1" value="ค้นหา">
       					<!-- <input type="button" onclick="redirect()" value="ค้นหาทั้งหมด" class="button1">&nbsp; &nbsp; &nbsp; -->
       					<!-- <input type="button" onclick="myFunction()" value="Reset form" class="button1"> -->
       				</center>
        		</form>

        <script>
			function myFunction() {
				document.getElementById("searchform").reset();
			}
			function redirect(){
				window.location = "check_search2all.php";
			}

			function checkempty(search){
				if(search != ""){
					return true;
				}
				else{
					alert("โปรดเลือกคลังเก็บวัสดุ!");
					return false;
				}
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
        </script>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
