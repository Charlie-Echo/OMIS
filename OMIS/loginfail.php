<?php

	session_start();
	if(isset($_SESSION['uname']))
	{
		header("Location: index.php");
	}
	else{}
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
		<div id="div_main">
			<div id="div_content">
				<form action="check_login.php" method="post">
				 <center><h1 style="color:red">Username หรือ Password ไม่ถูกต้อง</h1></center>
				<table id="tb1" align= "center">
					<col width="30%">
					<col width="70%">
					<tr>
						<th><label>Enter Username:</label></th>
						<th><input autocomplete="off" type="text" name="username"></th>
					</tr>
					<tr>
						<th><label>Enter Password:</label></th>
						<th><input autocomplete="off" type="password" name="password"></th>
					</tr>
				</table>
				<br>
				<br>
				<center>
					<a href="manual.pdf" class="button1">คู่มือการใช้งาน</a> | 
					<input type="submit" name="submit" class="button1" value="LOGIN">
					<br>
					<br>
					<!-- <a href="index.php" class="button1">Forget Password</a> -->
				</center>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
