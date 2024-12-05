<script type="text/javascript">
$(document).ready(function(){

	   var datatable = $('#resellermoneycode').DataTable({ 
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'lengthMenu': [ 10, 20, 50, 100 ],
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
});
</script>