<?php
  require_once('connect.php');
  if(!isset($_SESSION['ugroup'])){
    header("Location: login.php");
  }
  if($_SESSION['ugroup']==2){
    header("Location: index2.php");
  }

  $qq="DROP TABLE `bkd_as&r`, `bkd_bg`, `bkd_cco`, `bkd_com&av`, `bkd_fin`,
	`bkd_ict`, `bkd_mt`, `bkd_od`, `bkd_pm`, `bkd_sa&ar`, `bkd_sp`, `bkd_stock`, `detail`, `history`, `imbkd`, `import_detail`, `import_list`,
	`imrs`, `item`, `rs_acc`, `rs_ad&pr`, `rs_as&r`, `rs_bcet`, `rs_bg`, `rs_cco`, `rs_cet`, `rs_cgs`, `rs_com&av`, `rs_fin`, `rs_ia&cr`, `rs_lib`,
	`rs_msme`, `rs_od`, `rs_r&qa`, `rs_sa&ar`, `rs_sp`, `rs_stock`, `user`;";
  $result1=$objCon->query($qq);
  if(!$result1){
    echo "Delete failed. Error: ".$objCon->error ;
  }
  mysqli_set_charset($objCon ,"utf8");
  $query = '';
  $sqlScript = file('SQL/OMIS-Update2.sql');
  foreach ($sqlScript as $line)	{

  	$startWith = substr(trim($line), 0 ,2);
  	$endWith = substr(trim($line), -1 ,1);

  	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
  		continue;
  	}

  	$query = $query . $line;
  	if ($endWith == ';') {
  		mysqli_query($objCon,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
  		$query= '';
  	}
  }
  echo '<div class="success-response sql-import-response">SQL file imported successfully</div>';
  header("refresh: 5; url=index.php");
?>
