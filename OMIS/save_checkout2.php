<?php
	//session_start();
	require_once('connect.php');
	$uname = $_SESSION['uname'];
	$ubranch = $_SESSION['ubranch'];
	$stockloc = $_SESSION["Fromloc"];
	$year = (date("Y")+543-1);
	$numcount = 0;
	//$note = $_POST["note"];

	$qty = "SELECT branch_code from user WHERE branch = '$ubranch'";	//generate TRcode
	$result=$objCon->query($qty);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$row=$result->fetch_array();
	$gencode = "TR".$row['branch_code'];

	$count = "SELECT Year, NumCount FROM history WHERE From_stock = '$stockloc' AND To_stock = '$ubranch' AND TRcode = '$gencode' AND Year = '$year' AND Type = 1 ORDER BY Year DESC, NumCount DESC LIMIT 1";	//generate NumCount
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

	  $strSQL = "
		INSERT INTO history (Type,User,From_stock,To_stock,TRcode,NumCount,Year,status) VALUES ('1','$uname','$stockloc','$ubranch','$gencode','$numcount','$year','Waiting')";
	  $objQuery = mysqli_query($objCon,$strSQL);
	  if(!$objQuery)
	  {
		echo $objCon->error;
		exit();
	  }

	  $strOrderID = mysqli_insert_id($objCon);

	  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
	  {
		  if($_SESSION["strProductID"][$i] != "")
		  {
				  $strSQL = "
					INSERT INTO detail (Order_ID,Type,Item_ID,Quantity,status)
					VALUES
					('".$strOrderID."','1','".$_SESSION["strProductID"][$i]."','".$_SESSION["strQty"][$i]."','Waiting')
				  ";
				  $objQuery = mysqli_query($objCon,$strSQL);
				  if(!$objQuery)
				  {
					echo $objCon->error;
					exit();
				  }
		  }
	  }



	$_SESSION['orderID'] = $strOrderID;
	// unset($_SESSION['strProductID']);
	// unset($_SESSION['strQty']);
	// unset($_SESSION["intLine"]);
	// unset($_SESSION["numLine"]);
	// unset($_SESSION["Fromloc"]);
	if($_SESSION["supervisor"]=="-"){
		if($objCon->connect_errno)
		{
			echo $objCon->connect_errno.": ".$objCon->connect_error;
		}
		$q="UPDATE history SET status = 'Waiting' where ID = '$strOrderID'";
		if(!$objCon->query($q))
		{
			echo "UPDATE failed. Error: ".$objCon->error ;
		}
		header("location:gen_mail.php");
	}else{
		if($objCon->connect_errno)
		{
			echo $objCon->connect_errno.": ".$objCon->connect_error;
		}
		$q="UPDATE history SET status = 'WaitingS' where ID = '$strOrderID'";
		if(!$objCon->query($q))
		{
			echo "UPDATE failed. Error: ".$objCon->error ;
		}

		// unset($_SESSION['strProductID']);
		// unset($_SESSION['strQty']);
		// unset($_SESSION["intLine"]);
		// unset($_SESSION["numLine"]);
		// unset($_SESSION['orderID']);
		// unset($_SESSION['filename']);
		// unset($_SESSION["canGetMore"]);
		// unset($_SESSION["MAX"]);
		header("location:u_gen.php?ID=$strOrderID");
	}
	mysqli_close($objCon);
?>
