<?php
/* Database connection start */

$conn=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw

// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 =>'id', 
  1 => 'nama',
  2=> 'value1',
  3=> 'value2',
  4=> 'quadran'
);

// getting total number records without any search
$sql = "SELECT * FROM talent_pool";
// $sql.=" FROM employee";
$query=mysqli_query($conn, $sql) or die("example2.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM talent_pool WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( id LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR nama LIKE '%".$requestData['search']['value']."%' )";



}
$query=mysqli_query($conn, $sql) or die("example2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("example2.php: get employees");

$data = array();
$no=0+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $no++;
  $nestedData=array(); 

  $nestedData[] = $row["id"];
  $nestedData[] = $row["nama"];
  $nestedData[] = $row["value1"];
  $nestedData[] = $row["value2"];
  $nestedData[] = $row["quadran"];
                        
  $nestedData[] = "
  <div class='btn-group'>
  <a class='btn btn-xs btn-social btn-instagram modal_edit1 btn-flat' data-toggle='modal' data-id='".$row['id']."' href=#ModalEdit1".$row['id'].">
                <i class='fa fa-edit'></i> Edit
              </a>
              <a class='btn btn-xs btn-social btn-google delete_modal1 btn-flat' data-toggle='modal' data-id='".$row['id']."' href=#ModalDelete1".$row['id'].">
                <i class='fa fa-trash'></i> Delete
              </a>
  </div>" ;
  
  $data[] = $nestedData;
}



$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>
