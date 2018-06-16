<?php
	require_once('connect.php');
	if(!isset($_SESSION['ugroup'])){
		header("Location: login.php");
	}
	if($_SESSION['ugroup']==1){
		header("Location: index.php");
	}
	/*if($_SESSION["supervisor"]!=""){
		$sup = $_SESSION["supervisor"];
		$strSQL = "SELECT email FROM user WHERE user_Name = '$sup'";
		$objQuery = mysqli_query($objCon,$strSQL);
		$objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
		$sendTo = $objResult["email"];
	}
	else
	{
		$sendTo = "เมลหัวหน้าหน่วยจัดซื้อ";
	}*/
	$strSQL = "SELECT supervisor FROM user WHERE user_ID = 5";
	$objQuery = mysqli_query($objCon,$strSQL);
	$objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
	$supervior = $objResult["supervisor"];
	$strSQL = "SELECT email FROM user WHERE user_Name = '$supervior'";
	$objQuery = mysqli_query($objCon,$strSQL);
	$objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
	$sMail = $objResult["email"];
	$taa = "acmkritayot@gmail.com";		//เตรียมเอาออก
?>
<html>
	<head>
	</head>
	<body>
		<?php
			require_once('class.phpmailer.php');
			ob_start();
			include($_SESSION['filename']);
			$msg = ob_get_contents();
			ob_end_clean();
			$mail = new PHPMailer();
			$mail->IsHTML(true);
			$mail->IsSMTP();
			$mail->SMTPAuth = true; // enable SMTP authentication
			$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
			$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
			$mail->Port = 465; // set the SMTP port for the GMAIL server
			$mail->Username = "omis.mail.test@gmail.com"; // GMAIL username
			$mail->Password = "golfisgay"; // GMAIL password
			$mail->From = "omis.mail.test@gmail.com"; // "name@yourdomain.com";
			//$mail->AddReplyTo = "support@thaicreate.com"; // Reply
			$mail->FromName = "SIIT OMIS";  // set from Name
			$mail->Subject = "[OMIS] Requests for confirmation";
			$body = $msg;
			$mail->MsgHTML($body);

			$mail->AddAddress($taa, "User"); // to Address

			//$mail->AddAttachment("dangerousfile.zip");
			//$mail->AddAttachment("fuckingdangerousfile.zip");

			//$mail->AddCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC
			//$mail->AddBCC("member@thaicreate.com", "Mr.Member ShotDev"); //CC

			$mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low

			$mail->Send();
			unset($_SESSION['strProductID']);
			unset($_SESSION['strQty']);
			unset($_SESSION["intLine"]);
			unset($_SESSION["numLine"]);
			unset($_SESSION['orderID']);
			unset($_SESSION['filename']);
			unset($_SESSION["canGetMore"]);
			unset($_SESSION["MAX"]);
      		header("Location: index2.php");
		?>
	</body>
</html>
