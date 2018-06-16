<?php
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	require_once('connect.php');

	$q="select * from user
	WHERE user_Name='".$username."'
	and user_Password='".$password."'" ;

	$result = $objCon->query($q);
	$rowcount = $result->num_rows;
	if (!$result)
	{
		die('Error: '.$q." ". $mysqli->error);
	}
	if($rowcount==1)
	{
		$row = $result->fetch_array();
		$_SESSION['uid'] = $row["user_ID"];
		$_SESSION['uname'] = $row["user_Name"];
		$_SESSION['ugroup'] = $row["user_Group"];
		$_SESSION['ubranch'] = $row["branch"];
		$_SESSION['supervisor'] = $row["supervisor"];

		$u123 = $row['branch'];

		$q="select branch_name from user WHERE branch = '$u123' LIMIT 1"; //OR Date LIKE '%$keyword%'

		$result=$objCon->query($q);
		if(!$result){
			echo "Select failed. Error: ".$mysqli->error ;
		}
		$row=$result->fetch_array();
		$_SESSION['branchfullname'] = $row['branch_name'];

		if(!isset($_POST['link'])){
			header("Location: index.php");
		}
		if(isset($_POST['link']) && $_SESSION['ugroup']==1) {
			header("Location: r_detail.php?ID=".$_POST['link']);
		}
		if(isset($_POST['link']) && $_SESSION['ugroup']==2){
			header("Location: s_detail.php?ID=".$_POST['link']);
		}
	}
	else
	{
		header("Location: loginfail.php");
	}
?>
