<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<!-- bootstrap color picker -->
<script src="<?= DEFAULT_ASSETS ?>bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#services').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
        
        $('#primary_color').colorpicker();
        $('#secondary_color').colorpicker();
		
			$('#ui').change(function(){
				var theme_id = $('#ui').val();
				var theme_name = $(this).find("option:selected").text();
			  $('#basestart_url').html('');
				if(theme_id != ''){
				 $.ajax({
					url:"<?php echo base_url(); ?>gui_settings/templateselect",
					method:"POST",
					data:{theme_id:theme_id},
					success:function(data){
					   $('#ui_template').html(data);
					   $('#template_name').html('<input type="hidden" name="tembm_name" id="tembm_name" value="'+theme_name+'" />');
					}
				  });
				}
				else{
					 $('#ui_template').html('<option value="">Select UI</option>');             
				  }
		  });
		  
		  $('#ui_template').change(function(){
		  		var uie_name = $(this).find("option:selected").text();
				$('#basestart_url').html('<input type="hidden" name="base_start_url" id="base_start_url" value="'+uie_name+'" />');
		  });
		  
    });
  </script>