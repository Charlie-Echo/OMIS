<?php
	require_once('connect.php');
	ob_start();
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$ID = $_GET['ID'];
	//echo $ID;
	$branch = $_SESSION['ubranch'];
	$fd = $_GET["fd"];
	$td = $_GET["td"];
	$runtime = 0;
	$i = 0;
	/*
	DROP TABLE `bkd_as&r`, `bkd_bg`, `bkd_cco`, `bkd_com&av`, `bkd_fin`,
	`bkd_ict`, `bkd_mt`, `bkd_od`, `bkd_pm`, `bkd_sa&ar`, `bkd_sp`, `bkd_stock`, `detail`, `history`, `imbkd`, `import_detail`, `import_list`,
	`imrs`, `item`, `rs_acc`, `rs_ad&pr`, `rs_as&r`, `rs_bcet`, `rs_bg`, `rs_cco`, `rs_cet`, `rs_cgs`, `rs_com&av`, `rs_fin`, `rs_ia&cr`, `rs_lib`,
	`rs_msme`, `rs_od`, `rs_r&qa`, `rs_sa&ar`, `rs_sp`, `rs_stock`, `user`;
	*/

//----------------------------------------------------------------------------------------------------------------------------------------
	$q="SELECT * FROM detail WHERE Order_ID = '$ID'";
	$result=$objCon->query($q);
	if(!$result){
		echo "Select failed. Error: ".$objCon->error ;
	}
	while($row=$result->fetch_array()){
		$itemID = $row['Item_ID'];	//เก็บIDของitemในใบสั่งซื้อ
		$qty = strval($row['Quantity']);	//เก็บจำนวนของitemในใบสั่งซื้อ
		echo "itemID = ".$itemID."<br>";

		/*$qq="SELECT Quantity FROM import_detail WHERE Order_ID = '$ID' AND Item_ID = '$itemID'";	//หาจำนวนของitemในimport_detail
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}*/
		$qq="SELECT $branch.QLeft, import_detail.Quantity FROM `$branch`, `import_detail`
		WHERE import_detail.Order_ID = '$ID' AND import_detail.Item_ID = '$itemID' AND import_detail.Item_ID = $branch.ID";	//หาจำนวนของitemในimport_detail
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}

		$row1=$result1->fetch_array();
		$num = strval($row1['Quantity']);	//จำนวนของitemในimport_detail
		$num1 = strval($row1['QLeft']);	//จำนวนของitemในสต็อก
		//echo $num;

		if($num1 - $qty >= 0){	//ถ้าจำนวนคงเหลือทั้งหมดมีมากกว่าหรือเท่ากับจำนวนในใบสั่งซื้อ ให้หักออกตามจำนวน
			$qq="UPDATE `$branch` SET QLeft = QLeft - $qty WHERE ID = $itemID";	//อัพเดตจำนวนในสต็อคให้กลับไปเป็นแบบเดิม
			$result1=$objCon->query($qq);
			if(!$result1){
				echo "Select failed. Error: ".$objCon->error ;
			}
		}
		else {	//ไม่งั้นก็เซ็ตให้เป็น 0
			$qq="UPDATE `$branch` SET QLeft = '0' WHERE ID = $itemID";	//อัพเดตจำนวนในสต็อคให้กลับไปเป็นแบบเดิม
			$result1=$objCon->query($qq);
			if(!$result1){
				echo "Select failed. Error: ".$objCon->error ;
			}
		}

		$newqty = $num - $qty;	//เช็คว่าจำนวนที่ยังเหลือในล็อตนั้นมีมากกว่า/น้อยกว่าจำนวนในใบสั่งซื้อ
		//echo $qty." - ".$num." = ".$newqty."<br>";
		while($newqty < 0){	//ถ้าจำนวนของในล็อตมีน้อยกว่าจำนวนในใบสั่งซื้อ ให้ไปตัดรายการถัดไปที่ไม่ใช่ 0 ต่อไป
			$qq="SELECT Quantity, Order_ID FROM `import_detail` WHERE Item_ID = $itemID AND Branch = '$branch'
			AND Order_ID > $ID AND Quantity > '0' ORDER BY Order_ID ASC LIMIT 1";	//หาการimportครั้งต่อไปที่มีจน. > 0
			$result1=$objCon->query($qq);
			if(!$result1){
				echo "Select failed. Error: ".$objCon->error ;
			}
			$row11=$result1->fetch_array();
			$nextimportID = $row11['Order_ID'];	//รายการถัดไปที่จะตัดออก
			$total = $row11['Quantity'];	//จำนวนitemในรายการถัดไป

			if($total + $newqty == 0){	//จำนวนของในรายการถัดไปเท่ากับจำนวนที่ต้องตัดต่อ ให้ตัดเป็น 0 แล้วจบ
				$qq="UPDATE `import_detail` SET Quantity = '0' WHERE Order_ID = '$nextimportID' AND Item_ID = '$itemID'";	//อัพเดตจำนวนในสต็อค
				$result1=$objCon->query($qq);
				$newqty = 0;
				//echo "Sal<br>";
			}
			elseif($total + $newqty > 0){	//จำนวนของในรายการถัดไปมากกว่าจำนวนที่ต้องตัดต่อ ให้ตัดเท่ากับจำนวนนั้นแล้วจบ
				$qq="UPDATE `import_detail` SET Quantity = Quantity + $newqty WHERE Order_ID = '$nextimportID' AND Item_ID = '$itemID'";	//อัพเดตจำนวนในสต็อค
				$result1=$objCon->query($qq);
				$newqty = 0;
				//echo "Lincoln<br>";
			}
			else{	//จำนวนของในรายการถัดไปน้อยกว่าจำนวนที่ต้องตัดต่อ ให้ตัดจำนวนในรายการถัดไป = 0 แล้วเข้าwhile loopใหม่
				if (mysqli_num_rows($result1) == 0){
					$newqty = 0;
					//echo "Vito 1<br>";
				}
				else {
					$qq="UPDATE `import_detail` SET Quantity = 0 WHERE Order_ID = '$nextimportID' AND Item_ID = '$itemID'";	//อัพเดตจำนวนในสต็อค
					$result1=$objCon->query($qq);
					$newqty = $row11['Quantity'] + $newqty;
					//echo "Vito 2<br>";
				}
			}
		}
		//echo "kuy".$i."<br>";
		//$i++;
	}
//----------------------------------------------------------------------------------------------------------------------------------------
	if($runtime == 0){
		$qq="DELETE FROM `import_list` WHERE Order_ID = $ID";	//ลบรายการในimport_listออก
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}

		$qq="DELETE FROM `history` WHERE ID = $ID";	//ลบรายการในhistoryออก
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}

		$qq="DELETE FROM `detail` WHERE Order_ID = $ID";	//ลบรายการในdetailออก
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}

		$qq="DELETE FROM `import_detail` WHERE Order_ID = $ID";	//ลบรายการในimport_detailออก
		$result1=$objCon->query($qq);
		if(!$result1){
			echo "Select failed. Error: ".$objCon->error ;
		}
		$runtime = 1;
	}

	$_SESSION['fd'] = $fd;
	$_SESSION['td'] = $td;
	echo "ลบข้อมูลแล้ว กำลังredirectกลับใน5วินาที";
	header("refresh: 5; url=history.php");
?>
