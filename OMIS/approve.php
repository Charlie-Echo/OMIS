<?php
	require_once('connect.php');
	$ID = $_GET["ID"];
	$_SESSION["appID"] = $ID;
	$strSQL = "UPDATE `detail` SET `status` = 'Approved' WHERE `detail`.`Order_ID` = $ID";
	$objQuery = mysqli_query($objCon,$strSQL);
	if(!$objQuery)
	{
	  echo $objCon->error;
	  exit();
	}
	mysqli_close($objCon);
	header("Location: approve_i.php");
?>
