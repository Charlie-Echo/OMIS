<?php
require_once('connect.php');
ob_start();
$stockloc = $_SESSION["Fromloc"];
if(!isset($_SESSION['ugroup'])){
	header("Location: login.php");
}
if($_SESSION['ugroup']==1){
	header("Location: index.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<style>
	h1 {
		display: block;
		font-size: 1.5em;
		color: rgb(70,36,86);
		font-weight: bold;
	}
	h2 {
		display: block;
		font-size: 1em;
		color: rgb(70,36,86);
	}
	table {
		border-collapse: collapse;
		width: 100%;
		margin-left: auto;
		margin-right: auto;
	}

	table#tb0 {
		border-collapse: collapse;
		width: 70%;
		height: 100%;

	}

	table#tb0 th, td {
		text-align: left;
		padding: 8px;
		color: black;
		border: 1px solid rgb(185,152,195);
	}

	table#tb0 tr:nth-child(even){
		background-color: #f2f2f2;
	}

	table#tb0 th {
		background-color: rgb(70,36,86);
		color: white;
	}
	</style>
</head>
<center>
	<h1>SIIT Office Material Inventory System</h1>
	<h2>จากคลัง: <?php echo $_SESSION['ubranch']; ?></h2>
	<br>
</center>
<table id="tb0">
	<tr>
		<th>รายการ</th>
		<th>จำนวน</th>
	</tr>
	<?php
	$numItem = 1;
	for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
	{
		if($_SESSION["strProductID"][$i] != "")
		{
			$strSQL = "SELECT * FROM $stockloc WHERE ID = '".$_SESSION["strProductID"][$i]."' ";
			$objQuery = mysqli_query($objCon,$strSQL);
			$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
			?>
			<tr>
				<td><?=$objResult["Full_Name"];?></td>
				<td><?=$_SESSION["strQty"][$i];?></td>
			</tr>
			<?php
		}
	}
	?>
</table>
<br>
<center><h2><a href="https://sp.siit.tu.ac.th/OMIS/login_mail.php?link=<?php echo $_SESSION['orderID']; ?>" class="button1">คลิกเพื่อเข้าสู่ระบบ<a></h2></center>
<?php
date_default_timezone_set("Asia/Bangkok");
echo "<center>"."วันที่ขอเบิก: " . date("d/m/Y")." ".date("h:i:sa")."</center>";
$_SESSION['filename'] = "ordermail/Order-ID-".$_SESSION['orderID'].".html";
file_put_contents($_SESSION['filename'], ob_get_contents());
header("Location: send_mail.php");
?>
</html>
