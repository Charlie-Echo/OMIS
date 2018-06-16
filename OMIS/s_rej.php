<?php
require_once('connect.php');
//session_start();
if(!isset($_SESSION['ugroup'])){
  header("Location: login.php");
}
if($_SESSION['ugroup']==1){
  header("Location: index.php");
}
if($_SESSION['supervisor']!='none'){
  header("Location: index2.php");
}
$ID = $_GET["ID"];
$branch = $_SESSION['ubranch'];

  if($objCon->connect_errno)
  {
    echo $objCon->connect_errno.": ".$objCon->connect_error;
  }
  $q="DELETE FROM history WHERE ID = '$ID';";
  if(!$objCon->query($q))
  {
    echo "UPDATE failed. Error: ".$objCon->error ;
  }

  if($objCon->connect_errno)
  {
    echo $objCon->connect_errno.": ".$objCon->connect_error;
  }
  $q="DELETE FROM detail WHERE Order_ID = '$ID';";
  if(!$objCon->query($q))
  {
    echo "UPDATE failed. Error: ".$objCon->error ;
  }

  header("Location: supervisor_check.php");
?>
