<?php
$checkLim = intval($_POST["sumQty"]) - intval($_POST["txtQty"]);
// echo $checkLim;
// echo "<br>";
// if(intval($_POST["sumQty"])){
// 	echo "NOT OKAY";
// 	echo "<br>";
// }
// if($checkLim >= 0){
// 	echo "OKAY";
// 	echo "<br>";
// }
// else{
// 	echo "NOT OKAY";
// 	echo "<br>";
// }
?>

<?php
ob_start();
session_start();

if(!isset($_SESSION["intLine1"]))
{
	if(isset($_POST["ID"]))
	{
		$_SESSION["intLine1"] = 0;
		$_SESSION["strProductID1"][0] = $_POST["ID"];

		if($checkLim >= 0){
			$_SESSION["strQty1"][0] = $_POST["txtQty"];
			$_SESSION["canGetMore1"][0] = $checkLim;
		}else{
			$_SESSION["strQty1"][0] = $_POST["sumQty"];
			$_SESSION["canGetMore1"][0] = 0;
		}

		$_SESSION["numLine1"] = 1;
		$_SESSION["MAX1"][0] = $_POST["sumQty"];
		//header("location:show3.php");
		if($checkLim < 0){
			echo ('<script type="text/javascript">');
				echo ('alert("คุณเลือกมากเกินกว่าที่คลังมี! หยิบใส่ตะกร้าตามจำนวนที่มีในคลัง");');
				echo ('window.location= "show3.php";');
			echo ('</script>');
		}
		else{
			echo ('<script type="text/javascript">');
				echo ('window.location= "show3.php";');
			echo ('</script>');
		}
	}
}
else
{

	$key = array_search($_POST["ID"], $_SESSION["strProductID1"]);
	if((string)$key != "")
	{
		$newQuantity = $_SESSION["strQty1"][$key] + $_POST["txtQty"];
		if($newQuantity > intval($_POST["sumQty"])){
			$newQuantity = intval($_POST["sumQty"]);
		}
		 $_SESSION["strQty1"][$key] = $newQuantity;
	}
	else
	{
		$_SESSION["intLine1"] = $_SESSION["intLine1"] + 1;
		$intNewLine = $_SESSION["intLine1"];
		$_SESSION["strProductID1"][$intNewLine] = $_POST["ID"];

		if($checkLim >= 0){
			$_SESSION["strQty1"][$intNewLine] = $_POST["txtQty"];
			$_SESSION["canGetMore1"][$intNewLine] = $checkLim;
		}else{
			$_SESSION["strQty1"][$intNewLine] = $_POST["sumQty"];
			$_SESSION["canGetMore1"][$intNewLine] = 0;
			$message = "คุณเลือกมากเกินกว่าที่คลังมี!";
		}

		$_SESSION["numLine1"] = $_SESSION["numLine1"] + 1;;
		$_SESSION["MAX1"][$intNewLine] = $_POST["sumQty"];
	}
	//header("location:show3.php");
	if($checkLim < 0){
		echo ('<script type="text/javascript">');
			echo ('alert("คุณเลือกมากเกินกว่าที่คลังมี! หยิบใส่ตะกร้าตามจำนวนที่มีในคลัง");');
			echo ('window.location= "show3.php";');
		echo ('</script>');
	}
	else{
		echo ('<script type="text/javascript">');
			echo ('window.location= "show3.php";');
		echo ('</script>');
	}
}
?>
