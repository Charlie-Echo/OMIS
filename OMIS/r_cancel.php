<?php
require_once('connect.php');
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==2){
	header("Location: index2.php");
}
unset($NO);
unset($_SESSION["detailID"]);
unset($_SESSION["newQty"]);
unset($_SESSION["stat"]);
header("Location:request.php");
?>
