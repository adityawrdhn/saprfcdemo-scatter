<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

  <title>Talent Pool | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="plugins/iCheck/flat/blue.css"> -->
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="plugins/iCheck/all.css">


  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- <link rel="stylesheet" href="asset/css/style.css"/> -->
  <!--  -->
  
  <script src="assets/js/jquery-1.10.1.min.js"></script>
</head>

<body>





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
  $search = strtoupper($_POST['search']);
  $output = '';  
  $fce = &$sap->NewFunction("ZPD_SEARCHDATA",array("IMPORT","SD_NAME","$search"));
  if ($fce == false ) {
      $sap->PrintStatus();
      exit;
  }
  $fce->SD_NAME = "$search";
  $fce->ImportVars(); 
  $fce->Call();
  if ($fce->GetStatus() == SAPRFC_OK) {
    
    
?>
      <h4 align="center">Search Result</h4>
      <?php echo $fce->COUNT1; ?> results
      
      <table   class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="10%">ID</th>
            <th width="40%">Name</th>
            <th width="10%">Competency</th>
            <th width="10%">Performances</th>
            <th width="10%">Quadran</th>
            <th width="20%">
              <a class="btn btn-social btn-xs btn-block btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#Modaladd">
                <i class="fa fa-user-plus"></i> Add New Data
              </a>                  
            </th>
          </tr>
        </thead>
        <tbody>

<?php
    // if ($fce->GD_TP_SEARCH) {
    $fce->GD_TP_SEARCH->Reset();
    while($fce->GD_TP_SEARCH->Next()){
?>
          <tr>
            <td><?php echo $fce->GD_TP_SEARCH->row["ID"] ?></td>
            <td><?php echo $fce->GD_TP_SEARCH->row["NAME"] ?></td>
            <td><?php echo $fce->GD_TP_SEARCH->row["COMPETENCY"] ?></td>
            <td><?php echo $fce->GD_TP_SEARCH->row["PERFORMANCE"] ?></td>
            <td><?php echo $fce->GD_TP_SEARCH->row["QUADRAN"] ?></td>
            <td>
              <a class="btn btn-xs btn-social btn-instagram modal_edit1 btn-flat" data-toggle="modal" data-id="<?php echo $fce->GD_TP_SEARCH->row['ID'] ?>" href="#ModalEdit1<?php echo $fce->GD_TP_SEARCH->row['ID'] ?>">
                <i class="fa fa-edit"></i> Edit
              </a>
              <a class="btn btn-xs btn-social btn-google delete_modal1 btn-flat" data-toggle="modal" data-id="<?php echo $fce->GD_TP_SEARCH->row['ID'] ?>" href="#ModalDelete1<?php echo $fce->GD_TP_SEARCH->row['ID'] ?>">
                <i class="fa fa-trash"></i> Delete
              </a>
            </td>
          </tr>
<?php }?>
</tbody></table>


<h4 align="center">All Data</h4>

<?php } 
?> 


<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->

<script src="dist/js/demo.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
   $(document).ready(function () {
   $(".modal_edit1").click(function(e) {
      // var m = $(this).attr("id");
       $.ajax({
             url: "modal_edit.php",
             type: "GET",
             data : {id:$(this).attr('data-id')},
             success: function (ajaxData){
               $("#ModalEdit1").html(ajaxData);
               $("#ModalEdit1").modal('show',{backdrop: 'true'});
             }
           });
        });
    $(".delete_modal1").click(function(e) {
      // var m = $(this).attr("id");
       $.ajax({
             url: "modal_delete.php",
             type: "GET",
             data : {id:$(this).attr('data-id')},
             success: function (ajaxData){
               $("#ModalDelete1").html(ajaxData);
               $("#ModalDelete1").modal('show',{backdrop: 'true'});
             }
           });
        });


      });

</script>
</body>
</html>
<?php 
class StopWatch { 
    public $total; 
    public $time; 
    
    public function __construct() { 
        $this->total = $this->time = microtime(true); 
    } 
    
    public function clock() { 
        return -$this->time + ($this->time = microtime(true)); 
    } 
    
    public function elapsed() { 
        return microtime(true) - $this->total; 
    } 
    
    public function reset() { 
        $this->total=$this->time=microtime(true); 
    } 
} 
?>