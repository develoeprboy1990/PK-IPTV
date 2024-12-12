<script type="text/javascript">
$(document).ready(function(){

	   var datatable = $('#apps').DataTable({ 
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'lengthMenu': [ 10, 20, 50, 100 ],
      });
	  
	  /* var datatable = $('#apps_log').DataTable({ 
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'lengthMenu': [ 10, 20, 50, 100 ],
      });*/
	  
 $("#episode_date").datepicker({ dateFormat: 'dd-mm-yy' });
	  
$("#data_log").on('click', function() {
	$("#apps_log").toggle();
	$("#apps").toggle();
	
	$("#apps_length").toggle();
	$("#apps_filter").toggle();
	
	$("#apps_log_length").toggle();
	$("#apps_log_filter").toggle();
	
	$("#apps_log_info").toggle();
	$("#apps_log_paginate").toggle();
	
	$("#apps_info").toggle();
	$("#apps_paginate").toggle();
	
	$("#data_log_span").toggle();
	$("#data_add_span").toggle();
	
	$("#data_add_all").toggle();
	
	$("#data_log_span_search").toggle();
});
/*$("#product_id").on('change', function() {
  		var p_id = this.value;
		$('#corresponding_products').hide();
		if(p_id != ''){
			$.ajax({
					url:"<?php echo base_url(); ?>customerpanel/relatedProducts",
					method:"POST",
					data:{p_id:p_id},
					success:function(data){
						if(data != ''){
						   $('#related_products').html(data);
						   //$('#billing_city').html('<option value="">Select City</option>'); 
						   $('#corresponding_products').show();
						 }
					}
			  });
		}
 
});*/


 // mulit-Devices Group
    $('#btn_leftSelected_devices').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_devices', '#multiselect_right_devices');
    });

    $('#btn_rightSelected_devices').on('click', function () {
      moveItemsToRight('#multiselect_left_devices', '#multiselect_right_devices');
    });

    $('#btn_leftAll_devices').on('click', function () {
      moveAllItemsToSource('#multiselect_left_devices', '#multiselect_right_devices');
    });

    $('#btn_rightAll_devices').on('click', function () {
      moveAllItemsToDest('#multiselect_left_devices', '#multiselect_right_devices');
    });

    $('#btn_move_up_devices').click(function(){
      moveUp('#multiselect_right_devices');
    });

    $('#btn_move_down_devices').click(function(){
        moveDown('#multiselect_right_devices');
    });
   
    // mulit-select Stores Group
    $('#btn_leftSelected_stores').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_stores', '#multiselect_right_stores');
    });

    $('#btn_rightSelected_stores').on('click', function () {
      moveItemsToRight('#multiselect_left_stores', '#multiselect_right_stores');
    });

    $('#btn_leftAll_stores').on('click', function () {
      moveAllItemsToSource('#multiselect_left_stores', '#multiselect_right_stores');
    });

    $('#btn_rightAll_stores').on('click', function () {
      moveAllItemsToDest('#multiselect_left_stores', '#multiselect_right_stores');
    });

    $('#btn_move_up_stores').click(function(){
      moveUp('#multiselect_right_stores');
    });

    $('#btn_move_down_stores').click(function(){
        moveDown('#multiselect_right_stores');
    });

    // mulit-select Series Stores Group
    $('#btn_leftSelected_series_stores').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_rightSelected_series_stores').on('click', function () {
      moveItemsToRight('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_leftAll_series_stores').on('click', function () {
      moveAllItemsToSource('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_rightAll_series_stores').on('click', function () {
      moveAllItemsToDest('#multiselect_left_series_stores', '#multiselect_right_series_stores');
    });

    $('#btn_move_up_series_stores').click(function(){
      moveUp('#multiselect_right_series_stores');
    });

    $('#btn_move_down_series_stores').click(function(){
        moveDown('#multiselect_right_series_stores');
    });

    // mulit-select Countries Group
    $('#btn_leftSelected_countries').click(function () {
        // pass id select lists as parameters
        moveItemsToLeft('#multiselect_left_countries', '#multiselect_right_countries');
    });

    $('#btn_rightSelected_countries').on('click', function () {
      moveItemsToRight('#multiselect_left_countries', '#multiselect_right_countries');
    });

    $('#btn_leftAll_countries').on('click', function () {
      moveAllItemsToSource('#multiselect_left_countries', '#multiselect_right_countries');
    });

    $('#btn_rightAll_countries').on('click', function () {
      moveAllItemsToDest('#multiselect_left_countries', '#multiselect_right_countries');
    });

    $('#btn_move_up_countries').click(function(){
      moveUp('#multiselect_right_countries');
    });

    $('#btn_move_down_countries').click(function(){
        moveDown('#multiselect_right_countries');
    });

    $("#select_all").change(function(){
        $(".episode_checkbox").prop('checked', $(this).prop("checked"));
    });

     $(".episode_checkbox").change(function(){
        if (!$(this).prop("checked")){
            $("#select_all").prop("checked", false);
        }
    });

    $("#delete_selected_btn").click(function(e){
      e.preventDefault();
      
      var selected = [];
      $('.episode_checkbox:checked').each(function(){
          selected.push($(this).val());
      });
      
      if(selected.length === 0){
          alert('Please select at least one episode to delete.');
          return;
      }
      
      if(confirm('Are you sure you want to delete ' + selected.length + ' selected episodes?')){
          var form = $('<form></form>')
              .attr('method', 'post')
              .attr('action', '<?php echo base_url(); ?>daily_episode_update/delete_multiple');

              
          // Add CSRF token if your system uses it
          <?php if(isset($this->security) && $this->security->get_csrf_token_name()): ?>
          form.append($('<input>')
              .attr('type', 'hidden')
              .attr('name', '<?= $this->security->get_csrf_token_name() ?>')
              .attr('value', '<?= $this->security->get_csrf_hash() ?>'));
          <?php endif; ?>
          
          // Add selected episodes
          selected.forEach(function(id){
              form.append($('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'selected_episodes[]')
                  .attr('value', id));
          });
          
          $('body').append(form);
          form.submit();
      }
    });
});

function show_logdata(){
	var select_log_data = $('#select_log_data').val();
	//alert(select_log_data);
	$.ajax({
					url:"<?php echo base_url(); ?>daily_episode_update/fetch_logdata",
					method:"POST",
					data:{select_log_data:select_log_data},					
					success:function(data){
						//if(data != ''){
						   //$('#related_products').html(data);
						   //$('#billing_city').html('<option value="">Select City</option>'); 
						   //$('#corresponding_products').show();
						 //}
						 //$('#multiselect_left_devices').empty();
						 $('#apps_log').html(data);
						/* $('#apps_log').dataTable( {
							searching: false,
							paging: false
						} );*/
 						$('#apps_log').dataTable().fnDestroy();
						$('#apps_log').DataTable({ 
							'paging'      : true,
							'lengthChange': true,
							'searching'   : true,
							'ordering'    : true,
							'info'        : true,
							'autoWidth'   : false,
							'lengthMenu': [ 10, 20, 50, 100 ],
						  });
						 $("#apps_log_length").toggle();
						$("#apps_log_filter").toggle();
						
						$("#apps_log_info").toggle();
						$("#apps_log_paginate").toggle();
						 
					}
			  });
}

function fetch_Season(){
	var episode_date = $('#episode_date').val();
	//var episode_day = new Date($('#episode_date').val()).getDay();
	var parts = episode_date.split('-');
	var date = new Date(parts[2], parts[1] - 1, parts[0]);
	var episode_day = date.getDay();

	$('#apps_filter input').val(episode_date);
	
	var press = jQuery.Event("keyup");
    press.ctrlKey = false;
    press.which = 46;
	
	$('#apps_filter input').trigger(press);
	
	$('#multiselect_right_devices').empty();
			$.ajax({
					url:"<?php echo base_url(); ?>daily_episode_update/fetch_season",
					method:"POST",
					data:{episode_day:episode_day, episode_date:episode_date},					
					success:function(data){
						//if(data != ''){
						   //$('#related_products').html(data);
						   //$('#billing_city').html('<option value="">Select City</option>'); 
						   //$('#corresponding_products').show();
						 //}
						 //$('#multiselect_left_devices').empty();
						 $('#multiselect_left_devices').html(data);
					}
			  });

}
</script>