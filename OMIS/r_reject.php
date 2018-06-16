<?php
require_once('connect.php');
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==2){
	header("Location: index2.php");
}
$hID = $_SESSION["hID"];

if($objCon->connect_errno)
{
  echo $objCon->connect_errno.": ".$objCon->connect_error;
}
$q="UPDATE detail SET status = 'Rejected' where Order_ID = '$hID'";
if(!$objCon->query($q))
{
  echo "UPDATE failed. Error: ".$objCon->error ;
}

if($objCon->connect_errno)
{
  echo $objCon->connect_errno.": ".$objCon->connect_error;
}
$q="UPDATE history SET status = 'Rejected' where ID = '$hID'";
if(!$objCon->query($q))
{
  echo "UPDATE failed. Error: ".$objCon->error ;
}

unset($_SESSION["detailID"]);
unset($_SESSION["newQty"]);
unset($_SESSION["stat"]);
unset($_SESSION["hID"]);
unset($_SESSION["reqItem"]);
unset($_SESSION["Full_Name"]);
header("Location:request.php");
?>
