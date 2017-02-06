   $(document).ready(function () {
   $(".open_modal").click(function(e) {
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
      });
