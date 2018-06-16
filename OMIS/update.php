<?php
ob_start();
session_start();
if(!isset($_SESSION['ugroup'])){
  header("Location: login.php");
}
if($_SESSION['ugroup']==1){
  header("Location: index.php");
}
  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
  {
	  if($_SESSION["strProductID"][$i] != "")
	  {
      //กรณีกรณีแรก แก้ไขเกินลิมิต/เท่า set ค่าเท่าลิมิต
      if( intval($_POST["txtQty".$i]) >= intval($_SESSION["MAX"][$i]) )
      {
        $_SESSION["strQty"][$i] = intval($_SESSION["MAX"][$i]);
        $_SESSION["canGetMore"][$i] = 0;
        echo "<br>";
        echo "case 1 exceed limit";
        echo "<br>";
        //break;
      }
      elseif( intval($_POST["txtQty".$i]) < intval($_SESSION["MAX"][$i]) )//&& intval($_POST["txtQty".$i]) < intval($_SESSION["strQty1"][$i]) )
      { //ค่าเดิมมากกว่าค่าใหม่
        $_SESSION["strQty"][$i] = $_POST["txtQty".$i];
        $_SESSION["canGetMore"][$i] = intval($_SESSION["MAX"][$i]) - intval($_POST["txtQty".$i]);
        echo "case 2 not exceed limit";
        echo "<br>";
        echo intval($_SESSION["MAX"][$i]) - $_POST["txtQty".$i];
        echo "<br>";
        //break;
      }else
      {
        break;
      }

	  }
  }
header("Location: show2.php");

?>
