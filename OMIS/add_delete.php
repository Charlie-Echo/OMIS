<?php
	require_once('connect.php');
	ob_start();
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}

	if(isset($_GET["Line"]))
	{
		$Line = $_GET["Line"];
		$_SESSION["itemName"][$Line] = "";
		$_SESSION["itemQty"][$Line] = "";
		$_SESSION["numLine"] = $_SESSION["numLine"] - 1;
		echo $_GET["Line"];
		echo $_SESSION['ugroup'];
	}
	header("Location: add_cart.php");
?>
