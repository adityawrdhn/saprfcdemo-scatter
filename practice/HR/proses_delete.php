
<?php
	// include "koneksi.php";

	  include_once("../../sap.php");
      $sap = new SAPConnection();
      $sap->Connect("../logon_data.conf");
      if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
      if ($sap->GetStatus() != SAPRFC_OK ) {
          $sap->PrintStatus();
          exit;
      }else{
      }
      $id=$_GET['id'];
      $fce = &$sap->NewFunction("ZPD_DELTP",array("IMPORT","DEL_ID","$id"));
      if ($fce == false ) {
          $sap->PrintStatus();
          exit;
      }
      $fce->DEL_ID = "$id";
	  $fce->ImportVars(); 
      $fce->Call();
      include("refresh.php");
$_SESSION['pesan'] = "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h4>  <i class='icon-check'></i> Alert!</h4>"."Data Deleted"."</div>";
            echo '<script>window.history.back()</script>';// echo '<script>window.location="index.php"</script>';
?>

