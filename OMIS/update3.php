<?php
ob_start();
session_start();
if(!isset($_SESSION['ugroup'])){
  header("Location: login.php");
}
if($_SESSION['ugroup']==1){
  header("Location: index.php");
}
  for($i=0;$i<=(int)$_SESSION["intLine1"];$i++)
  {
	  if($_SESSION["strProductID1"][$i] != "")
	  {
			//$_SESSION["strQty1"][$i] = $_POST["txtQty".$i];
      echo "<br>";
      echo "ได้อีก ".$_SESSION["canGetMore1"][$i];
      echo "<br>";
      echo "ค่าเดิม ".$_SESSION["strQty1"][$i];
      echo "<br>";
      echo "ค่าที่จะอัพเดต ".$_POST["txtQty".$i];
      echo "<br>";
      echo "MAX1 ".$_SESSION["MAX1"][$i];
      echo "<br>";

      //กรณีกรณีแรก แก้ไขเกินลิมิต/เท่า set ค่าเท่าลิมิต
      if( intval($_POST["txtQty".$i]) >= intval($_SESSION["MAX1"][$i]) )
      {
        $_SESSION["strQty1"][$i] = intval($_SESSION["MAX1"][$i]);
        $_SESSION["canGetMore1"][$i] = 0;
        echo "<br>";
        echo "case 1 exceed limit";
        echo "<br>";
        //break;
      }
      elseif( intval($_POST["txtQty".$i]) < intval($_SESSION["MAX1"][$i]) )//&& intval($_POST["txtQty".$i]) < intval($_SESSION["strQty1"][$i]) )
      { //ค่าเดิมมากกว่าค่าใหม่
        $_SESSION["strQty1"][$i] = $_POST["txtQty".$i];
        $_SESSION["canGetMore1"][$i] = intval($_SESSION["MAX1"][$i]) - intval($_POST["txtQty".$i]);
        echo "case 2 not exceed limit";
        echo "<br>";
        echo intval($_SESSION["MAX1"][$i]) - $_POST["txtQty".$i];
        echo "<br>";
        //break;
      }else
      {
        break;
      }

	  }
  }
header("Location: show3.php");

?>
