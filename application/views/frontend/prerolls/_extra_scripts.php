<script type="text/javascript">
    $(document).ready(function(){
        $('#advertisements').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
   
        $('#date_start').datetimepicker({
           //format: "yyyy-mm-dd", 
          format: 'YYYY-MM-DD hh:mm:ss'
         /*  autoclose: true*/
        })

        $('#date_end').datetimepicker({
          // format: "yyyy-mm-dd", 
          format: 'YYYY-MM-DD hh:mm:ss'
           /*autoclose: true*/
        })
    
        $('#country_id').change(function(){
          var country_id = $('#country_id').val();
        
          if(country_id != ''){
           $.ajax({
              url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
              method:"POST",
              data:{country_id:country_id},
              success:function(data){
                 $('#state_id').html(data);
                 $('#city_id').html('<option value="">Select City</option>');
              }
            });
          }
          else{
               $('#state').html('<option value="">Select State</option>');
               $('#city').html('<option value="">Select City</option>');
            }
        });

        $('#state_id').change(function(){
          var state_id = $('#state_id').val();
          if(state_id != '')
          {
           $.ajax({
              url:"<?php echo base_url(); ?>dynamic_dependent/fetch_city",
              method:"POST",
              data:{state_id:state_id},
              success:function(data){
               $('#city_id').html(data);
              }
           });
          }
          else{
          $('#city_id').html('<option value="">Select City</option>');
          }
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        })

        // series ------------------------------
        $('#btn_leftSelected_series').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_series', '#multiselect_right_series');
        });

        $('#btn_rightSelected_series').on('click', function () {
          moveItemsToRight('#multiselect_left_series', '#multiselect_right_series');
        });

        $('#btn_leftAll_series').on('click', function () {
          moveAllItemsToSource('#multiselect_left_series', '#multiselect_right_series');
        });

        $('#btn_rightAll_series').on('click', function () {
          moveAllItemsToDest('#multiselect_left_series', '#multiselect_right_series');
        });

        $('#btn_move_up_series').click(function(){
          moveUp('#multiselect_right_series');
        });

        $('#btn_move_down_series').click(function(){
            moveDown('#multiselect_right_series');
        });


        // movies -------------------
        $('#btn_leftSelected_movies').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_movies', '#multiselect_right_movies');
        });

        $('#btn_rightSelected_movies').on('click', function () {
          moveItemsToRight('#multiselect_left_movies', '#multiselect_right_movies');
        });

        $('#btn_leftAll_movies').on('click', function () {
          moveAllItemsToSource('#multiselect_left_movies', '#multiselect_right_movies');
        });

        $('#btn_rightAll_movies').on('click', function () {
          moveAllItemsToDest('#multiselect_left_movies', '#multiselect_right_movies');
        });

        $('#btn_move_up_movies').click(function(){
          moveUp('#multiselect_right_movies');
        });

        $('#btn_move_down_movies').click(function(){
            moveDown('#multiselect_right_movies');
        });

         // channels -------------------
        $('#btn_leftSelected_channels').click(function () {
          // pass id select lists as parameters
          moveItemsToLeft('#multiselect_left_channels', '#multiselect_right_channels');
        });

        $('#btn_rightSelected_channels').on('click', function () {
          moveItemsToRight('#multiselect_left_channels', '#multiselect_right_channels');
        });

        $('#btn_leftAll_channels').on('click', function () {
          moveAllItemsToSource('#multiselect_left_channels', '#multiselect_right_channels');
        });

        $('#btn_rightAll_channels').on('click', function () {
          moveAllItemsToDest('#multiselect_left_channels', '#multiselect_right_channels');
        });

        $('#btn_move_up_channels').click(function(){
          moveUp('#multiselect_right_channels');
        });

        $('#btn_move_down_channels').click(function(){
            moveDown('#multiselect_right_channels');
        });

        $('#multiselect_right_package option').attr("selected","selected");
    });
  </script>