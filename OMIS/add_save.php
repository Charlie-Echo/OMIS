<?php
	require_once('connect.php');
	$orderNO = $_POST["orderNO"];
	$sup = $_POST["supplier"];
	$date = $_POST["date"];
	$note = $_POST["note"];
	$branch = $_SESSION['ubranch'];
	$year = (date("Y")+542);
	$numcount = 0;
	$ID = 0;
	echo "TEST ECHO";
	echo "<br>";

	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$uname = $_SESSION['uname'];

	$qty = "SELECT branch_code from user WHERE branch = '$branch'";	//generate TRcode
	$result=$objCon->query($qty);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$row=$result->fetch_array();
	$gencode = "IM".$row['branch_code'];
	echo "TEST ECHO AFTER GEN CODE";
	echo "<br>";

//-----------------------------------------------------------------------------------------------
	$count = "SELECT NumCount, Year FROM history WHERE TRcode = '$gencode' AND Year = '$year' AND Type = 3 ORDER BY Year DESC, NumCount DESC LIMIT 1";	//generate NumCount
	$result=$objCon->query($count);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	$row1=$result->fetch_array();
	//echo($numcount);
	$numcount = ($row1['NumCount']+1);

	if ( date('m') >= 8 ) {
		$year = date('Y') + 543;
	}
	else {
		$year = date('Y') + 542;
	}
	echo "TEST ECHO AFTER SELECT history";
	echo "<br>";

//-----------------------------------------------------------------------------------------------
		$strSQL = "
		 INSERT INTO history (Type,User,From_stock,To_stock,TRcode,Year,order_number,NumCount,Note,status) VALUES ('3','$uname','$branch','$branch','$gencode','$year','$orderNO','$numcount','$note','Imported')";
		 $objQuery = mysqli_query($objCon,$strSQL);
		 if(!$objQuery)
		 {
			echo $objCon->error;
			exit();
		 }

		 $strOrderID = mysqli_insert_id($objCon);
		 	echo "TEST ECHO AFTER INSERT HISTORY";
			echo "<br>";

//-----------------------------------------------------------------------------------------------
		$orderList = "
		INSERT INTO import_list (Number, Order_ID, Supplier, Date, Note)
		VALUES	('$orderNO', '$strOrderID', '$sup', '$date', '$note')";
		$objQuery = mysqli_query($objCon,$orderList);
		if(!$objQuery)
		{
			echo $objCon->error;
			exit();
		}
		echo "TEST ECHO AFTER INSERT import_list";
		echo "<br>";
//-----------------------------------------------------------------------------------------------
		for($i=0;$i<=(int)$_SESSION["itemLine"];$i++)
		{
			echo "TEST ECHO item number: ".$i;
			echo "<br>";
			if($_SESSION["itemName"][$i] != "")
			{
				echo "TEST ECHO item name not empty";
				echo "<br>";
				$itemName = $_SESSION["itemName"][$i];
				$itemQty = $_SESSION["itemQty"][$i];
				$itemPrice = $_SESSION["itemPrice"][$i];

//-----------------------------------------------------------------------------------------------
			$qty = "SELECT ID from $branch WHERE Full_Name = '$itemName'";	//generate ItemID
			$result=$objCon->query($qty);
			if(!$result){
				echo "Select failed. Error: ".$objCon->error ;
			}
			$row=$result->fetch_array();
			$ID = $row['ID'];
			if($ID == 0){	//ไม่มีของในstockมาก่อน
				echo "TEST ECHO NO item in the stock b4";
				echo "<br>";
				$qty = "SELECT ID from item WHERE Full_Name = '$itemName'";	//generate ItemID
				$result=$objCon->query($qty);
				if(!$result){
					echo "Select failed. Error: ".$objCon->error ;
				}
				$row=$result->fetch_array();
				$ID1 = $row['ID'];
				echo "ID1: ".$ID1;
				echo "<br>";
				echo "branch is: ".$branch;
				echo "<br>";
				$addStock = "INSERT INTO $branch (ID, Pic, Code, Full_Name, QLeft, Unit)
				VALUES ('$ID1', '', '', '$itemName', '$itemQty', '')";
				$objQuery = mysqli_query($objCon, $addStock);
				if(!$objQuery){
					echo $objCon->error;
					exit();
				}
				$ID = $ID1;
				echo "TEST ECHO AFTER INSERT TO Branch";
				echo "<br>";
			}
			else{	//มีของในstockมาก่อน
					echo "TEST ECHO item exist in the stock";
				echo "<br>";
				$addStock = "UPDATE $branch SET QLeft = QLeft + $itemQty WHERE ID = $ID";
				$objQuery = mysqli_query($objCon, $addStock);
				if(!$objQuery){
					echo $objCon->error;
					exit();
				}
				echo "TEST ECHO after UPDATE branch";
				echo "<br>";
			}	
			echo "TEST ECHO ABC";
			echo "<br>";
//-----------------------------------------------------------------------------------------------

			$addDetail = "INSERT INTO detail (Type, Order_ID, Item_ID, Quantity, CostPerUnit, status)
			VALUES ('3', '$strOrderID', '$ID', '$itemQty', '$itemPrice', 'Imported')";
			$objQuery = mysqli_query($objCon, $addDetail);
			if(!$objQuery){
				echo $objCon->error;
				exit();
			}
			echo "TEST ECHO BEFORE SELECT FROM ITEM";
			echo "<br>";
			$q="SELECT Pic, Code, Unit from item WHERE Full_name = '$itemName'";
			$result=$objCon->query($q);
			if(!$result){
				echo "Select failed. Error: ".$objCon->error ;
			}
			$row = $result->fetch_array();
			$pic1 = $row['Pic'];
			$code1 = $row['Code'];
			$unit1 = $row['Unit'];

			$copy = "UPDATE $branch SET $branch.Pic = '$pic1', $branch.Code = '$code1', $branch.Unit = '$unit1' WHERE $branch.Full_Name = '$itemName' ";
			$objQuery = mysqli_query($objCon, $copy);
			if(!$objQuery){
				echo $objCon->error;
				exit();
			}
//-----------------------------------------------------------------------------------------------

			$addImportDetail = "INSERT INTO import_detail (order_number, Item_ID, Order_ID, Branch, Quantity, Price)
			VALUES ('$orderNO', $ID, '$strOrderID', '$branch', '$itemQty', '$itemPrice')";
			$objQuery = mysqli_query($objCon, $addImportDetail);
			if(!$objQuery){
				echo $objCon->error;
				exit();
			}
		}
	  }
	mysqli_close($objCon);
	unset($_SESSION['itemName']);
	unset($_SESSION['itemQty']);
	unset($_SESSION["itemLine"]);
	unset($_SESSION["numLine"]);

	header("location:index.php");
?>
