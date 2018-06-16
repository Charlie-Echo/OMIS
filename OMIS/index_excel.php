<?php
require_once('connect.php');
if(!isset($_SESSION['ugroup'])){
  header("Location: login.php");
}
if($_SESSION['ugroup']==2){
  header("Location: index2.php");
}
$branch = $_SESSION['ubranch'];

$perpage = 25;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}
else {
  $page = 1;
}
$start = ($page - 1) * $perpage;
$strExcelFileName="รายการคงคลัง-".$_SESSION['branchfullname']."-หน้า".$page."-".date('d/M/Y').".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
  <table id="tb0">
    <tr>
      <th><center>ลำดับที่</center></th>
      <th><center>รหัส</center></th>
      <th><center>รายการ</center></th>
      <th><center>คงเหลือ</center></th>
      <th><center>ราคา(บ.)</center></th>
      <th><center>ราคารวมVAT(7%, บ.)</center></th>
      <th><center>ราคาสุทธิ(บ.)</center></th>
    </tr>
    <?php
    $finalprice = 0;
    $q="select * from $branch limit $start , $perpage";
    $result=$objCon->query($q);
    if(!$result){
      echo "Select failed. Error: ".$objCon->error ;
    }

    while($row=$result->fetch_array()){
      $ID = $row['ID'];
      $qq="select detail.CostPerUnit from detail, history where detail.Type = 3 AND history.Type = 3 AND history.From_stock = '$branch' AND detail.Item_ID = $ID AND detail.Order_ID = history.ID ORDER BY Detail_ID DESC LIMIT 1";
      $result1=$objCon->query($qq);
      if(!$result1){
        echo "Select failed. Error: ".$objCon->error ;
      }
      $row1=$result1->fetch_array();
      //echo($row1['CostPerUnit'])
      $sql2 = "select * from $branch ";
      $query2 = mysqli_query($objCon, $sql2);
      $total_record = mysqli_num_rows($query2);
      $total_page = ceil($total_record / $perpage);
      ?>
      <tr>
        <center>
          <form action="haha.php" method="post">
            <td><center><?=$row['ID']?></center></td>
            <td><center><?=$row['Code']?></center></td>
            <td><?=$row['Full_Name']?></td>
            <td><center><?php echo($row['QLeft']." ".$row['Unit']);?></center></td>
            <td><center><?php echo(number_format($row1['CostPerUnit'],2));?></center></td>
            <td><center><?php echo(number_format($row1['CostPerUnit']*1.07,2));?></center></td>
            <td>
              <center>
                <?php
                echo(number_format($row1['CostPerUnit']*(1.07*$row['QLeft']),2));
                $finalprice += $row1['CostPerUnit']*(1.07*$row['QLeft']);
                ?>
              </center>
            </td>
          </form>
        </center>
      </tr>
    <?php } ?>
  </table>
  <br>
  <div align="right"><b><u>ราคาสุทธิ(หน้านี้):</u></b> <?php echo number_format($finalprice,2) ; ?> บาท</div>

</body>
<script>
window.onbeforeunload = function(){return false;};
setTimeout(function(){window.close();}, 10000);
</script>
</html>
