<script type="text/javascript">
    $(document).ready(function(){
        $('#genres').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'pageLength'  : 25
        });

        $('#parent-store').change(function(){
          var parent_id = $('#parent-store').val();
          if(parent_id != '')
          {
           $.ajax({
              url:"<?php echo base_url(); ?>movie_stores/fetch_sub_stores",
              method:"POST",
              data:{parent_id:parent_id},
              success:function(data){
               $('#sub-store').html(data);
              }
           });
          }
          else{
          $('#sub-store').html('<option value="">Select Sub Store</option>');
          }
        });
    });
  </script>`