<?php
require_once('connect.php');
//session_start();
$ID = $_GET["ID"];
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
				<li><a href="index3.php">รายการ</a></li>
				<li><a href="show3.php">เบิก</a></li>
				<li><a href="search3.php">ค้นหา</a></li>
				<li><a class="active" href="history3.php">ประวัติ</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
        <table id="tb0">
          <tr>
            <th>Item ID</th>
            <th>Item Pic</th>
            <th>Item Name</th>
            <th>Quantity</th>
						<th>Status</th>
          </tr>
          <?php
          //$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
          //$q="select detail.Order_ID, detail.Item_ID, detail.Quantity, rs_stock.Full_name
          //from detail INNER JOIN rs_stock ON detail.Item_ID=rs_stock.ID Where Order_ID=$ID";
          $q="select detail.*,rs_stock.* from detail,rs_stock where detail.Item_ID=rs_stock.ID and detail.Order_ID = $ID";
          $result=$objCon->query($q);
          if(!$result){
            echo "Select failed. Error: ".$objCon->error ;
          }
          $count = 0;
          while($row=$result->fetch_array()){?>
          <tr>
            <center>
                <td><?=$row['ID']?></td>
                <td><img src="<?=$row['Pic'] ?>" height="100" width="100"></td>
                <td><?=$row['Full_Name']?></td>
                <td><?=$row['Quantity']?></td>
								<td><?=$row['status']?></td>
            </center>
          </tr>
          <?php } ?>
        </table>
				<br>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
