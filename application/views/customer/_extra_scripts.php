<script type="text/javascript">
    $(document).ready(function(){
     
        $('#billing_country').change(function(){
          var country_id = $('#billing_country').val();
        
          if(country_id != ''){
           $.ajax({
              url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
              method:"POST",
              data:{country_id:country_id},
              success:function(data){
                 $('#billing_state').html(data);
                 //$('#billing_city').html('<option value="">Select City</option>');
              }
            });
          }
          else{
               $('#billing_state').html('<option value="">Select State</option>');
              // $('#billing_city').html('<option value="">Select City</option>');
            }
        });

        /*$('#billing_state').change(function(){
          var state_id = $('#billing_state').val();
          if(state_id != '')
          {
           $.ajax({
              url:"<?php echo base_url(); ?>dynamic_dependent/fetch_city",
              method:"POST",
              data:{state_id:state_id},
              success:function(data){
               $('#billing_city').html(data);
              }
           });
          }
          else{
          $('#billing_city').html('<option value="">Select City</option>');
          }
        });*/
    });
  </script>