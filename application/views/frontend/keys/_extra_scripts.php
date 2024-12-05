<style>
.export-icon{font-size: 24px; margin: 2px;}
.csv, .pdf{color: red}
.excel{color: green}
</style>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#apps,#package-keys,#activation-keys').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 50, 100, 200, 500 ],
          'dom'         : 'Bfrtip',
          'buttons': [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });
        $('.nav li a[href="#tab_<?=$activeTab?>"]').click();
		
		$('#monthly_price_act').on('keyup', function () { 
			var monthly_price = $("#monthly_price_act").val();
			var length_months = $( "#length_months_act").val();
			var activation_price = $("#activation_price_act").val();
			//alert(monthly_price);
			$('#total_price').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				}
				
				$('#total_price').show();
				$('#price_amount').html(total_amount);
			}
	   		
			
	    });
		
	    $( "#length_months_act" ).on( "keyup", function() {
	   		var monthly_price = $("#monthly_price_act").val();
			var length_months = $( "#length_months_act").val();
			var activation_price = $("#activation_price_act").val();
			$('#total_price').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				}
				
				$('#total_price').show();
				$('#price_amount').html(total_amount);
			}
	   });
	   
	    $( "#activation_price_act" ).on( "keyup", function() {
			var monthly_price = $("#monthly_price_act").val();
			var length_months = $( "#length_months_act").val();
			var activation_price = $("#activation_price_act").val();
			$('#total_price').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				}
				
				$('#total_price').show();
				$('#price_amount').html(total_amount);
			}
	   });
	   
	   
	   
	   $('#monthly_price_mas').on('keyup', function () { 
			var monthly_price = $("#monthly_price_mas").val();
			var length_months = $( "#length_months_mas").val();
			var activation_price = $("#activation_price_mas").val();
			//alert(monthly_price);
			$('#total_price_mas').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				}
				
				$('#total_price_mas').show();
				$('#price_amount_mas').html(total_amount);
			}
	   		
			
	    });
		
	    $( "#length_months_mas" ).on( "keyup", function() {
	   		var monthly_price = $("#monthly_price_mas").val();
			var length_months = $( "#length_months_mas").val();
			var activation_price = $("#activation_price_mas").val();
			$('#total_price_mas').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				}
				
				$('#total_price_mas').show();
				$('#price_amount_mas').html(total_amount);
			}
	   });
	   
	    $( "#activation_price_mas" ).on( "keyup", function() {
			var monthly_price = $("#monthly_price_mas").val();
			var length_months = $( "#length_months_mas").val();
			var activation_price = $("#activation_price_mas").val();
			$('#total_price_mas').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				}
				
				$('#total_price_mas').show();
				$('#price_amount_mas').html(total_amount);
			}
	   });
	   
	   
	   
	    $('#monthly_price_sub').on('keyup', function () { 
			var monthly_price = $("#monthly_price_sub").val();
			var length_months = $( "#length_months_sub").val();
			//var activation_price = $("#activation_price_sub").val();
			//alert(monthly_price);
			$('#total_price_sub').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				/*if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{*/
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				//}
				
				$('#total_price_sub').show();
				$('#price_amount_sub').html(total_amount);
			}
	   		
			
	    });
		
	    $( "#length_months_sub" ).on( "keyup", function() {
	   		var monthly_price = $("#monthly_price_sub").val();
			var length_months = $( "#length_months_sub").val();
			//var activation_price = $("#activation_price_sub").val();
			$('#total_price_sub').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
				/*if(activation_price != ''){
					total_amount = (parseInt(monthly_price)*parseInt(length_months)) + parseInt(activation_price);
				}else{*/
					total_amount = parseInt(monthly_price)*parseInt(length_months);
				//}
				
				$('#total_price_sub').show();
				$('#price_amount_sub').html(total_amount);
			}
	   });
	   
	   
	   
    });  
  </script>