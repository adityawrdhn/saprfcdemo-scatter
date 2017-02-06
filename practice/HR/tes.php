<head>
      
  <title>Check Material Availability - RFC</title>
  <link rel="stylesheet" href="../../css/sap_ai_sv.css" />
</head>
 
<body>
     <img src="../../images/sap_logo.gif"/>
     <h2>Check Material Availability</h2>
     <h4>RFC</h4>
     Please, enter the check criteria: <br />
     <form action="material_check.php" method="post">
           
     <table>
          <tr>
            <td>PLANT:</td><td><input type="text" name="plant" value="1000"/> (Example values: "1000")</td>
          </tr>
          <tr>
            <td>Material:</td><td><input type="text" name="material" value="100-100"/> (Example values: "100-100", "100-200")</td>
          </tr>
          <tr>
            <td>Unit</td><td><input type="text" name="unit" value="PC"/> (Example values: "PC")</td>
          </tr>   
          <tr>
            <td colspan="2" align="left"><input type="submit" name="submit" value="Check Availability"/> <input type="reset" name="reset" value="Reset Form"/></td>
          </tr>   
     </table>
     </form> <br />
     <a href="..">Back</a><br />
</body>
</html>[/code]
 
Now here is a script using RFC's to implement this example:
 
[code]<?php
function get_availability() {
    $conn = array (      "ASHOST" => "iwdf9453.wdf.sap.corp",
                      "SYSNR" => "50",
                      "CLIENT" => "800",
                      "USER" => "",     // Logon data obfuscated
                      "PASSWD" => "",    // Logon data obfuscated
                      "GWHOST" =>"iwdf9453.wdf.sap.corp",
                      "R3NAME" =>"DH3",
                      "LANG" =>"EN");
 
 
   // Set the input parameters of the function.
   $plant = $_POST["plant"];
   $material = $_POST["material"];
   $unit = $_POST["unit"];
 
   // Initialize SAPRFC library.
   $rfc = saprfc_open ($conn);
   if (! $rfc )
   {
       echo "RFC connection failed with error:".saprfc_error();
       exit;
   }
 
   // Get the function reference.
   $fce = saprfc_function_discover($rfc, "BAPI_MATERIAL_AVAILABILITY");
   if (! $fce )
   {
       echo "Discovering interface of function module RFC_READ_REPORT failed";
       exit;
   }
 
   // Set the input parameters.
   saprfc_import ($fce, "PLANT" ,$plant);
   saprfc_import ($fce, "MATERIAL" ,$material);
   saprfc_import ($fce, "UNIT" ,$unit);
 
   // Call the function.
   $rc = saprfc_call_and_receive ($fce);
 
   // Check for errors.
   if ($rc != SAPRFC_OK)
   {
       if ($rfc == SAPRFC_EXCEPTION )
           echo ("Exception raised: ".saprfc_exception($fce));
       else
           echo ("Call error: ".saprfc_error($fce));
       exit;
   }
    
   // Copy the result.
   $avqty = saprfc_export ($fce,"AV_QTY_PLT");
 
   // Close SAPRFC library.
   saprfc_function_free($fce);
   saprfc_close($rfc);
    
   // Display the result.
   return $avqty;
}
?>
[/code]
 
FWIW, here is the same functionality using ESA services:
 
[code]<?php
 
function get_availability() {
    $avqty = "0";
    $plant = $_POST["plant"];
    $material = $_POST["material"];
    $unit = $_POST["unit"];
    
    $client = new SoapClient( 'http://pwdf2814vmw3:53000/MaterialAvailabilityService/Config1?wsdl');
     
    try
    {
        $avqty = $client->getMaterialAvailability(array ('plant'=>$plant, 'material'=>$material, 'unit'=>$unit))->Response;
    }
    catch( SoapFault $e )
    {
        echo $e->faultstring;
    }
 
    return $avqty;
}
 
?>