<?php
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==2){
	header("Location: index2.php");
}

ob_start();
session_start();

if(!isset($_SESSION["itemLine"]))
{
	if(isset($_POST["name"]))
	{
		$_SESSION["itemLine"] = 0;
		$_SESSION["itemName"][0] = $_POST["name"];
		$_SESSION["itemQty"][0] = $_POST["quantity"];
		$_SESSION["itemPrice"][0] = $_POST["price"];
		$_SESSION["numLine"] = 1;
		header("location:add_cart.php");
	}
}
else
{

	$alr = array_search($_POST["name"], $_SESSION["itemName"]);
	if((string)$alr != "")
	{
		 $_SESSION["itemQty"][$alr] = $_SESSION["itemQty"][$alr] + $_POST["quantity"];
	}
	else
	{

		 $_SESSION["itemLine"] = $_SESSION["itemLine"] + 1;
		 $newItemLine = $_SESSION["itemLine"];
		 $_SESSION["itemName"][$newItemLine] = $_POST["name"];
		 $_SESSION["itemQty"][$newItemLine] = $_POST["quantity"];
		 $_SESSION["itemPrice"][$newItemLine] = $_POST["price"];
		 $_SESSION["numLine"] = $_SESSION["numLine"] + 1;
	}
	header("location:add_cart.php");
	/*elseif($_SESSION['ugroup']==3){
		header("location:show3.php");
	}*/
}
?>
