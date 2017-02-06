
          <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="p_Insert_Data.php">

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


                        $getID = $_REQUEST['id'];
                        $fce0 = &$sap->NewFunction("ZPD_GETDATA", array("IMPORT","GD_ID","$getID"));
                        if ($fce0 == false ) {
                            $sap->PrintStatus();
                            exit;
                        }
                        $fce0->GD_ID = "$getID";
                        $fce0->Call(); // 
                        if ($fce0->GetStatus() == SAPRFC_OK) {
                            $fce0->GD_TP_GETBYID->Reset();
                            $fce0->GD_TP_GETBYID->Next();
                            
                        ?>


                                <div class="modal-body">
                                  
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama</label>

                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="id" value="<?php echo $fce0->GD_TP_GETBYID->row['ID'] ?>" readonly="true" required/>
                                    </div>
                                  </div><!-- <input type="text" class="form-control" name="hdnline" value="<?php echo "$i"."dan"."$id";?>"/> -->
                                      
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama</label>

                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="nama" value="<?php echo $fce0->GD_TP_GETBYID->row['NAME'] ?>" required/>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label  class="col-sm-2 control-label">Competency</label>

                                    <div class="col-sm-10">
                                      <input type="number" class="form-control" name="value1" value="<?php echo $fce0->GD_TP_GETBYID->row['COMPETENCY'] ?>" required/>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label  class="col-sm-2 control-label">Performance</label>

                                    <div class="col-sm-10">
                                      <input type="number" class="form-control" name="value2" value="<?php echo $fce0->GD_TP_GETBYID->row['PERFORMANCE'] ?>" required/>
                                    </div>
                                  </div>

                                  
                                </div>

                    <?php }?>
                                <div class="modal-footer"  style="margin:0px; border-top:0px; text-align:center;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="simpan btn btn-outline">Save changes</button>
                                      <!-- <input type="hidden" class="form-control" name="hdnline" value="<?php echo $i;?>"/> -->
                    
                    </div>
                    </form>

                        <!-- </form> -->
                    
                </div>
            </div>
