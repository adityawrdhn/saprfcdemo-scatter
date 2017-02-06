<!DOCTYPE html>
<?php session_start();
$con=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw
$sql="select * from talent_pool";
$hs=mysqli_query($con, $sql);
?>


            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Id</th>
                  <th width="40%">Name</th>
                  <th width="10%">Competency</th>
                  <th width="10%">Performances</th>
                  <th width="10%">Quadran</th>
                  <th width="20%">
                    <a class="btn btn-block btn-social btn-github" data-toggle="modal" data-target="#myModaladd">
                      <i class="fa fa-plus"></i> Add New Data
                    </a>
                    </th>

                </tr>
                </thead>

                <?php 
                $i= 1;
                while($rs=mysqli_fetch_array($hs)){ ?>
                <tbody>
                <tr>
                  <td><?php echo $rs['id'] ?> </td>
                  <td><?php echo $rs['nama'] ?> </td>
                  <td><?php echo $rs['value1'] ?></td>
                  <td><?php echo $rs['value2'] ?></td>
                  <td><?php echo $rs['quadran'] ?></td>
                  <td>
                      <a class="btn btn-sm btn-social btn-instagram edit-record" data-toggle="modal" data-target="getData.php#myModalEdit"  data-id="<?php echo $rs['id'];?>" >
                        <i class="fa fa-edit"></i> Edit
                      </a>
                      <a class="btn btn-sm btn-social btn-google" data-toggle="modal" data-target="#myModalDel">
                        <i class="fa fa-trash"></i> Delete
                      </a>
                      
                  </td>
                </tr>
				</tbody>
				<?php } ?>
			   </table>
			</div>
      
  	    <div class="modal fade" id="myModaladd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Data</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="p_Insert_Data.php">

                    <div class="modal-body">
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Nama</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="nama" placeholder="Name" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Competency</label>

                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="value1" placeholder="Competency" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Performance</label>

                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="value2" placeholder="Performance" required/>
                        </div>
                      </div>

                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="simpan btn btn-primary">Save changes</button>
                    </div>
                    </form>

                        <!-- </form> -->
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Data</h4>
                    </div>
                    <form class="form-horizontal" method="post" action="p_Insert_Data.php">

                    <div class="modal-body">
                      
                      <div class="form-group">
                        <label class="col-sm-2 control-label">Nama</label>

                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="nama" placeholder="Name" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Competency</label>

                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="value1" placeholder="Competency" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Performance</label>

                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="value2" placeholder="Performance" required/>
                        </div>
                      </div>

                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="simpan btn btn-primary">Save changes</button>
                    </div>
                    </form>

                        <!-- </form> -->
                    
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<?php
    $con=mysqli_connect("localhost", "root" ,"","dbline"); // dbhost, dbuser, dbpsw
    // include "koneksi.php";
  $id=$_GET['id'];
  $modal=mysqli_query($con,"SELECT * FROM talent_pool WHERE id='$id'");
  while($r=mysqli_fetch_array($modal)){
?>

<div class="modal-dialog">
            <div class="modal-content">

      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Edit Data Menggunakan Modal Boostrap (popup)</h4>
        </div>

        <div class="modal-body">
          <form action="proses_edit.php" name="modal_popup" enctype="multipart/form-data" method="POST">
            
                <div class="form-group" style="padding-bottom: 20px;">
                  <label for="Modal Name">Modal Name</label>
                    <input type="hidden" name="modal_id"  class="form-control" value="<?php echo $r['id']; ?>" />
            <input type="text" name="modal_name"  class="form-control" value="<?php echo $r['nama']; ?>"/>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                  <label for="Description">Description</label>
            <textarea name="description"  class="form-control"><?php echo $r['value1']; ?></textarea>
                </div>

                <div class="form-group" style="padding-bottom: 20px;">
                  <label for="Date">Date</label>       
            <input type="text" name="date"  class="form-control" value="<?php echo $r['value2']; ?>" disabled/>
                </div>

              <div class="modal-footer">
                  <button class="btn btn-success" type="submit">
                      Confirm
                  </button>

                  <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">
                    Cancel
                  </button>
              </div>

              </form>

             <?php } ?>

            </div>

           
        </div>
    </div>
        </div>
        
        <script>
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModalEdit").modal('show');
                $.post('modal_edit.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-dialog").html(html);
                    }   
                );
            });
        });
    </script>
        
<!-- DataTables -->
