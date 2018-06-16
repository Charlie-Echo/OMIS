<?php
require_once('connect.php');
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==2){
	header("Location: index2.php");
}
if(!isset($_POST['fileToUpload']) && isset($_POST['del'])){
	if($_POST['del']=="del"){
		$_FILES["fileToUpload"]["name"] = "noimage.jpg";
		$_FILES["fileToUpload"]["tmp_name"] = "Pic/noimage.jpg";
	}
}
$ID = $_POST['id'];
$name = $_POST['newname'];
$unit = $_POST['newunit'];
$code = $_POST['newcode'];
$uploadOk = 1;
$i = 0;
//echo $ID;
?>

<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>SIIT Office Material Inventory System</title>

</head>
<div id="wrapper">
	<body>
		<div id="div_header" class="noprint">
			<center><img src="logo.jpg" alt="logo"></center>
			<br>
			<center><h1>Office Material Inventory System</center>
			</div>
			<div id="div_subhead">
				<ul>
					<li><a class="active" href="index.php">รายการ</a></li>
					<li><a href="search.php">ค้นหา</a></li>
					<li>
						<div class="dropdown">
							<a href="add.php">นำเข้า</a>
							<div class="dropdown-content">
								<a href="add_new.php">เพิ่มวัสดุใหม่</a>
							</div>
						</div>
					</li>
					<li><a href="selectyearhistory.php">ประวัติ</a></li>
					<li><a href="request.php">คำร้อง</a></li>
					<li style="float:right"><a href="logout.php">LOGOUT</a></li>
					<li style="float:right"><a href="manual.php">คู่มือการใช้งาน</a></li>
					<li style="float:right">
						<div class="dropdown">
							<a href="changepass.php">ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a>
							<div class="dropdown-content">
								<a href="createbranch.php">เพิ่มหน่วยงานใหม่</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div id="div_main">
				<div id="div_content">
					<center>
						<?php
						if(!isset($ID)){
							echo "<h3><font color='red'>กรุนาทำให้ถูกขั้นตอน!</font><h3> <br> <a href='edititem.php' class='button1'>ย้อนกลับ</a>";
						}
						elseif($name == '' || $unit == ''){			//กรอกไม่ครบ
							echo "<h3><font color='red'>ช่องชื่อวัสดุและหน่วยของวัสดุไม่สามารถเว้นว่างได้! กรุนากรอกข้อมูลให้ครบ</font><h3> <br> <a href='edititem.php?ID=$ID' class='button1'>ย้อนกลับ</a>";
						}
						elseif(isset($_POST['delitem'])){
							$searchtable = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='OMIS'
							AND (TABLE_NAME LIKE 'rs_%' OR TABLE_NAME LIKE 'bkd_%' OR TABLE_NAME = 'item')";
							$result=$objCon->query($searchtable);
							if(!$result){
								echo "Select failed. Error: ".$objCon->error ;
							}
							while ($row=$result->fetch_array()) {		//เก็บรายชื่อหน่วยงานทั้งหมด
								$listtable = $row['TABLE_NAME'];
								$searchtable = "DELETE FROM $listtable WHERE ID = $ID";
								$result=$objCon->query($searchtable);
								if(!$result){
									echo "DELETE failed. Error: ".$objCon->error ;
								}
								//echo $listoftable[$i]."<br>";
								//$i++;
							}
							echo "<h3>ลบรายการวัสดุสำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
						}
						else{			//แก้ได้สำเร็จ
							$searchtable = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='OMIS'
							AND (TABLE_NAME LIKE 'rs_%' OR TABLE_NAME LIKE 'bkd_%' OR TABLE_NAME = 'item')";
							$result=$objCon->query($searchtable);
							if(!$result){
								echo "Select failed. Error: ".$objCon->error ;
							}
							while ($row=$result->fetch_array()) {		//เก็บรายชื่อหน่วยงานทั้งหมด
								$listoftable[$i] = $row['TABLE_NAME'];
								//echo $listoftable[$i]."<br>";
								$i++;
							}
							$count = count($listoftable);
							//-------------------------------------------------------------------------------------------------------------------------------------
							$target_dir = "Pic/";
							$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
							$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							// Check if image file is a actual image or fake image
							if(isset($_POST["submit"])) {
								$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
								if($check !== false) {
									echo "File is an image - " . $check["mime"] . ".";
									$uploadOk = 1;
								} else {
									echo "File is not an image.";
									$uploadOk = 0;
								}
							}
							// Check if file already exists
							// if (file_exists($target_file)) {
							// 	echo "Sorry, file already exists.";
							// 	$uploadOk = 0;
							// 	header( "refresh:5; url=edititem.php?ID=".$ID );
							// }
							// Check file size
							if ($_FILES["fileToUpload"]["size"] > 5000000) {
								echo "Sorry, your file is too large.";
								$uploadOk = 0;
								header( "refresh:5; url=edititem.php?ID=".$ID);
							}
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" ) {
								echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								$uploadOk = 0;
								header( "refresh:5; url=edititem.php?ID=".$ID );
							}
							// Check if $uploadOk is set to 0 by an error
							if ($uploadOk == 0) {
								echo "Sorry, your file was not uploaded.";
								// if everything is ok, try to upload file
							} else {
								if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
									//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

									// $picPath = "Pic/".$_FILES["fileToUpload"]["name"];
									// echo $picPath;
									// $sql = "SELECT Pic, Full_Name FROM item WHERE Pic = '$picPath'";
									// $result = $objCon->query($sql);
									// $row=$result->fetch_array();
									// echo $row["Full_Name"];

									$picPath = "Pic/".$_FILES["fileToUpload"]["name"];
									echo $picPath;
									$q = "SELECT Pic, Full_Name FROM item WHERE Pic = '$picPath'";
									$result = $objCon->query($q);
									$rowcount = $result->num_rows;
									if (!$result)
									{
										die('Error: '.$q." ". $mysqli->error);
									}
									if($rowcount>=1)
									{
											echo "Duplicated";
											for($i=0;$i<$count;$i++){
												$strSQL = "UPDATE `$listoftable[$i]` SET Full_Name = '$name',
												Code = '$code', Unit = '$unit' WHERE ID = '$ID' ";
												$objQuery = mysqli_query($objCon,$strSQL);
												if(!$objQuery){
													echo $objCon->error;
													exit();
												}
											}
											echo "<h3>แก้ไขวัสดุสำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
									}
									// if (file_exists($target_file)) {
									// 	echo "Duplicated";
									// 	for($i=0;$i<$count;$i++){
									// 		$strSQL = "UPDATE `$listoftable[$i]` SET Full_Name = '$name',
									// 		Code = '$code', Unit = '$unit' WHERE ID = '$ID' ";
									// 		$objQuery = mysqli_query($objCon,$strSQL);
									// 		if(!$objQuery){
									// 			echo $objCon->error;
									// 			exit();
									// 		}
									// 	}
									// 	echo "<h3>แก้ไขวัสดุสำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
									// }
									else{
										echo "Not Duplicate";
										for($i=0;$i<$count;$i++){
											$strSQL = "UPDATE `$listoftable[$i]` SET Full_Name = '$name',
											Code = '$code', Unit = '$unit', Pic = 'Pic/".$_FILES["fileToUpload"]["name"]."' WHERE ID = '$ID' ";
											$objQuery = mysqli_query($objCon,$strSQL);
											if(!$objQuery){
												echo $objCon->error;
												exit();
											}
										}
										echo "<h3>แก้ไขวัสดุสำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
									}

								}
								else {
									if($_FILES["fileToUpload"]["name"] = "noimage.jpg"){
										for($i=0;$i<$count;$i++){
											$strSQL = "UPDATE `$listoftable[$i]` SET Full_Name = '$name',
											Code = '$code', Unit = '$unit', Pic = 'Pic/noimage.jpg' WHERE ID = '$ID' ";
											$objQuery = mysqli_query($objCon,$strSQL);
											if(!$objQuery){
												echo $objCon->error;
												exit();
											}
										}
										echo "<h3>แก้ไขวัสดุสำเร็จ!<h3> <br> <a href='index.php' class='button1'>กลับไปหน้าแรก</a>";
									}
									else{
										echo "Sorry, there was an error uploading your file.";
										header( "refresh:5; url=edititem.php?ID=".$ID );
									}
								}
								mysqli_close($objCon);
							}
						}
						?>
					</center>
				</div> <!-- end div_content -->
			</div> <!-- end div_main -->
		</div>
	</body>
	</html>
