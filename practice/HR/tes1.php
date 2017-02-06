        <?php 
                                        include_once("../../sap.php");
                                $sap = new SAPConnection();
                                $sap->Connect("../logon_data.conf");
                                if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
                                if ($sap->GetStatus() != SAPRFC_OK ) {
                                   $sap->PrintStatus();
                                   exit;
                                }else{
                                      // echo "Login succeed.";
                                }
                                $fce = &$sap->NewFunction("ZPD_GETDATA");
                                if ($fce == false ) {
                                   $sap->PrintStatus();
                                   exit;
                                }
                                $fce->GD_IDS = "0";
                                $fce->Call(); // "0" => Get All User
                                 // "0" => Get All User
                                if ($fce->GetStatus() == SAPRFC_OK) {
                                    $fce->GD_TP_GETSTD->Reset();
                                    $fce->GD_TP_GETSTD->Next();
                                    //   $name= $fce->GD_TP->row["NAME"];
                                      $colstd =  $fce->GD_TP_GETSTD->row["STDCOMP"];
                                    }
                                    echo "$colstd";
                                

                                    ?>

