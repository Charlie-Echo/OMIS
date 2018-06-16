<?php
	//session_start();
	require_once('connect.php');
	$uname = $_SESSION['uname'];

	$_SESSION['ugroup'];
	  $strSQL = "
		INSERT INTO history (User) VALUES	('$uname')";
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
					INSERT INTO detail (Order_ID,Item_ID,Quantity,status)
					VALUES
					('".$strOrderID."','".$_SESSION["strProductID"][$i]."','".$_SESSION["strQty"][$i]."')
				  ";
				  mysqli_query($objCon,$strSQL);
		  }
	  }
	mysqli_close($objCon);
	//header("location:alab.php");
	//session_destroy();

	unset($_SESSION['strProductID']);
	unset($_SESSION['strQty']);
	unset($_SESSION["intLine"]);
	unset($_SESSION["numLine"]);

	header("location:index.php");
	//header("location:finish_order.php?OrderID=".$strOrderID);
?>