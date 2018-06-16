<?php
	session_start();
	$serverName = "localhost";
	$userName = "root";
	$userPassword = "ubuntu";
	$dbName = "OMIS";

	$objCon = mysqli_connect($serverName,$userName,$userPassword,$dbName);

	mysqli_set_charset($objCon, "utf8");
	//$url = $_SERVER['REQUEST_URI'];
	//echo($url);
	//if($url != '/SC/login.php' && $url != '/SC/loginfail.php' && $_SESSION['ugroup']==''){
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
?>
