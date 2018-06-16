<?php
	session_start();
	require_once('connect.php');
	$appID = $_SESSION["appID"];
	$strSQL = "UPDATE `history` SET `status` = 'Approved' WHERE `ID` = $appID";
	$objQuery = mysqli_query($objCon,$strSQL);
	if(!$objQuery)
	{
	  echo $objCon->error;
	  exit();
	}
	mysqli_close($objCon);
	unset($_SESSION['appID']);
	unset($_SESSION['fromstock']);
	unset($_SESSION['tostock']);
	header("Location: index.php");
?>
