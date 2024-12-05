<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<!-- bootstrap color picker -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- CK Editor -->
<script src="<?=DEFAULT_ASSETS?>bower_components/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //Colorpicker
        $('#selection_color').colorpicker();
        $('#operator_primary_color').colorpicker();
        $('#operator_secondary_color').colorpicker();
        
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

        CKEDITOR.replace('gui-text');
    });
  </script>