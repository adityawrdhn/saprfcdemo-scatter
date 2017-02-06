<!doctype html>
<html>
    <head>
        <title>Modal - harviacode.com</title>
        <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/> -->
        <link rel="stylesheet" href="asset/css/bootstrap.css"/>
        <link rel="stylesheet" href="asset/css/bootstrap-responsive.css"/>
        <link rel="stylesheet" href="asset/css/chosen.css"/>
        <link rel="stylesheet" href="asset/css/style.css"/>


        <style type="text/css">
            .chzn-container-single .chzn-search input{
                width: 100%;
            }
        </style>

        <!-- Fav icon -->
        <link rel="shortcut icon" href="asset/img/favicon.ico">

        <!-- JS -->
        <script type="text/javascript" src="asset/js/jquery.js"></script>
        <script type="text/javascript" src="asset/js/bootstrap.js"></script>
        <script type="text/javascript" src="asset/js/chosen.jquery.js"></script>
        <script type="text/javascript">
            $(function(){
                $('.chzn-select').chosen();
                $('.chzn-select-deselect').chosen({allow_single_deselect:true});
            });

        </script>

    </head>
    <body>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="simpan btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <table class="table">
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
                <!--pada prakteknya looping dari database-->
                <tr>
                    <td>Hari</td>
                    <td>Jakarta</td>
                    <td><a href="#" class="edit-record" data-id="1">Show</a></td>
                </tr>
                <tr>
                    <td>Hera</td>
                    <td>Bekasi</td>
                    <td><a href="#" class="edit-record" data-id="2">Show</a></td>
                </tr>
            </table>
        </div>
        <script>
        $(function(){
            $(document).on('click','.edit-record',function(e){
                e.preventDefault();
                $("#myModal").modal('show');
                $.post('hasil.php',
                    {id:$(this).attr('data-id')},
                    function(html){
                        $(".modal-body").html(html);
                    }   
                );
            });
        });
    </script>
    </body>
</html>