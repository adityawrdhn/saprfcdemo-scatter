<!-- Update 4:15 PM 8/2/2016 -->
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


   <script type="text/javascript">
      $(document).ready(function() {
                var dataTable = $('#example2').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "autoWidth":false,
                    // "scrollX":true,
                    // "scrollY": "200px",
                    // "scrollCollapse": true,
                    // "paging": false,
                    // "scrollX":false,
                    // "columnDefs": [ {
                    //       "targets": 0,
                    //       "orderable": false,
                    //       "searchable": false
                           
                    //     } ],
                    "ajax":{
                        url :"example2.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                            $(".example2-error").html("");
                            $("#example2").append('<tbody class="example2-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#example2_processing").css("display","none");
                            
                        }
                    }
                });

                
                $("#bulkDelete").on('click',function() { // bulk checked
                    var status = this.checked;
                    $(".deleteRow").each( function() {
                        $(this).prop("checked",status);
                    });
                });
                
                $('#deleteTriger').on("click", function(event){
                    // triggering delete one by one
                    $('input[type="checkbox"].flat-red.deleteRow:checked').iCheck({
                                  checkboxClass: 'icheckbox_flat-red',
                                  radioClass: 'iradio_flat-red'
                    });
                    if( $('.deleteRow:checked').length > 0 ){  // at-least one checkbox checked
                        var ids = [];
                        $('.deleteRow').each(function(){
                            if($(this).is(':checked')) {
                                ids.push($(this).val());
                            }
                        });
                        var ids_string = ids.toString();  // array to string conversion 
                        $.ajax({
                            type: "POST",
                            url: "proses_delete.php",
                            data: {data_ids:ids_string},
                            // success: function(result) {
                            //     dataTable.draw(); // redrawing datatable
                            // },
                            success: function(response){

                                response = parseInt(response);

                                $("#ModalDelete").modal('hide'); 

                                switch (response){

                                case 1:
                                    $("#pesan").text('Unauthorised access'); // create a error div somewhere in ur html page for this
                                break;

                                case 2:
                                    $("#pesan").text('Records deleted successfully.');
                                break;

                                case 3:
                                    $("#pesan").text('Something wrong. Please try again.');
                                break;
                                }

                                window.location.reload();
                            }
                        });
                    }
                });
                $('#EditTriger').on("click", function(event){ // triggering delete one by one
                    if( $('.editRow:checked').length > 0 ){  // at-least one checkbox checked
                        var ids = [];
                        $('.editRow').each(function(){
                            if($(this).is(':checked')) { 
                                ids.push($(this).val());
                            }
                        });
                        $('.editRow input[type="checkbox"]').iCheck({
                          checkboxClass: 'icheckbox_flat-blue',
                          radioClass: 'iradio_flat-blue'
                        });
                        var ids_string = ids.toString();  // array to string conversion 
                        $.ajax({
                            type: "POST",
                            url: "modal_edit.php",
                            data: {data_ids:ids_string},
                            // success: function(result) {
                            //     dataTable.draw(); // redrawing datatable
                            // },
                            success: function (ajaxData){
                                $("#ModalEdit").html(ajaxData);
                                $("#ModalEdit").modal('show',{backdrop: 'true'});
                            }
                            // success: function(response){

                            //     response = parseInt(response);

                            //     $("#ModalEdit").modal('show'); 

                            //     window.location.reload();
                            // }
                        });
                    }
                }); 
        } );

    $(function () {
        // $("#example2").DataTable();
         $('#example1').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": true,
          "scrollY":330,
          "scrollCollapse":false,

        });
        
    });
    $(function () {
       function draggablePlotLine(axis, plotLineId) {
                var clickX,clickY;

                var getPlotLine = function () {
                    for (var i = 0; i < axis.plotLinesAndBands.length; i++) {
                        if (axis.plotLinesAndBands[i].id === plotLineId) {
                            return axis.plotLinesAndBands[i];
                        }
                    }
                };
                
                var getValue = function() {
                    var plotLine = getPlotLine();
                    var translation = axis.horiz ? plotLine.svgElem.translateX : plotLine.svgElem.translateY;
                    var new_value = axis.toValue(translation) - axis.toValue(0) + plotLine.options.value;
                    new_value = parseInt(Math.max(axis.min, Math.min(axis.max, new_value)));
                    // parseInt(c);
                    return new_value;
                };

                var drag_start = function (e) {
                    $(document).bind({
                        'mousemove.line': drag_step,
                            'mouseup.line': drag_stop
                    });

                    var plotLine = getPlotLine();
                    clickX = e.pageX - plotLine.svgElem.translateX;
                    clickY = e.pageY - plotLine.svgElem.translateY;
                    if (plotLine.options.onDragStart) {
                        plotLine.options.onDragStart(getValue());
                    }
                };

                var drag_step = function (e) {
                    var plotLine = getPlotLine();
                    var new_translation = axis.horiz ? e.pageX - clickX : e.pageY - clickY;
                    var new_value = axis.toValue(new_translation) - axis.toValue(0) + plotLine.options.value;
                    new_value = Math.max(axis.min, Math.min(axis.max, new_value));
                    new_translation = axis.toPixels(new_value + axis.toValue(0) - plotLine.options.value);
                    plotLine.svgElem.translate(
                        axis.horiz ? new_translation : 0,
                        axis.horiz ? 0 : new_translation);

                    if (plotLine.options.onDragChange) {
                        plotLine.options.onDragChange(new_value);
                    }
                };

                var drag_stop = function () {
                    $(document).unbind('.line');

                    var plotLine = getPlotLine();
                    var plotLineOptions = plotLine.options;
                    //Remove + Re-insert plot line
                    //Otherwise it gets messed up when chart is resized
                    if (plotLine.svgElem.hasOwnProperty('translateX')) { // IF plotline(translateX) then
                        plotLineOptions.value = getValue()               // plotlines.value = getValue()
                        axis.removePlotLine(plotLineOptions.id);         // axis.removePlotLine(plotLineOptions.id);
                        axis.addPlotLine(plotLineOptions);               // axis.addPlotLine(plotLineOptions)

                        if (plotLineOptions.onDragFinish) {               //  IF (plotLineOptions.onDragFinish) THEN
                            plotLineOptions.onDragFinish(plotLineOptions.value); //plotLineOptions.onDragFinish(plotLineOptions.value)
                        }
                    }

                    getPlotLine().svgElem
                        .css({'cursor': 'pointer'})
                        .translate(0, 0)
                        .on('mousedown', drag_start);
                };
                drag_stop();
            }
                        function toast(chart, text) {
                chart.toast = chart.renderer.label(text, 100, 120)
                    .attr({
                        fill: Highcharts.getOptions().colors[0],
                        padding: 10,
                        r: 5,
                        zIndex: 8
                    })
                    .css({
                        color: '#FFFFFF'
                    })
                    .add();

                setTimeout(function () {
                    chart.toast.fadeOut();
                }, 2000);
                setTimeout(function () {
                    chart.toast = chart.toast.destroy();
                }, 2500);
            }

            /**
             * Custom selection handler that selects points and cancels the default zoom behaviour
             */
            function selectPointsByDrag(e) {

                // Select points
                Highcharts.each(this.series, function (series) {
                    Highcharts.each(series.points, function (point) {
                        if (point.x >= e.xAxis[0].min && point.x <= e.xAxis[0].max &&
                                point.y >= e.yAxis[0].min && point.y <= e.yAxis[0].max) {
                            point.select(true, true);
                        }
                    });
                });

                // Fire a custom event
                Highcharts.fireEvent(this, 'selectedpoints', { points: this.getSelectedPoints() });

                return false; // Don't zoom
            }

            /**
             * The handler for a custom event, fired from selection event
             */
            function selectedPoints(e) {
                // Show a label
                toast(this, '<b>' + e.points.length + ' points selected.</b>' +
                    '<br>Click on empty space to deselect.');
            }

            /**
             * On click, unselect all points
             */
            function unselectByClick() {
                var points = this.getSelectedPoints();
                if (points.length > 0) {
                    Highcharts.each(points, function (point) {
                        point.select(false);
                    });
                }
            };

             
             var chart;
             
             $(document).ready(function () {
                     // $.getJSON("dataline.php", function(json) {
                     chart = new Highcharts.Chart({
                             chart: {
                                 renderTo: 'mygraph',
                                 type: 'scatter',
                                 showverticalline: 1,
                                 events: {
                                    selection: selectPointsByDrag,
                                    // selectedpoints: selectedPoints,
                                    click: unselectByClick
                                 },
                                 zoomType:'xy',
                                 height:500,
                                 // events: {
                                 //    // selection: selectPointsByDrag,
                                 //    selectedpoints: getValue
                                 //    // click: unselectByClick
                                 // }
                             },
                             title: {
                                 text: 'Talent Pool'
                             },
                             subtitle: {
                                 text: 'KAI'
                             },
                             xAxis: {
                                gridLineWidth: 1,
                                 // min: 0,
                 // max: 100,
                                tickInterval:5,

                                 title: {
                                     enabled: true,
                                     text: 'POTENTIAL'
                                 },
                                 endOnTick: true,
                                 showLastLabel: true,
                                 gridLineWidth: 1,
                                 startOnTick: 'true',
                                 plotLines: [
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
                                    if ($fce->GetStatus() == SAPRFC_OK) {
                                        $fce->GD_TP_GETSTD->Reset();
                                        $fce->GD_TP_GETSTD->Next();
                                        $colstd =  $fce->GD_TP_GETSTD->row["STDCOMP"];
                                    }
                                ?>
                                    {
                                     id :'foo',
                                     value: <?php echo $colstd ?>,
                                     width: 5,
                                     color: 'orange',
                                     // label: {
                                     //        // align: 'right',
                                     //        rotation: 0,

                                     //        style: {
                                     //            fontStyle: 'italic'
                                     //        },
                                     //        text: 'POTENTIAL',
                                     //        // x: 10,
                                     //        y:15
                                     //    },
                                       zIndex: 3,
                                       onDragStart: function (new_value) {
                                         $("#x_value").text(parseInt(new_value) + ' (Not changed yet)');
                                       },
                                       onDragChange: function (new_value) {
                                         $("#x_value").text(parseInt(new_value) + ' (Dragging)');
                                       },
                                       onDragFinish: function (new_value) {
                                         $("#x_value").text(parseInt(new_value));
                                         var varJS = parseInt(new_value);
                                         document.form1.valuec.value = varJS;
                                       }
                                 }]
                             },
                             yAxis: {
                                 title: {
                                     text: 'performance'
                                 },
                                 startOnTick: 'true',
                                 gridLineWidth: 1,
                                 // min:0,
                                 tickInterval:5,
                                 plotLines: [
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
                                    if ($fce->GetStatus() == SAPRFC_OK) {
                                        $fce->GD_TP_GETSTD->Reset();
                                        $fce->GD_TP_GETSTD->Next();
                                        $rowstd =  $fce->GD_TP_GETSTD->row["STDPERF"];
                                    }
                                  ?>
                                  {
                                        id :'y2',
                                        color: 'blue',
                                        dashStyle: 'line',
                                        width: 5,
                                        value: <?php echo $rowstd ?>,
                                        // value: 80,
                                        // label: {
                                        //     align: 'right',
                                        //     style: {
                                        //         fontStyle: 'italic'
                                        //     },
                                        //     text: 'Performances',
                                        //     x: -10
                                        // },
                                        zIndex: 3,
                                        onDragStart: function (new_value) {
                                            $("#y_value").text(parseInt(new_value) + ' (Not changed yet)');
                                        },
                                        onDragChange: function (new_value) {
                                            $("#y_value").text(parseInt(new_value) + ' (Dragging)');
                                        },
                                        onDragFinish: function (new_value) {
                                            $("#y_value").text(parseInt(new_value));
                                            var varJS = parseInt(new_value);
                                            document.form1.valuep.value = varJS;
                                            // document.form1.valuep1.value = varJS;
                                        }
                                    }]
                             },
                             tooltip: {
                                 formatter: function () {
                                     return '<b>' + this.series.name + '</b><br/>' +
                                         this.x + ': ' + this.y;
                                 },
                             },
                            legend: {
                                enabled: false
                            },
                            series: [
                                 <?php $con = mysqli_connect("localhost", "root", "", "dbline");
                                 if (!$con) {
                                     die('Could not connect: ' . mysql_error());
                                 }
                                 $sql = "Select * from talent_pool";
                                 //jalankan query
                                 $rs = mysqli_query($con, $sql);
                                 //bikin variabel sebagai array untuk menampung data nantinya
                                 while ($row = mysqli_fetch_object($rs)) {
                                 // 'nama'=>$row->nama;
                                     $name = $row->nama;
                                     $sql2 = "Select * from talent_pool where nama='$name'";
                                     $rs2 = mysqli_query($con, $sql2);
                                     $ret2 = array();
                                    while ($row = mysqli_fetch_array($rs2)) {
                                         $cols = $row['value1'];
                                         $rows = $row['value2'];
                                    }?>
                                {
                                     name: '<?php echo $name; ?>',
                                     data: [[<?php echo $cols;?>,<?php echo $rows;?>]]
                                     
                                },
                                 <?php } ?>
                                    
                                {
                                    enableMouseTracking: false,
                                    linkedTo: 0,
                                    marker: {
                                        enabled: false
                                    },
                                    dataLabels: {
                                        defer: false,
                                        enabled: true,
                                        allowOverlap: true,
                                        style: {
                                            color: 'grey',
                                            filter:'alpha(opacity=50%)',
                                            fontStyle: 'italic',
                                            // fontfamily: 'calibri',
                                            fontSize: '30px',
                                            fontWeight: 'bold'
                                        },
                                        format: '{point.name}'
                                    },
                                    keys: ['x', 'y', 'name'],
                                    data: [
                                        [100, 100, 'Q1'],
                                        [0, 100, 'Q2'],
                                        [100, 0, 'Q4'],
                                        [0, 0, 'Q3']
                                    ]
                                }

                             ]
                         },

             function(chart) {
               draggablePlotLine(chart.xAxis[0], 'foo');
               draggablePlotLine(chart.yAxis[0], 'y2');
               console.log('ready');
               $slider = $('#slider');
                $slider.slider({
                min: chart.axes[0].min,
                max: chart.axes[0].max,
                slide : function(event, ui){
                    var plotX = chart.xAxis[0].toPixels(ui.value, false);
                    $('#slider_bar').remove();
                    chart.renderer.path(['M', plotX, 75, 'V', plotX, 300]).attr({
                        'stroke-width': 1,
                        stroke: 'rgba(223, 83, 83, .5)',
                        id : 'slider_bar'
                    })
                    .add();  
                }
            }); 
            $slider.slider('option', 'slide').call($slider, null, { value: chart.axes[0].min });                                    
        // chart.renderer.text('Quadrant B', 150, 120).css({
                             //     color: '#929195',
                             //     fontSize: '20px',
                             //     fontWeight: 'bold'
                             // }).add();
                             // chart.renderer.text('Quadrant A', 650, 120).css({
                             //     color: '#929195',
                             //     fontSize: '20px',
                             //     fontWeight: 'bold'
                             // }).add();
                             // chart.renderer.text('Quadrant C', 150, 235).css({
                             //     color: '#929195',
                             //     fontSize: '20px',
                             //     fontWeight: 'bold'
                             // }).add();
                             // chart.renderer.text('Quadrant D', 650, 235).css({
                             //     color: '#929195',
                             //     fontSize: '20px',
                             //     fontWeight: 'bold'
                             // }).add();
                         });

                 });
         });

  </script>
  <script type="text/JavaScript">


    function TimedRefresh( t ) {

    setTimeout("location='refresh.php';", t);

    }


  </script>
  <script type="text/javascript"> 
    function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
    }

    function startTime() {
    // var strcount;
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
      if (h==00 && m==59 && s==59) {
        setTimeout("location='refresh.php';", 500)
      };
    }
  </script>


  <script src="assets/js/highcharts.js"></script>
  
  <script src="assets/js/exporting.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-black sidebar-mini" onload="startTime();">

<div class="wrapper fixed">

  <header class="main-header fixed">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
              <img src="dist/img/kai.png" class="user-image" alt="User Image" width="40px">
          
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
            <!-- <a href="index.php"> -->
              <!-- <img src="dist/img/avatar5.png" class="user-image" alt="User Image"> -->
              <img src="dist/img/kai.png" class="user-image" alt="User Image" width="50px"><b>KA</b>I
              
            </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs">User</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/avatar5.png" class="img-circle" alt="User Image">

                <p>
                  User - Web Developer
                  <small>Member since Sep. 2016</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
<!--       <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Username</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
 -->      <!-- search form -->
<!--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</br>
        <span id="txt"></span></li>

        <li class="active treeview">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">open</small> -->
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="refresh.php" >
            <i class="fa fa-refresh"></i><span>Refresh</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">open</small> -->
            </span>
          </a>
        </li>
        
        <?php
$con=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw
// mysql_select_db("customer_db");
//--- membaca data ----
$sql="select * from talent_pool";
$hs=mysqli_query($con, $sql);
?>

<!-- </ul> -->
        <!-- <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      <!-- </li> -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <!-- <div class="container" style="margin-top:0px"> -->
      <!-- modalAdd start -->
      <div class="modal modal-primary fade" id="Modaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Data</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="p_Insert_Data.php">

                    <div class="modal-body">
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">ID</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="id" placeholder="ID (example : 1001)" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Nama</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="nama" placeholder="Name" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Potential</label>

                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="value1" placeholder="Potential" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Performance</label>

                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="value2" placeholder="Performance" required/>
                        </div>
                      </div>

                      
                    </div>
                    <div class="modal-footer"  style="margin:0px; border-top:0px; text-align:center;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="simpan btn btn-outline">Save</button>
                    </div>
                    </form>

                        <!-- </form> -->
                    
                </div>
            </div>
        </div>
<!-- modalAdd End -->

<!-- modal Edit Start -->
        <div class="modal modal-primary fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        </div>
<!-- Modal Edit End -->

<!-- Modal Delete Start -->
        <div class="modal modal-danger fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      
        </div>

        <?php 
          $conn=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw
          $sql= "SELECT * FROM TALENT_POOL";
          $query=mysqli_query($con, $sql) or die("index.php: delete data");
          while($row=mysqli_fetch_array($query) ) {  // preparing an array
            $getID =$row["id"];
        ?>
        <div class="modal modal-primary fade" id="ModalEdit1<?php echo $getID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

          <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="p_Insert_Data.php">

                    <?php
                        
                      $sqlid= "SELECT * FROM TALENT_POOL where id=$getID";
                      $queryid=mysqli_query($con, $sqlid) or die("index.php: delete data");
                      while($r = mysqli_fetch_array($queryid)){
                        
                           
                        ?>


                                <div class="modal-body">
                                  
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">ID Number</label>

                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="id" value="<?php echo $r['id'];?>" readonly="true" required/>
                                    </div>
                                  </div><!-- <input type="text" class="form-control" name="hdnline" value="<?php echo "$i"."dan"."$id";?>"/> -->
                                      
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama</label>

                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="nama" value="<?php echo $r['nama'];?>" required/>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label  class="col-sm-2 control-label">Potential</label>

                                    <div class="col-sm-10">
                                      <input type="number" class="form-control" name="value1" value="<?php echo $r['value1'];?>" required/>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label  class="col-sm-2 control-label">Performance</label>

                                    <div class="col-sm-10">
                                      <input type="number" class="form-control" name="value2" value="<?php echo $r['value2'];?>" required/>
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

          

        </div>
        <?php } ?>
<!-- Modal Edit End -->

<!-- Modal Delete Start -->


        <?php 
          $conn=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw
          $sql= "SELECT * FROM TALENT_POOL";
          $query=mysqli_query($con, $sql) or die("index.php: delete data");
          while($row=mysqli_fetch_array($query) ) {  // preparing an array
            $getID =$row["id"];
        ?>

        <div class="modal modal-danger fade" id="ModalDelete1<?php echo "$getID";?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php
          $sqlid= "SELECT * FROM TALENT_POOL where id=$getID";
          $queryid=mysqli_query($con, $sqlid) or die("index.php: delete data");
          while($r = mysqli_fetch_array($queryid)){
        ?>
          <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="text-align:center;">Are you sure to delete <?php echo $row['nama'];?></h4>
              </div>
                        
              <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="proses_delete.php?id=<?php echo $row['id'];?>" class="btn btn-outline" id="delete_link">Delete</a>
              </div>
            </div>
          </div>
  <?php } ?>      
        </div>
<?php }?>

<!--  Modal Delete End -->
      <div class="row">
        
            
        <div class="col-md-9 connectedSortable">
        <?php 
    //        menampilkan pesan jika ada pesan
            if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                // echo "<div class='alert alert-success alert-dismissable'>
                //     <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                //     <h4>  <i class='icon-check'></i> Alert!</h4>".$_SESSION['pesan']."</div>";
              echo $_SESSION['pesan'];
            }
   //        mengatur session pesan menjadi kosong
            $_SESSION['pesan'] = '';
            ?>

            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
              <li class="active"><a href="#data-chart" data-toggle="tab"><i class="fa fa-area-chart"></i>Data Graphic</a></li>
              <li><a href="#table-data" data-toggle="tab"><i class="fa fa-table"></i>Data Table</a></li>
              <li class="pull-right header"><i class="fa fa-th-large"></i> Talent Pool</li>
            </ul>
                <div class="tab-content no-padding">
                  <div class="chart tab-pane active" id="data-chart" style="position: relative;">
                        <div id ="mygraph"></div>
                        <div id="slider"></div>
                  </div>
                        
                  <div class="chart tab-pane" id="table-data" style="position: relative; ">
                    <?php 
                        $con=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw
                        $sql="select * from talent_pool";
                        $hs=mysqli_query($con, $sql);
                        ?>


                                    <div class="box-body">
                                            <form name="form" method="post" action="p_save_std.php" >
                                              <button type="submit" id="download" name="download" class="btn btn-flat btn-success btn-sm pull-right" style="margin-right: 5px; width=200px">
                                                <i class="fa fa-download"></i> Download Data
                                              </button>
                                            </form>
                                            </br></br>
                                      <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                          <th width="5%">ID</th>
                                          <th width="40%">Name</th>
                                          <th width="10%">Potential</th>
                                          <th width="10%">Performances</th>
                                          <th width="10%">Quadran</th>
                                          <th width="25%">
                                          <a class="btn btn-flat btn-social btn-instagram btn-sm " data-toggle="modal" data-target="#Modaladd">
                                              <i class="fa fa-user-plus"></i> Add New Data
                                            </a>
<!--                                             <div class="btn-group btn-block">
                                              <label id="EditTriger" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</label>
                                              <label data-toggle="modal" id="ModalDelete" class="btn btn-danger btn-xs" data-target="#ModalDelete"><i class="fa fa-trash"></i>Delete</label>
                                            </div>                      
 -->
                                            <!-- <input type="checkbox"  id="bulkDelete"  /> -->
                                            <!-- <button  ><i class='fa fa-trash'></i>Delete</button> -->
                                          </th>

                                        </tr>
                                        </thead>

                                       <!--  <?php 
                                        $number= 0;
                                        while($rs=mysqli_fetch_array($hs)){ $number++;?>
                                        <tbody>
                                        <tr>
                                          <td><?php echo $number ?> </td>
                                          <td><?php echo $rs['nama'] ?> </td>
                                          <td><?php echo $rs['value1'] ?></td>
                                          <td><?php echo $rs['value2'] ?></td>
                                          <td><?php echo $rs['quadran'] ?></td>
                                          <td>
                                              <a class="btn btn-sm btn-social btn-instagram modal_edit" data-toggle="modal" href="#" data-id="<?php echo $rs['id'];?>" >
                                                <i class="fa fa-edit"></i> Edit
                                              </a>
                                              <a class="btn btn-sm btn-social btn-google delete_modal" data-toggle="modal" href="#" data-id="<?php echo $rs['id'];?>">
                                                <i class="fa fa-trash"></i> Delete
                                              </a>
                                              
                                          </td>
                                        </tr>
                                        </tbody>
                                        <?php } ?> -->
                                       </table>
                                    </div>




                  </div>
                </div> 
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
          <!-- small box -->
          
          <form name="form1" id="form1" method="post" action="p_save_std.php">
            <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon" style="Width:50%;">
                    POTENTIAL
                  </div>
                  <input type="number" id="valuec" name="valuec" value="<?php echo $colstd;?>" class="form-control" required/>
                </div>
              <div class="progress" style="height:5px;">
                  <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width:<?php echo $colstd;?>%"></div>
              </div>

            </div>
            
            <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon" style="Width:50%;">
                    PERFORMANCE
                  </div>
                  <input type="number" id="valuep" name="valuep" value="<?php echo $rowstd;?>" class="form-control" required/>
                  
            
                </div>
              <div class="progress" style="height:5px;">
                  <div class="progress-bar progress-bar-striped active" style="width:<?php echo $rowstd;?>%"></div>
              </div>
            </div>
            
           
            <button type="submit" id="submit" name="submit" class="btn btn-block btn-primary btn-flat" style="margin-right: 5px; width=200px">
                <i class="fa fa-save"></i> Update Standard
            </button>
          </form>
          
      </div>
    </div>
  </div>
          
        
  <!--< /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2016 <a href="kereta-api.co.id">TIM KKN-P FILKOM, UB </a>.</strong> All rights
    reserved<?php $stopwatch = new StopWatch(); 
        usleep(1000000); 
        echo " (".$stopwatch->elapsed()." seconds)."; 
      ?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>

    <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
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
<!-- SlimScroll -->
<!-- <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script> -->
<!-- FastClick -->
<!-- <script src="plugins/fastclick/fastclick.js"></script> -->
<!-- AdminLTE App -->
<!-- <script src="dist/js/app.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- page script -->
 
<script type="text/javascript">
   $(document).ready(function () {
   $(".modal_edit").click(function(e) {
      // var m = $(this).attr("id");
       $.ajax({
             url: "modal_edit.php",
             type: "GET",
             data : {id:$(this).attr('data-id')},
             success: function (ajaxData){
               $("#ModalEdit").html(ajaxData);
               $("#ModalEdit").modal('show',{backdrop: 'true'});
             }
           });
        });
    $(".delete_modal").click(function(e) {
      // var m = $(this).attr("id");
       $.ajax({
             url: "modal_delete.php",
             type: "GET",
             data : {id:$(this).attr('data-id')},
             success: function (ajaxData){
               $("#ModalDelete").html(ajaxData);
               $("#ModalDelete").modal('show',{backdrop: 'true'});
             }
           });
        });


      });
  </script>
  <script>
      $(document).ready(function () {
        $("#search_text").keyup(function() {
          var txt = $(this).val();
          if (txt != '') 
          {
            $.ajax({
              url:"fetch.php",
              method:"post",
              data:{search:txt},
              dataType:"text",
              success:function(data)
              {
                $('#result').html(data);
              }

            });
          }
          else
          {
            $('#result').html('');

          }
        });
      });

  </script>
  <script type="text/javascript">
   $(document).ready(function () {
   $("#ModalEdit1").click(function(e) {
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


 <!-- Javascript untuk popup modal Delete 

<script type="text/javascript">
    function confirm_modal(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }
</script>
-->

 
<script>
  $(function () {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
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