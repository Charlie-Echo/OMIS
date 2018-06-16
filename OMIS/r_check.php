<?php
require_once('connect.php');
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==2){
	header("Location: index2.php");
}

$NO = $_GET["NO"];

$branch = $_SESSION['ubranch'];
$strSQL = "SELECT * FROM $branch WHERE Full_Name = '".$_POST["Full_Name"]."' ";
$objQuery = mysqli_query($objCon,$strSQL);
$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
echo "Branch is: ".$branch;
echo "<br>";
echo "Full name is: ".$_POST["Full_Name"];
echo "<br>";
echo "Qty in stock is: ".$objResult["QLeft"];
echo "<br>";
echo "Posted Qty is: ".$_POST["txtQty".$NO];
echo "<br>";
$_SESSION["detailID"][$NO] = $_GET["ID"];
if(intval($_POST["txtQty".$NO])>intval($objResult["QLeft"])){
	$_SESSION["newQty"][$NO] = intval($objResult["QLeft"]);
	echo "New Qty is more than Qty in the stock, set New Qty = Qty left in the stock: ".$_SESSION["newQty"][$NO];
	echo "<br>";
}
else{
	$_SESSION["newQty"][$NO] = $_POST["txtQty".$NO];
	echo "New Qty OKAY: ".$_SESSION["newQty"][$NO];
	echo "<br>";
}
//$_SESSION["newQty"][$NO] = $_POST["txtQty".$NO];
$_SESSION["stat"][$NO] = "Approved";
$_SESSION["Full_Name"][$NO] = $_POST["Full_Name"];
$fName = $_SESSION["Full_Name"][$NO];
//echo $_SESSION["newQty"][$NO];


// mysqli_set_charset($objCon, "utf8");
// $strSQL = "SELECT SUM(QLeft) as total FROM rs_stock where Full_Name = '$fName'";
// $objQuery = mysqli_query($objCon,$strSQL);
// $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
// echo $objResult["total"];
header("Location:r_detail.php?ID=".$_GET["OrderID"]);
?>
