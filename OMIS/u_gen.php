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
if(isset($_GET["ID"])){
	$ID = $_GET["ID"];
	$_SESSION['orderID'] = $_GET["ID"];
}
$branch = $_SESSION['ubranch'];
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
	<h2>จากผู้ใช้: <?php echo $_SESSION['ubranch']; ?></h2>
	<br>
</center>

<table id="tb0">
  <tr>
    <th><center>รายการ</center></th>
    <th><center>จำนวน</center></th>
  </tr>
  <?php
  //$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
  //$q="select detail.Order_ID, detail.Item_ID, detail.Quantity, rs_stock.Full_name
  //from detail INNER JOIN rs_stock ON detail.Item_ID=rs_stock.ID Where Order_ID=$ID";
  $q="select item.Pic, item.Full_Name, detail.Quantity, detail.status from detail,item where detail.Item_ID=item.ID and detail.Order_ID = $ID";
  $result=$objCon->query($q);
  if(!$result){
  echo "Select failed. Error: ".$objCon->error ;
  }
  $count = 0;
  while($row=$result->fetch_array()){?>
  <tr>
    <td><center><?=$row['Full_Name']?></center></td>
    <td><center><?=$row['Quantity']?></center></td>
  </tr>
  <?php } ?>
</table>
<br>
<center><h2><a href="https://sp.siit.tu.ac.th/OMIS/login_mail.php?link=<?php echo $_SESSION['orderID']; ?>" class="button1">คลิกเพื่อเข้าสู่ระบบ<a></h2></center>
<?php
date_default_timezone_set("Asia/Bangkok");
echo "<center>"."Order Date: " . date("d/m/Y")." ".date("h:i:sa")."</center>";
$_SESSION['filename'] = "ordermail/User-Order-ID-".$_SESSION['orderID'].".html";
file_put_contents($_SESSION['filename'], ob_get_contents());
header("Location: u_send.php");
?>
</html>
