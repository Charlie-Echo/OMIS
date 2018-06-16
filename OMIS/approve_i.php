<?php
	require_once('connect.php');
	$ID = $_SESSION["appID"];
	$fromstock = $_SESSION["fromstock"];
	$tostock = $_SESSION["tostock"];
	echo("History ID is ".$ID."<br>");
	$IDarray = array();
	$Picarray = array();
	$Codearray = array();
	$FNarray = array();
	$QLeftarray = array();
	$Unitarray = array();

	$i = 0;
	$cond = 0;

	$strSQL = "SELECT Item_ID, Quantity FROM detail WHERE Order_ID = $ID";
	$result=$objCon->query($strSQL);
	if(!$result){
		echo "Select failed. Error: ".$mysqli->error ;
	}
	while($row = mysqli_fetch_assoc($result)) {
		$IDarray[] = $row['Item_ID']; // add the row in to the results (data) array
		$QLeftarray[] = $row['Quantity'];
	}

	/*for($i=0; $i < sizeof($IDarray); $i++){
		$strSQL = "SELECT * FROM $fromstock WHERE ID = $IDarray[$i]";
		$result=$objCon->query($strSQL);
		if(!$result){
			echo "Select failed. Error: ".$mysqli->error ;
		}
		$row = mysqli_fetch_assoc($result);
		$Picarray[] = $row['Pic'];
		$Codearray[] = $row['Code'];
		$FNarray[] = $row['Full_Name'];
		$Unitarray[] = $row['Unit'];
		//$RNoarray[] = $row['ReceiptNo'];
		/*echo($IDarray[$i]." ".$Picarray[$i]." ".$Codearray[$i]." ".$FNarray[$i]." ".$QLeftarray[$i]." ".$Unitarray[$i]." ".$RNoarray[$i]);
		echo("<br>");
	}*/

	for($i=0; $i < sizeof($IDarray); $i++){
		$strSQL = "SELECT ID FROM $tostock WHERE ID = $IDarray[$i]";
		$result=$objCon->query($strSQL);
		if(!$result){
			echo "Select failed. Error: ".$mysqli->error ;
		}
		if (mysqli_num_rows($result)==0){	//ไม่เจอrecordเก่า ให้เพิ่มข้อมูลใหม่เข้าไป
			$strSQL = "INSERT INTO $tostock VALUES ('$IDarray[$i]', '$Picarray[$i]', '$Codearray[$i]', '$FNarray[$i]', '$QLeftarray[$i]', '$Unitarray[$i]', '$RNoarray[$i]')";
			$result=$objCon->query($strSQL);
			if(!$result){
				echo "Select failed. Error: ".$mysqli->error ;
			}
		}
		else{	//เจอrecordเก่า ให้เพิ่มเลขเข้าไป
			$strSQL = "UPDATE $tostock SET QLeft = QLeft + $QLeftarray[$i] WHERE ID = $IDarray[$i]";
			$result=$objCon->query($strSQL);
			if(!$result){
				echo "Select failed. Error: ".$mysqli->error ;
			}
		}
		$strSQL = "UPDATE $fromstock SET QLeft = QLeft - $QLeftarray[$i] WHERE ID = $IDarray[$i]";
		$result=$objCon->query($strSQL);
		if(!$result){
			echo "Select failed. Error: ".$mysqli->error ;
		}
	}

	for($i=0; $i < sizeof($IDarray); $i++){
		if($IDarray[$i] != "")
		{
			$result = $QLeftarray[$i];	//จำนวนที่ขอเบิก
			//echo "result is: ".$result;
			echo "<br>";

			$getID = $IDarray[$i];	//หา Item_ID
			echo("Item ID is ".$getID."<br><br>");
			$firsttime = 0;
			$total = $QLeftarray[$i];

			/*$ItemName = "select Full_Name From $fromstock where ID = $getID";
			$query = mysqli_query($objCon,$ItemName);
			$objResult = mysqli_fetch_array($query,MYSQLI_ASSOC);
			$getItemName = $objResult["Full_Name"];	//หา Full_Name*/

			$strSQL = "SELECT * FROM import_detail where Item_ID = $getID AND Branch = '$fromstock' order by ID";
			$query = mysqli_query($objCon,$strSQL);
			$ii = 0;
			while($row=$query->fetch_array()){
				$getEachID[$ii] = $row["ID"];
				$getEachQLeft[$ii] = $row["Quantity"];
				$getEachPrice[$ii] = $row["Price"];
				echo "ID: ".$getEachID[$ii];				//ใส่ Item_ID ลงไปใน Array $getEachID[$i]
				echo " QLEFT: ".$getEachQLeft[$ii]." ";	//ใส่ จำนวนที่ยังเหลือของแต่ละorder_number ลงไปใน Array $getEachQLeft[$i]
				echo "Price: ".$getEachPrice[$ii];
				echo "<br>";
				$ii++;
			}
			//echo "<br>";
			//echo $getEachQLeft[2]-$getEachQLeft[1];
			//echo "<br>";
			foreach ($getEachQLeft as $key => $value) { // $key = index
				echo $key." with val ".$value;
				echo "<br>";
				//var_dump($result);
				//$remain = $value;
				if($value >= $result){ // item of row x more than wanted number

					$result = $value - $result; // wanted number - item of row x
					echo "result is ".$result; // remaining of wanted number
					echo "<br>";
					if($result == 0){ // item in row x = wanted number
						//set row's Qty = 0
						echo "Condition 1 <br>";
						echo "set ".$getEachID[$key]." = 0";
						echo "<br>";
						$sql = "UPDATE import_detail SET Quantity = 0 where ID = '$getEachID[$key]' AND Branch = '$fromstock' ORDER BY ID LIMIT 1";
						$query = mysqli_query($objCon,$sql);
						if($query) {
							echo "Record update successfully";
						}
						//break;
						if($cond == 1 && $firsttime != 0){	//รอบสุดท้ายลบกันได้0
							echo "SubCondition 1.1 <br>";
							$q="INSERT INTO detail (Type, Order_ID, Item_ID, Quantity, CostPerUnit, status)
								SELECT Type, Order_ID, Item_ID, $value, $getEachPrice[$key], status
								FROM detail
								WHERE Order_ID = $ID AND Item_ID = $getID LIMIT 1;";
							if(!$objCon->query($q))
							{
								echo "INSERT failed. Error: ".$objCon->error ;
							}
							$cond = 0;
							break;
						}
						elseif($cond == 0 || $firsttime == 0){	//รอบแรก
							echo "SubCondition 1.2 <br>";
							$q = "UPDATE detail SET Quantity = $value, CostPerUnit = $getEachPrice[$key] where Order_ID = $ID AND Item_ID = $getID";
							if(!$objCon->query($q))
							{
								echo "UPDATE failed. Error: ".$objCon->error ;
							}
							break;
						}

					}elseif($value > $result){ //item of row x still more than remaining wanted
						//set row's Qty = the remainging
						echo "Condition 2 <br>";
						if($objCon->connect_errno)
						{
							echo $objCon->connect_errno.": ".$objCon->connect_error;
						}
						$q="UPDATE import_detail SET Quantity = $result where ID = $getEachID[$key] AND Branch = '$fromstock' ORDER BY ID LIMIT 1";
						if(!$objCon->query($q))
						{
							echo "UPDATE failed. Error: ".$objCon->error ;
						}
						echo "Item in row is more than wanted set ".$getEachID[$key]." = ".$total;
						echo "<br>";
						//break;
						if($cond == 1 && $firsttime != 0){	//รอบสุดท้ายลบกันไม่ได้0
							echo "SubCondition 2.1 <br>";
							$q="INSERT INTO detail (Type, Order_ID, Item_ID, Quantity, CostPerUnit, status)
								SELECT Type, Order_ID, Item_ID, $total, $getEachPrice[$key], status
								FROM detail
								WHERE Order_ID = $ID AND Item_ID = $getID LIMIT 1;";
							if(!$objCon->query($q))
							{
								echo "INSERT failed. Error: ".$objCon->error ;
							}
							$cond = 0;
							break;
						}
						elseif($cond == 0 || $firsttime == 0){	//รอบแรก
							echo "SubCondition 2.2 <br>";
							$q = "UPDATE detail SET Quantity = $total, CostPerUnit = $getEachPrice[$key] where Order_ID = $ID AND Item_ID = $getID";
							if(!$objCon->query($q))
							{
								echo "UPDATE failed. Error: ".$objCon->error ;
							}
							break;
						}

					}else{
						echo "Condition 3. You should not be here. <br>";
						/*if($objCon->connect_errno)
						{
							echo $objCon->connect_errno.": ".$objCon->connect_error;
						}
						$q="UPDATE $ubranch SET QLeft = $result where ID = $getEachID[$key]";
						if(!$objCon->query($q))
						{
							echo "UPDATE failed. Error: ".$objCon->error ;
						}
						echo "WTF set ".$getEachID[$key]." = ".$result;
						echo "<br>";*/
					}
				}
				else{ // item of row x less than wanted number
					echo "Condition 4 <br>";
					$checkzero = $value - $result; // 10 - 30 = -20
					$result = $result - $value; // 30 - 10 = 20
					$total = $total - $value;
					if($checkzero < 0){
						echo "check zero = ".$checkzero;
						echo "<br>";
						echo "result = ".$result;
						echo "<br>";
						echo "item in row is less than wanted set ".$getEachID[$key]." = 0";
						echo "<br>";

						if($objCon->connect_errno)
						{
							echo $objCon->connect_errno.": ".$objCon->connect_error;
						}
						$q="UPDATE import_detail SET Quantity = 0 where ID = $getEachID[$key] AND Branch = '$fromstock' ORDER BY ID LIMIT 1";
						if(!$objCon->query($q))
						{
							echo "UPDATE failed. Error: ".$objCon->error ;
						}
						if($firsttime == 0 && $value != 0){	//เข้าลูปนี้รอบแรก
							echo "SubCondition 4.1 <br>";
							$q = "UPDATE detail SET Quantity = $value, CostPerUnit = $getEachPrice[$key] where Order_ID = $ID AND Item_ID = $getID ORDER BY Detail_ID DESC LIMIT 1";
							if(!$objCon->query($q))
							{
								echo "UPDATE failed. Error: ".$objCon->error ;
							}
							$firsttime = 1;
							$cond = 1;
						}
						elseif($firsttime == 1 && $value != 0){	//เข้าลูปนี้รอบที่2ขึ้นไป
							echo "SubCondition 4.2 <br>";
							$q="INSERT INTO detail (Type, Order_ID, Item_ID, Quantity, CostPerUnit, status)
								SELECT Type, Order_ID, Item_ID, $value, $getEachPrice[$key], status
								FROM detail
								WHERE Order_ID = $ID AND Item_ID = $getID LIMIT 1;";
							if(!$objCon->query($q))
							{
								echo "INSERT failed. Error: ".$objCon->error ;
							}
						}
						else{
							echo "SubCondition 4.3. Do nothing. <br>";
						}
					}
				}	//END else
			}	//END foreach
		}	//END if
	}	//END for


	$IDarray = array_fill_keys(array_keys($IDarray), "");
	$Picarray = array_fill_keys(array_keys($Picarray), "");
	$Codearray = array_fill_keys(array_keys($Codearray), "");
	$FNarray = array_fill_keys(array_keys($FNarray), "");
	$QLeftarray = array_fill_keys(array_keys($QLeftarray), "");
	$Unitarray = array_fill_keys(array_keys($Unitarray), "");
	//$RNoarray= array_fill_keys(array_keys($RNoarray), "");

	//mysqli_close($result);
	header("Location: approve_h.php");
?>
