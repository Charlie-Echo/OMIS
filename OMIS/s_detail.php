<?php
	require_once('connect.php');
	date_default_timezone_set("Asia/Bangkok");
	//session_start();
  if(!isset($_SESSION['ugroup'])){
    header("Location: login.php");
  }
  if($_SESSION['ugroup']==1){
    header("Location: index.php");
  }
  if($_SESSION['supervisor']!='none'){
    header("Location: index2.php");
  }
	$ID = $_GET["ID"];
	$branch = $_SESSION['ubranch'];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  		<title>SIIT Office Material Inventory System</title>
  		<style>
			tx {
				color: white;
			}
		</style>
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
        <li><a class="active" href="supervisor_check.php">ยืนยันการเบิก</a></li>
				<li style="float:right"><a href="logout.php">LOGOUT</a></li>
				<li style="float:right"><a>ยินดีต้อนรับสู่คลัง: <?php echo $_SESSION['branchfullname']; ?> </b></a></li>
			</ul>
		</div>
		<div id="div_main">
			<div id="div_content">
				<table id="tb0">
				  <tr>
						<th><center>ภาพ</center></th>
						<th><center>รายการ</center></th>
						<th><center>จำนวน</center></th>
						<th><center>สถานะ</center></th>
				  </tr>
				  <?php
				  //$q="select Location,Pic,Type,Name,Unit,SUM(Stock) AS SumS from stock group by Name,Location order by Type";
				  //$q="select detail.Order_ID, detail.Item_ID, detail.Quantity, rs_stock.Full_name
				  //from detail INNER JOIN rs_stock ON detail.Item_ID=rs_stock.ID Where Order_ID=$ID";
				  $q="select item.Pic, item.Full_Name, detail.Quantity, detail.status from detail,item where detail.Item_ID=item.ID and detail.Order_ID = $ID ";
				  $result=$objCon->query($q);
				  if(!$result){
					echo "Select failed. Error: ".$objCon->error ;
				  }
				  $count = 0;
				  while($row=$result->fetch_array()){?>
				  <tr>
					<center>
						<td><center><img src="<?=$row['Pic'] ?>" height="100" width="100"></center></td>
						<td><?=$row['Full_Name']?></td>
						<td><center><?=$row['Quantity']?></center></td>
						<td><center><?=$row['status']?></center></td>
					</center>
				  </tr>
				  <?php } ?>
				</table>
				<br>
				<?php
					$q="select note from history where ID = $ID";
					$result=$objCon->query($q);
					if(!$result){
						echo "Select failed. Error: ".$objCon->error ;
					}
					while($row=$result->fetch_array()){?>
						<table id="tb0">
							<tr>
								<th width="90">Note:</th><td><center><?=$row['note']?><br></center></td>
							</tr>
						</table>
					<?php } ?>
          <br>
          <center>
						<?php
							if(date("l")=="AAAA")
							{ ?>
								ไม่สามารถทำรายการในวันพุธเวลา 00.00 - 23.59
								<br>
								<br>
								<a class="button1" href="supervisor_check.php">ย้อนกลับ</a>
							<?php }else { ?>
								<a class="button1" href="supervisor_check.php">ย้อนกลับ</a> |
								<a class="button1" href="s_rej.php?ID=<?=$ID?>">ไม่อนุมัติ</a> |
								<a class="button1" href="s_gen.php?ID=<?=$ID?>">อนุมัติ</a>
							<?php } ?>
          </center>
			</div> <!-- end div_content -->
		</div> <!-- end div_main -->
	</body>
</div>
</html>
