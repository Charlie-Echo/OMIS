<?php
session_start();
require_once('connect.php');
$ID = $_GET["ID"];
$_SESSION["rejID"] = $ID;
$strSQL = "
UPDATE `detail` SET `status` = 'Rejected' WHERE `detail`.`Order_ID` = $ID";
$objQuery = mysqli_query($objCon,$strSQL);
if(!$objQuery)
{
  echo $objCon->error;
  exit();
}
mysqli_close($objCon);
header("Location: reject_h.php");
?>
