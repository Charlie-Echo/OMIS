<?php
$checkLim = intval($_POST["sumQty"]) - intval($_POST["txtQty"]);
echo "<br>";
if(intval($_POST["sumQty"]) == 0){
	echo "NOT FUKIN OKAY";
	header("location:check_search2.php");
}
if($checkLim >= 0){
	echo "OKAY";
}else{
	echo "NOT OKAY";
}
?>

<?php
ob_start();
session_start();

if(!isset($_SESSION["intLine"]))
{
	if(isset($_POST["ID"]))
	{
		$_SESSION["intLine"] = 0;
		$_SESSION["strProductID"][0] = $_POST["ID"];

		if($checkLim >= 0){
			$_SESSION["strQty"][0] = $_POST["txtQty"];
			$_SESSION["canGetMore"][0] = $checkLim;
		}else{
			$_SESSION["strQty"][0] = $_POST["sumQty"];
			$_SESSION["canGetMore"][0] = 0;
		}

		$_SESSION["numLine"] = 1;
		$_SESSION["MAX"][0] = $_POST["sumQty"];
		if($checkLim < 0){
			echo ('<script type="text/javascript">'); 
				echo ('alert("คุณเลือกมากเกินกว่าที่คลังมี! หยิบใส่ตะกร้าตามจำนวนที่มีในคลังใหญ่ตามสาขา");'); 
				echo ('window.location= "show2.php";');
			echo ('</script>');   
		}
		else{
			echo ('<script type="text/javascript">'); 
				echo ('window.location= "show2.php";');
			echo ('</script>');
		}
	}
}
else
{

	$key = array_search($_POST["ID"], $_SESSION["strProductID"]);
	if((string)$key != "")
	{
		$newQuantity = $_SESSION["strQty"][$key] + $_POST["txtQty"];
		if($newQuantity > intval($_POST["sumQty"])){
			$newQuantity = intval($_POST["sumQty"]);
		}
		 $_SESSION["strQty"][$key] = $newQuantity;
	}
	else
	{
		$_SESSION["intLine"] = $_SESSION["intLine"] + 1;
		$intNewLine = $_SESSION["intLine"];
		$_SESSION["strProductID"][$intNewLine] = $_POST["ID"];

		if($checkLim >= 0){
			$_SESSION["strQty"][$intNewLine] = $_POST["txtQty"];
			$_SESSION["canGetMore"][$intNewLine] = $checkLim;
		}else{
			$_SESSION["strQty"][$intNewLine] = $_POST["sumQty"];
			$_SESSION["canGetMore"][$intNewLine] = 0;
		}

		$_SESSION["numLine"] = $_SESSION["numLine"] + 1;;
		$_SESSION["MAX"][$intNewLine] = $_POST["sumQty"];
	}
	if($checkLim < 0){
		echo ('<script type="text/javascript">'); 
			echo ('alert("คุณเลือกมากเกินกว่าที่คลังมี! หยิบใส่ตะกร้าตามจำนวนที่มีในคลังใหญ่ตามสาขา");'); 
			echo ('window.location= "show2.php";');
		echo ('</script>');   
	}
	else{
		echo ('<script type="text/javascript">'); 
			echo ('window.location= "show2.php";');
		echo ('</script>');
	}
}
?>
