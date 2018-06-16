<?php
require_once('connect.php');
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==2){
	header("Location: index2.php");
}
ob_start();

  for($i=0;$i<=(int)$_SESSION["itemLine"];$i++)
  {
	  if($_SESSION["itemName"][$i] != "")
	  {
			$_SESSION["itemQty"][$i] = $_POST["quantity".$i];
			$_SESSION["itemPrice"][$i] = $_POST["price".$i];
	  }
  }
	header("Location: add_cart.php");
?>
