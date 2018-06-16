<?php
	ob_start();
	session_start();

	if(isset($_GET["Line"]))
	{
		$Line = $_GET["Line"];
		$_SESSION["strProductID1"][$Line] = "";
		$_SESSION["strQty1"][$Line] = "";
		$_SESSION["numLine1"] = $_SESSION["numLine1"] - 1;;
	}
	header("Location: show3.php");

?>
