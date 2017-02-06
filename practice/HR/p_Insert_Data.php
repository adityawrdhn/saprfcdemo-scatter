<?php
session_start();

	if(isset($_POST['submit']))
	{
		include_once("../../sap.php");
	    $sap = new SAPConnection();
	    $sap->Connect("../logon_data.conf");
	    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
	    if ($sap->GetStatus() != SAPRFC_OK ) {
	        $sap->PrintStatus();
	        exit;
	    }else{
	    }
 		$id = strtoupper($_POST['id']);
 		$nm = strtoupper($_POST['nama']);
		$value1 = $_POST['value1'];
		$value2 = $_POST['value2'];
		$fcex = &$sap->NewFunction("ZPD_GETDATA", array("IMPORT","GD_ID","$id"));
        if ($fcex == false ) {
            $sap->PrintStatus();
            exit;
        }
        $fcex->GD_ID = "$id";
        $fcex->Call();
        if ($fcex->GetStatus() == SAPRFC_OK) {
        	if ($fcex->COUNTID == 0) {
            	$fce = &$sap->NewFunction("ZPD_GETDATA");
        		if ($fce == false ) {
            		$sap->PrintStatus();
            		exit;
        		}
			    $fce->GD_IDS = "0";
			    $fce->Call();

			    if ($fce->GetStatus() == SAPRFC_OK) {
			        $fce->GD_TP_GETSTD->Reset();
			        $fce->GD_TP_GETSTD->Next();
			        $stdcompetency =  $fce->GD_TP_GETSTD->row["STDCOMP"];
			        $stdperformance =  $fce->GD_TP_GETSTD->row["STDPERF"];
			        if($value1>=$stdcompetency && $value2>=$stdperformance){
					   	$fce = &$sap->NewFunction("ZPD_INSERTDATA",
							  						array(array("IMPORT","GD_ID","$id"),
							   							  array("IMPORT","GD_NAME","$nm"),
							   							  array("IMPORT","GD_COMP","$value1"),
							   							  array("IMPORT","GD_PERF","$value2"),
							   							  array("IMPORT","GD_QUAD","Q1"))
							   						);
						if ($fce == false ) {
						    $sap->PrintStatus();
						    exit;
						}
						$fce->GD_ID = "$id";
						$fce->GD_NAME = "$nm";
						$fce->GD_COMP = "$value1";
						$fce->GD_PERF = "$value2";
						$fce->GD_QUAD = "Q1";
						$fce->ImportVars(); 
						$fce->Call();
					}
			 		elseif($value1<$stdcompetency && $value2>=$stdperformance){
			         	$fce = &$sap->NewFunction("ZPD_INSERTDATA",
						    						array(array("IMPORT","GD_ID","$id"),
			 			    							  array("IMPORT","GD_NAME","$nm"),
						    							  array("IMPORT","GD_COMP","$value1"),
						    							  array("IMPORT","GD_PERF","$value2"),
						    							  array("IMPORT","GD_QUAD","Q2"))
						    						);
						if ($fce == false ) {
						    $sap->PrintStatus();
						    exit;
						}
						$fce->GD_ID = "$id";
						$fce->GD_NAME = "$nm";
						$fce->GD_COMP = "$value1";
						$fce->GD_PERF = "$value2";
						$fce->GD_QUAD = "Q2";
						$fce->ImportVars(); 
						$fce->Call();
					}
					elseif($value1<$stdcompetency && $value2<$stdperformance){
				       	$fce = &$sap->NewFunction("ZPD_INSERTDATA",
							 						array(array("IMPORT","GD_ID","$id"),
							  							  array("IMPORT","GD_NAME","$nm"),
							   							  array("IMPORT","GD_COMP","$value1"),
							   							  array("IMPORT","GD_PERF","$value2"),
							   							  array("IMPORT","GD_QUAD","Q3"))
							   						);
						if ($fce == false ) {
						$sap->PrintStatus();
						    exit;
						}
						$fce->GD_ID = "$id";
						$fce->GD_NAME = "$nm";
						$fce->GD_COMP = "$value1";
						$fce->GD_PERF = "$value2";
						$fce->GD_QUAD = "Q3";
						$fce->ImportVars(); 
						$fce->Call();
					}
					elseif($value1>=$stdcompetency && $value2<$stdperformance){
					   	$fce = &$sap->NewFunction("ZPD_INSERTDATA",
							  						array(array("IMPORT","GD_ID","$id"),
							 							  array("IMPORT","GD_NAME","$nm"),
							  							  array("IMPORT","GD_COMP","$value1"),
							   							  array("IMPORT","GD_PERF","$value2"),
							   							  array("IMPORT","GD_QUAD","Q4"))
							   						);
						if ($fce == false ) {
						    $sap->PrintStatus();
						    exit;
						}
						$fce->GD_ID = "$id";
						$fce->GD_NAME = "$nm";
						$fce->GD_COMP = "$value1";
						$fce->GD_PERF = "$value2";
						$fce->GD_QUAD = "Q4";
						$fce->ImportVars(); 
						$fce->Call();
					}
			    }
		  	      	include("refresh.php");
			        $_SESSION['pesan'] = "<div class='alert alert-success alert-dismissable'>
				                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				                    <h4>  <i class='icon-check'></i> Alert!</h4>"."New Data Saved"."</div>";
   					echo '<script>window.location="index.php"</script>';
				                    // echo "id belum ada";
	        }else{
	            	$_SESSION['pesan'] = "<div class='alert alert-danger alert-dismissable'>
				                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				                    <h4>  <i class='icon-check'></i> Alert!</h4>"."Number ID is existing"."</div>";
   					echo '<script>window.history.back()</script>';
	        }
        }
	}

	elseif(isset($_POST['edit']))
	{
		
    		include_once("../../sap.php");
		    $sap = new SAPConnection();
		    $sap->Connect("../logon_data.conf");
		    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
		    if ($sap->GetStatus() != SAPRFC_OK ) {
		        $sap->PrintStatus();
		        exit;
		    }else{
		    }
		// echo "id="."$id";
		// $edit_id=array(); 
	 		$id= strtoupper($_POST["id"]);
			// $countcheck = count($id);
	 		$nm = strtoupper($_POST["nama"]);
	 		$value1 = $_POST["value1"];
			$value2 = $_POST["value2"];

 			// $edit_id=$id;
	 		$fce1 = $sap->NewFunction("ZPD_GETDATA", array("IMPORT","GD_ID","$id"));
            $fce1->GD_ID = "$id";
            // echo "gd-d=".$fce1->GD_ID;
            $fce1->Call();

            if ($fce1->GetStatus() == SAPRFC_OK) {
                $fce1->GD_TP_GETTPSTD->Reset();
                while ($fce1->GD_TP_GETTPSTD->Next()) {
                    $stdcompetency= $fce1->GD_TP_GETTPSTD->row["STDCOMP"];
                    $stdperformance= $fce1->GD_TP_GETTPSTD->row["STDPERF"];
					if($value1>=$stdcompetency && $value2>=$stdperformance){
			        	$fce = &$sap->NewFunction("ZPD_UPDATETP",
		    						array(array("IMPORT","UTP_ID","$id"),
		    							  array("IMPORT","UTP_NAME","$nm"),
		    							  array("IMPORT","UTP_COMP","$value1"),
		    							  array("IMPORT","UTP_PERF","$value2"),
		    							  array("IMPORT","UTP_QUAD","Q1")
		    							 )
		    					 	);
					    if ($fce == false ) {
					        $sap->PrintStatus();
					        exit;
					    }
					    $fce->UTP_ID = "$id";
					    $fce->UTP_NAME = "$nm";
					    $fce->UTP_COMP = "$value1";
					    $fce->UTP_PERF = "$value2";
					    $fce->UTP_QUAD = "Q1";
					    $fce->ImportVars();
					    $fce->Call(); // "0" => Get All User
					}
			 		elseif($value1<$stdcompetency && $value2>=$stdperformance){
			         	$fce = &$sap->NewFunction("ZPD_UPDATETP",
		    						array(array("IMPORT","UTP_ID","$id"),
		    							  array("IMPORT","UTP_NAME","$nm"),
		    							  array("IMPORT","UTP_COMP","$value1"),
		    							  array("IMPORT","UTP_PERF","$value2"),
		    							  array("IMPORT","UTP_QUAD","Q1")
		    							 )
		    					 	);
					    if ($fce == false ) {
					        $sap->PrintStatus();
					        exit;
					    }
					    $fce->UTP_ID = "$id";
					    $fce->UTP_NAME = "$nm";
					    $fce->UTP_COMP = "$value1";
					    $fce->UTP_PERF = "$value2";
					    $fce->UTP_QUAD = "Q1";
					    $fce->ImportVars();
					    $fce->Call(); // "0" => Get All User
			 		}
			 		elseif($value1<$stdcompetency && $value2<$stdperformance){
						$fce = &$sap->NewFunction("ZPD_UPDATETP",
		    						array(array("IMPORT","UTP_ID","$id"),
		    							  array("IMPORT","UTP_NAME","$nm"),
		    							  array("IMPORT","UTP_COMP","$value1"),
		    							  array("IMPORT","UTP_PERF","$value2"),
		    							  array("IMPORT","UTP_QUAD","Q1")
		    							 )
		    					 	);
					    if ($fce == false ) {
					        $sap->PrintStatus();
					        exit;
					    }
					    $fce->UTP_ID = "$id";
					    $fce->UTP_NAME = "$nm";
					    $fce->UTP_COMP = "$value1";
					    $fce->UTP_PERF = "$value2";
					    $fce->UTP_QUAD = "Q1";
					    $fce->ImportVars();
					    $fce->Call(); // "0" => Get All User
			 		}
			 		elseif($value1>=$stdcompetency && $value2<$stdperformance){
			         	$fce = &$sap->NewFunction("ZPD_UPDATETP",
		    						array(array("IMPORT","UTP_ID","$id"),
		    							  array("IMPORT","UTP_NAME","$nm"),
		    							  array("IMPORT","UTP_COMP","$value1"),
		    							  array("IMPORT","UTP_PERF","$value2"),
		    							  array("IMPORT","UTP_QUAD","Q1")
		    							 )
		    					 	);
					    if ($fce == false ) {
					        $sap->PrintStatus();
					        exit;
					    }
					    $fce->UTP_ID = "$id";
					    $fce->UTP_NAME = "$nm";
					    $fce->UTP_COMP = "$value1";
					    $fce->UTP_PERF = "$value2";
					    $fce->UTP_QUAD = "Q1";
					    $fce->ImportVars();
					    $fce->Call(); // "0" => Get All User
				    }
				}
 			    include("refresh.php");
				$_SESSION['pesan'] = "<div class='alert alert-success alert-dismissable'>
				                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				                    <h4>  <i class='icon-check'></i> Alert!</h4>"."Update Succeed"."</div>";
				echo '<script>window.location="index.php"</script>';
			}	
	}
 			
	
?>
