<?php
	ob_start();
	session_start();

	if(isset($_GET["Line"]))
	{
		$Line = $_GET["Line"];
		$_SESSION["strProductID"][$Line] = "";
		$_SESSION["strQty"][$Line] = "";
		$_SESSION["numLine"] = $_SESSION["numLine"] - 1;;
	}
	if($_SESSION['ugroup']==1){
		header("Location: show.php");
	}
	elseif($_SESSION['ugroup']==2){
		header("Location: show2.php");
	}
	elseif($_SESSION['ugroup']==3){
		header("Location: show3.php");
	}
?>
