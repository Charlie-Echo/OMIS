<?php
	require_once('connect.php');
	$note = $_SESSION["note"];
	$_SESSION["fromstock"] = $_SESSION["ubranch"];
	//$_SESSION["tostock"] = $_SESSION["ubranch"];
	$branch = $_SESSION["ubranch"];
	$strSQL = "SELECT ID FROM History WHERE From_stock = '$branch' AND From_stock = To_stock AND status='Waiting' AND Note = '$note'";
	$objQuery = mysqli_query($objCon,$strSQL);
	if(!$objQuery)
	{
	  echo $objCon->error;
	  exit();
	}
	while($row=$objQuery->fetch_array()){
		$ID = $row['ID'];
	}
	mysqli_close($objCon);
	header("Location: approve.php?ID=$ID");
	unset($_SESSION["note"]);
?>