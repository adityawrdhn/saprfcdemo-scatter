<?php
    $con=mysqli_connect("localhost", "root" ,"","dbline");
    $reset= "TRUNCATE TABLE TALENT_POOL";
    $query=mysqli_query($con, $reset) or die("index.php: delete data");
	include_once("../../sap.php");
	$sap = new SAPConnection();
	$sap->Connect("../logon_data.conf");
	if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
	if ($sap->GetStatus() != SAPRFC_OK ) {
	    $sap->PrintStatus();
	    exit;
	}else{
	}
 	$fce = &$sap->NewFunction("ZPD_GETDATA");
    if ($fce == false ) {
        $sap->PrintStatus();
        exit;
    }
    $fce->Call();
    if ($fce->GetStatus() == SAPRFC_OK) {
        $fce->GD_TP->Reset();
        while ($fce->GD_TP->Next()) {
        	$id=$fce->GD_TP->row["ID"];
        	$nm=$fce->GD_TP->row["NAME"];
        	$value1=$fce->GD_TP->row["COMPETENCY"];
        	$value2=$fce->GD_TP->row["PERFORMANCE"];
        	$fce1 = &$sap->NewFunction("ZPD_GETDATA");
        	if ($fce == false ) {
            	$sap->PrintStatus();
            	exit;
        	}
			$fce1->GD_IDS = "0";
			$fce1->Call();
			if ($fce1->GetStatus() == SAPRFC_OK) {
			    $fce1->GD_TP_GETSTD->Reset();
			    $fce1->GD_TP_GETSTD->Next();
			    $stdcompetency =  $fce1->GD_TP_GETSTD->row["STDCOMP"];
			    $stdperformance =  $fce1->GD_TP_GETSTD->row["STDPERF"];
        		if($value1>=$stdcompetency && $value2>=$stdperformance){
	        		$sql = "INSERT INTO talent_pool(id, nama, value1, value2, quadran) VALUES ('$id','$nm','$value1','$value2','Q1')";
	        		$retval = mysqli_query($con, $sql);
				}
		 		elseif($value1<$stdcompetency && $value2>=$stdperformance){
		         	$sql = "INSERT INTO talent_pool(id, nama, value1, value2, quadran) VALUES ('$id','$nm','$value1','$value2','Q2')" ;
		         	$retval = mysqli_query($con, $sql);
		 		}
		 		elseif($value1<$stdcompetency && $value2<$stdperformance){
		         	$sql = "INSERT INTO talent_pool(id, nama, value1, value2, quadran) VALUES ('$id','$nm','$value1','$value2','Q3')";
		         	$retval = mysqli_query($con, $sql);
		 		}
		 		elseif($value1>=$stdcompetency && $value2<$stdperformance){
		         	$sql = "INSERT INTO talent_pool(id, nama, value1, value2, quadran) VALUES ('$id','$nm','$value1','$value2','Q4')" ;
		         	$retval = mysqli_query($con, $sql);
		 		}
        	}
        }
        $_SESSION['pesan'] = "<div class='alert alert-success alert-dismissable'>
				              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				              <h4>  <i class='icon-check'></i> Alert!</h4>"."Data refreshed"."</div>";
	    echo '<script>window.location="index.php"</script>';
    }
   	mysqli_close($con);
?>


