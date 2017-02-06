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
    $vc = $_POST['valuec'];
	$vp = $_POST['valuep'];

    $fce = &$sap->NewFunction("ZPD_UPDATEDATA",
    						array(array("IMPORT","UD_SC","$vc"),
    							array("IMPORT","UD_SP","$vp"))
    						);
    if ($fce == false ) {
        $sap->PrintStatus();
        exit;
    }
    if($vc==null && $vp==null){
	 	$_SESSION['pesan'] = "<div class='alert alert-warning alert-dismissable'>
	            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	            <h4>  <i class='icon-check'></i> Alert!</h4>"."No Data Changed"."</div>";
		echo '<script>window.history.back()</script>';
    }else{
		if ($vc==null && $vp==!null) {
			$fce = &$sap->NewFunction("ZPD_UPDATEDATA",
			    						array("IMPORT","UD_SP","$vp")
			    					 );
		    if ($fce == false ) {
		        $sap->PrintStatus();
		        exit;
		    }
		    $fce->UD_IDS = "1234";
		    // $fce->UD_SC = "$vc";
		    $fce->UD_SP = "$vp";
		    $fce->ImportVars();
		    $fce->Call(); // "0" => Get All User
	    }elseif ($vp==null && $vc==!null) {
			$fce = &$sap->NewFunction("ZPD_UPDATEDATA",
			    						array("IMPORT","UD_SC","$vc")
			    					 );
		    if ($fce == false ) {
		        $sap->PrintStatus();
		        exit;
		    }
		    $fce->UD_IDS = "1234";
		    $fce->UD_SC = "$vc";
		    $fce->ImportVars();
		    $fce->Call(); // "0" => Get All User
		}elseif ($vc==!null && $vp==!null){
			$fce = &$sap->NewFunction("ZPD_UPDATEDATA",
		    						array(array("IMPORT","UD_SC","$vc"),
		    							array("IMPORT","UD_SP","$vp"))
		    						);
		    if ($fce == false ) {
		        $sap->PrintStatus();
		        exit;
		    }
		    $fce->UD_IDS = "1234";
		    $fce->UD_SC = "$vc";
		    $fce->UD_SP = "$vp";
		    $fce->ImportVars(); 
			$fce->Call(); // "0" => Get All User
	    }

		include("refresh.php");
		$_SESSION['pesan'] = "<div class='alert alert-success alert-dismissable'>
		                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		                    <h4>  <i class='icon-check'></i> Alert!</h4>"."Update Succeed"."</div>";
		echo '<script>window.location="index.php"</script>';
		
    }//end of vc & vp = null
}
elseif(isset($_POST['download']))
{
    require_once "Excel.class.php";
	 
	$mysqli = new mysqli("localhost","root","","dbline");
	if ($mysqli->connect_error) {
	    die('Connect Error (' . $mysqli->connect_error . ') ');
	}
	#akhir koneksi
	 
	#ambil data
	$query = "SELECT * FROM talent_pool";
	$sql = $mysqli->query($query);
	$arrmhs = array();
	while ($row = $sql->fetch_assoc()) {
		array_push($arrmhs, $row);
	}
	#akhir data
	 
	$excel = new Excel();
	#Send Header
	$excel->setHeader('Data-Talent-Pool.xls');
	$excel->BOF();
	 
	#header tabel
	$excel->writeLabel(0, 0, "ID");
	$excel->writeLabel(0, 1, "Nama");
	$excel->writeLabel(0, 2, "Competency");
	$excel->writeLabel(0, 3, "Performance");
	$excel->writeLabel(0, 4, "Quadran");

	#isi data
	$i = 1;
	foreach ($arrmhs as $baris) {
		$j = 0;
		foreach ($baris as $value) {
			$excel->writeLabel($i, $j, $value);
			$j++;
		}
		$i++;
	}
	 
	$excel->EOF();
	 
	exit();
	$_SESSION['pesan'] = 'Cetak Berhasil';
    echo '<script>window.location.reload()</script>';
	mysqli_close($con);
}
?>