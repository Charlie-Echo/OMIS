<?php
session_start();
require_once('connect.php');
$rejID = $_SESSION["rejID"];
$strSQL = "
UPDATE `history` SET `status` = 'Rejected' WHERE `ID` = $rejID";
$objQuery = mysqli_query($objCon,$strSQL);
if(!$objQuery)
{
  echo $objCon->error;
  exit();
}
mysqli_close($objCon);
unset($_SESSION['rejID']);
header("Location: index.php");
?>
