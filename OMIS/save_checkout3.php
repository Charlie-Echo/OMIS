<?php
	//session_start();
	require_once('connect.php');
	$uname = $_SESSION['uname'];
	$ubranch = $_SESSION['ubranch'];
	$note = $_POST["note"];
	$year = (date("Y")+543-1);
	$numcount = 0;

	$qty = "SELECT branch_code from user WHERE branch = '$ubranch'";	//generate TRcode
	$result=$objCon->query($qty);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$row=$result->fetch_array();
	$gencode = "DS".$row['branch_code'];

	$count = "SELECT Year, NumCount FROM history WHERE From_stock = '$ubranch' AND To_stock = '$ubranch' AND TRcode = '$gencode' AND Year = '$year' AND Type = 2 ORDER BY Year DESC, NumCount DESC LIMIT 1";	//generate NumCount
	$result1 = $objCon->query($count);
	/*if(!$result1){
		echo "Select failed. Error: ".$objCon->error ;
	}*/
	$row=$result1->fetch_array();

	$numcount = ($row['NumCount']+1);

	if ( date('m') > 8 ) {
		$year = date('Y') + 543;
	}
	else {
		$year = date('Y') + 543 - 1;
	}

	/*echo($numcount);
	echo("<br>");
	echo($ubranch);
	echo("<br>");
	echo($gencode);
	echo("<br>");
	echo($year);*/


	 $strSQL = "
	 INSERT INTO history (Type,User,From_stock,To_stock,TRcode,Year,NumCount,Note,status) VALUES ('2','$uname','$ubranch','$ubranch','$gencode','$year','$numcount','$note','Approved')";
	 $objQuery = mysqli_query($objCon,$strSQL);
	 if(!$objQuery)
	 {
		echo $objCon->error;
		exit();
	 }

	 $strOrderID = mysqli_insert_id($objCon);

	 for($i=0;$i<=(int)$_SESSION["intLine1"];$i++)
	 {
		if($_SESSION["strProductID1"][$i] != "")
		{
			$strSQL = "
			INSERT INTO detail (Order_ID,Type,Item_ID,Quantity,status)
			VALUES
			('".$strOrderID."','2','".$_SESSION["strProductID1"][$i]."','".$_SESSION["strQty1"][$i]."','Approved')
			";
			mysqli_query($objCon,$strSQL);

			$q="UPDATE $ubranch SET QLeft = QLeft - '".$_SESSION["strQty1"][$i]."' where ID = '".$_SESSION["strProductID1"][$i]."'";
			if(!$objCon->query($q))
			{
				echo "UPDATE failed. Error: ".$objCon->error ;
			}
		}
	 }

	mysqli_close($objCon);
	//$_SESSION["note"] = $note;
	unset($_SESSION['strProductID1']);
	unset($_SESSION['strQty1']);
	unset($_SESSION["intLine1"]);
	unset($_SESSION["numLine1"]);
	unset($_SESSION["canGetMore1"]);
	unset($_SESSION["MAX1"]);
	//unset($_SESSION["Fromloc"]);
	header("location:index2.php");
?>
