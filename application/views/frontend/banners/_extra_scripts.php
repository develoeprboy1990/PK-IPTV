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
         // autoclose: true,
          //todayBtn: true,
          //pickerPosition: "bottom-left"
        })

        $('#date_end').datetimepicker({
          // format: "yyyy-mm-dd", 
          format: 'YYYY-MM-DD hh:mm:ss'
          //autoclose: true,
          //todayBtn: true,
          //pickerPosition: "bottom-left"
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

        $('#multiselect_right_package option').attr("selected","selected");

        //$("select option[value='B']").attr("selected","selected");.
    });
  </script>