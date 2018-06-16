<?php
	//session_start();
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==2){
		header("Location: index2.php");
	}
	$name = $_POST['name'];
	$unit = $_POST['unit'];
	$code = $_POST['code'];
	// $stock = $_POST['stock'];

	$target_dir = "Pic/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
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
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
		header( "refresh:5; url=add.php" );
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 1000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
		header( "refresh:5; url=add.php" );
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
		header( "refresh:5; url=add.php" );
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
			header( "refresh:5; url=add.php" );
		}
		$strSQL = "
    	INSERT INTO item (ID, Pic, Code, Full_Name, Unit)
    	VALUES (NULL, 'Pic/".$_FILES["fileToUpload"]["name"]."', '$code', '$name', '$unit')";
		$objQuery = mysqli_query($objCon,$strSQL);
		if(!$objQuery)
		{
		echo $objCon->error;
		exit();
		}
		mysqli_close($objCon);
		header("location:added.php");
	}
?>
