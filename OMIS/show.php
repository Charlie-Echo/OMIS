<?php
//session_start();
//error_reporting(E_ALL ^ E_NOTICE);
require_once('connect.php');
/*if($_SESSION['ugroup']!=1){
	header("Location: show2.php");
}*/
if(!isset($_SESSION["intLine"])||($_SESSION["numLine"]==0))
{
	header("location:show_empty.php");
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  	<title>SIIT Office Material Inventory System</title>
	</head>
<div id="wrapper">
	<body>
		<div id="div_header">
		<center><img src="logo.jpg" alt="logo"></center>
		<br>
		<center><h1>Office Material Inventory System</center>
		</div>
		<div id="div_subhead">
			<ul>
				<li><a href="index.php">รายการ</a></li>
				<li><a class="active" href="show.php">โอน</a></li>
				<li><a href="search.php">ค้นหา</a></li>
				<li><a href="add.php">นำเข้า</a></li>
				<li><a href="return.php">รับคืน</a></li>
				<li><a href="history.php">ประวัติ</a></li>
				<li><a href="request.php">คำร้อง</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				  <form action="update.php" method="post">
				<table id="tb0">
				  <tr>
				    <th>ProductID</th>
				    <th>ProductName</th>
				    <th>Qty</th>
				    <th>Del</th>
				  </tr>
				  <?php
					  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
					  {
						  if($_SESSION["strProductID"][$i] != "")
						  {
							$strSQL = "SELECT * FROM rs_stock WHERE ID = '".$_SESSION["strProductID"][$i]."' ";
							$objQuery = mysqli_query($objCon,$strSQL);
							$objResult = $objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
					 ?>

					  <tr>
						<td><?=$_SESSION["strProductID"][$i];?></td>
						<td><?=$objResult["Full_Name"];?></td>
						<td><input type="text" name="txtQty<?php echo $i;?>" value="<?php echo $_SESSION["strQty"][$i];?>"></td>
						<td><a href="delete.php?Line=<?=$i;?>">X</a></td>
					  </tr>

					 <?php
					  	}
				  	}
				   ?>
				</table>
				<br>
				<center><input type="submit" class="button1" value="Update"></center>
				</form>
				<center>
				<br><a class="button1" href="index.php">Go to Product</a>
				<?php
					if((int)$_SESSION["numLine"] > 0)
					{
				?>
					| <a href="checkout.php">CheckOut</a>
				<?php
					}
				?>
				</center>
				<?php
				mysqli_close($objCon);
				?>


			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
