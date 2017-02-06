<?php
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
      $fce = &$sap->NewFunction("ZPD_GETDATA",array("IMPORT","GD_ID","$id"));
      if ($fce == false ) {
          $sap->PrintStatus();
          exit;
      }
      $fce->GD_ID = "$id";
      $fce->Call(); // "0" => Get All User
      if ($fce->GetStatus() == SAPRFC_OK) {
          $fce->GD_TP_GETBYID->Reset();
          while($fce->GD_TP_GETBYID->Next()){
?>
          <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to delete <?php echo $fce->GD_TP_GETBYID->row['NAME'];?></h4>
              </div>
                        
              <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="proses_delete.php?id=<?php echo $fce->GD_TP_GETBYID->row['ID'];?>" class="btn btn-outline" id="delete_link">Delete</a>
              </div>
            </div>
          </div>
  <?php }} ?>