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
        $('#apps,#package-keys,#activation-keys,#reseller_walletmoney').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'lengthMenu': [ 10, 50, 100, 200, 500 ],
           /*'dom'         : 'Bfrtip',
         'buttons': [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]*/
        });
        $('.nav li a[href="#tab_<?=$activeTab?>"]').click();
    });  
  </script>

<script type="text/javascript">
  var ppBtnDom;
  var _dataTable_items; 
  var rowDeleteBtnDom; 

  $(document).ready(function(){
     /* $('#customers,#devices').DataTable({ 
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'lengthMenu': [ 50, 100, 200, 500 ],
      });

      $('#debug_logs,#logs').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
        'pageLength'  : 100,
        'lengthMenu': [ 50, 100, 200, 500 ],
        'order'       :[0, 'desc'],
        'dom'         : 'Bfrtip',
        'buttons': [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      });

      $('.nav li a[href="#tab_<?=$activeTab?>"]').click();

      */
	$('#billing_country').change(function(){
		var country_id = $('#billing_country').val();
		var selected_state = '<?php echo @$selected_state; ?>';

		if(country_id != ''){
		 $.ajax({
		    url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
		    method:"POST",
		    data:{
		    	country_id: country_id,
		        selected_state: selected_state
		    },
		    success:function(data){
		       $('#billing_state').html(data);
		       // If we have a selected state and this is the initial load, select it
		        if(selected_state) {
		            $('#billing_state').val(selected_state);
		        }
		    }
		  });
		}
		else{
		     $('#billing_state').html('<option value="">Select State</option>');             
		}
	});

    if($('#billing_country').val() != '') {
    	$('#billing_country').trigger('change');
    }
	  
	  $('#reseller_id').change(function(){
        var reseller_id = $('#reseller_id').val();
      
        if(reseller_id != ''){
         $.ajax({
            url:"<?php echo base_url(); ?>reseller/resellercurrency",
            method:"POST",
            data:{reseller_id:reseller_id},
            success:function(data){
               $('#currency_type').html(data);
            }
          });
        }
        else{
             $('#currency_type').html('<option value="">Select Currency</option>');             
          }
      });

    
		/*$('#price_act').on('keyup', function () { 
			var monthly_price = $("#price_act").val();
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
				
				$('#total_price_act').show();
				$('#price_amount_act').html(total_amount);
			}
	   		
			
	    });
		
	    $( "#length_months_act" ).on( "keyup", function() {
	   		var monthly_price = $("#price_act").val();
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
				
				$('#total_price_act').show();
				$('#price_amount_act').html(total_amount);
			}
	   });
	   
	    $( "#activation_price_act" ).on( "keyup", function() {
			var monthly_price = $("#price_act").val();
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
				
				$('#total_price_act').show();
				$('#price_amount_act').html(total_amount);
			}
	   });
	   */

	 $('#price_act').on('keyup', function () { 
	    var monthly_price = parseFloat($("#price_act").val());
	    var length_months = parseFloat($("#length_months_act").val());
	    var activation_price = parseFloat($("#activation_price_act").val()) || 0;
	    $('#total_price_act').hide();
	    var total_amount = 0;

	    if(!isNaN(monthly_price) && !isNaN(length_months)){
	        total_amount = (monthly_price * length_months) + activation_price;
	        $('#total_price_act').show();
	        $('#price_amount_act').html(total_amount.toFixed(2));
	    }
	});

	$("#length_months_act").on("keyup", function() {
	    var monthly_price = parseFloat($("#price_act").val());
	    var length_months = parseFloat($("#length_months_act").val());
	    var activation_price = parseFloat($("#activation_price_act").val()) || 0;
	    $('#total_price_act').hide();
	    var total_amount = 0;

	    if(!isNaN(monthly_price) && !isNaN(length_months)){
	        total_amount = (monthly_price * length_months) + activation_price;
	        $('#total_price_act').show();
	        $('#price_amount_act').html(total_amount.toFixed(2));
	    }
	});

	$("#activation_price_act").on("keyup", function() {
	    var monthly_price = parseFloat($("#price_act").val());
	    var length_months = parseFloat($("#length_months_act").val());
	    var activation_price = parseFloat($("#activation_price_act").val()) || 0;
	    $('#total_price_act').hide();
	    var total_amount = 0;

	    if(!isNaN(monthly_price) && !isNaN(length_months)){
	        total_amount = (monthly_price * length_months) + activation_price;
	        $('#total_price_act').show();
	        $('#price_amount_act').html(total_amount.toFixed(2));
	    }
	});

	   
	   
	   /*$('#price_mas').on('keyup', function () { 
			var monthly_price = $("#price_mas").val();
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
				$('#price_amount_mast').html(total_amount);
			}
	   		
			
	    });
		
	    $( "#length_months_mas" ).on( "keyup", function() {
	   		var monthly_price = $("#price_mas").val();
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
				//alert(total_amount);
				$('#total_price_mas').show();
				$('#price_amount_mast').html(total_amount);
			}
	   });*/

	    $( "#activation_price_mas" ).on( "keyup", function() {
			var monthly_price = $("#price_mas").val();
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
				$('#price_amount_mast').html(total_amount);
			}
	   });


	    $('#price_mas').on('keyup', function () { 
		    var monthly_price = parseFloat($("#price_mas").val());
		    var length_months = parseFloat($("#length_months_mas").val());
		    var activation_price = parseFloat($("#activation_price_mas").val()) || 0;
		    
		    $('#total_price_mas').hide();
		    var total_amount = 0;
		    
		    if(!isNaN(monthly_price) && !isNaN(length_months)){
		        total_amount = (monthly_price * length_months) + activation_price;
		        $('#total_price_mas').show();
		        $('#price_amount_mast').html(total_amount.toFixed(2));
		    }
		});
		$("#length_months_mas").on("keyup", function() {
		    var monthly_price = parseFloat($("#price_mas").val());
		    var length_months = parseFloat($("#length_months_mas").val());
		    var activation_price = parseFloat($("#activation_price_mas").val()) || 0;
		    
		    $('#total_price_mas').hide();
		    var total_amount = 0;
		    
		    if(!isNaN(monthly_price) && !isNaN(length_months)){
		        total_amount = (monthly_price * length_months) + activation_price;
		        $('#total_price_mas').show();
		        $('#price_amount_mast').html(total_amount.toFixed(2));
		    }
		});
	   
	   
	   /*
	   $('#price_sub').on('keyup', function () { 
			var monthly_price = $("#price_sub").val();
			var length_months = $( "#length_months_sub").val();
			$('#total_price_sub').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
					total_amount = parseInt(monthly_price)*parseInt(length_months);	
				$('#total_price_sub').show();
				$('#price_amount_sub').html(total_amount);
			}
	   		
			
	    });
	   $( "#length_months_sub" ).on( "keyup", function() {
	   		var monthly_price = $("#price_sub").val();
			var length_months = $( "#length_months_sub").val();
			$('#total_price_sub').hide();
			var total_amount = 0;
			if((monthly_price != '') && (length_months != '')){
					total_amount = parseFloat(monthly_price)*parseFloat(length_months);			
				$('#total_price_sub').show();
				$('#price_amount_sub').html(total_amount);
			}
	   });*/

	    $('#price_sub').on('keyup', function () { 
			var monthly_price = parseFloat($("#price_sub").val());
			var length_months = parseFloat($("#length_months_sub").val());
			$('#total_price_sub').hide();
			var total_amount = 0;

			if(!isNaN(monthly_price) && !isNaN(length_months)){
			    total_amount = monthly_price * length_months;
			    $('#total_price_sub').show();
			    $('#price_amount_sub').html(total_amount.toFixed(2));
			}
		});
		$("#length_months_sub").on("keyup", function() {
		    var monthly_price = parseFloat($("#price_sub").val());
		    var length_months = parseFloat($("#length_months_sub").val());
		    $('#total_price_sub').hide();
		    var total_amount = 0;

		    if(!isNaN(monthly_price) && !isNaN(length_months)){
		        total_amount = monthly_price * length_months;
		        $('#total_price_sub').show();
		        $('#price_amount_sub').html(total_amount.toFixed(2));
		    }
		});


     $('#can_create_walletcode').change(function(){
        var can_create_walletcode = $('#can_create_walletcode').val();
		if(can_create_walletcode == '1'){
			$('#wallet_code_discount_div').show();
		}else{
			$('#wallet_code_discount_div').hide();
			$('#wallet_code_discount').val('0');
		}
	 });
  
  });
 		/*closePopupMessage.addEventListener("click", function () {
            messag_popup.classList.remove("show");
        });
        window.addEventListener("click", function (event) {
            if (event.target == messag_popup) {
                messag_popup.classList.remove("show");
            }
        });
		
		closePopup.addEventListener("click", function () {
            myPopup.classList.remove("show");
        });
        window.addEventListener("click", function (event) {
            if (event.target == myPopup) {
                myPopup.classList.remove("show");
            }
        });
		
		closePopupMessageHistory.addEventListener("click", function () {
            messagHistory.classList.remove("show");
        });
		window.addEventListener("click", function (event) {
            if (event.target == messagHistory) {
                messagHistory.classList.remove("show");
            }
        });*/
		
		function changepaymentstatus(){	
			var wallet_id = $('#wallet_id').val();
			var payment_status = $('#payment_status:checked').val();
			//alert(payment_status);
			var user_message = $('#user_message').val();
			if(user_message.trim() == ''){
				$('#user_message').css({'border':'1px solid red'});
			} else{ 
				$.ajax({
					url:"<?php echo base_url(); ?>reseller/waletstatuschange",
					method:"POST",
					data:{id:wallet_id,msg:user_message,payment_status:payment_status},
					success:function(data){						
						myPopup.classList.remove("show");
					   $('#payment_status_msg').html('<span style="color:#00cc00;">Payment Status change Success</span>');					  
					  // $('#msgset_'+wallet_id).html(user_message);
					}
				  });
			}
	 
		}	
		
		
		function update_message(){
			var wallet_editid = $('#wallet_editid').val();
			var user_editmessage = $('#user_editmessage').val();
			if(user_editmessage.trim() == ''){
				$('#user_editmessage').css({'border':'1px solid red'});
			} else{ 
				$.ajax({
					url:"<?php echo base_url(); ?>reseller/waletupdatemessage",
					method:"POST",
					data:{id:wallet_editid,msg:user_editmessage},
					success:function(data){						
						messag_popup.classList.remove("show");
						//location.href = "<?php echo base_url(); ?>reseller/walletpayment";
					  // $('#payment_status_msg').html('<span style="color:#00cc00;">Payment Status change Success</span>');					  
					 //  $('#msgset_'+wallet_id).html(user_message);
					}
				  });
			}
		}
		
		function message_history(id){		
			messagHistory.classList.add("show");
			$.ajax({
					url:"<?php echo base_url(); ?>reseller/messagehistory",
					method:"POST",
					data:{id:id},
					dataType:'html',
					success:function(data){						
						//myPopup.classList.remove("show");
						//location.href = "<?php echo base_url(); ?>reseller/walletpayment";
					  // $('#payment_status_msg').html('<span style="color:#00cc00;">Payment Status change Success</span>');					  
					   $('#msg_list').html(data);
					}
				  });
		}
			
		function change_payment_status(id){
			myPopup.classList.add("show");
			$('#wallet_id').val(id);
			$('#user_message').css({'border':'1px solid #ccc'});
			$('#user_message').val('');
		}
  
  		function write_message(id){
			messag_popup.classList.add("show");
			$('#wallet_editid').val(id);
			$('#user_editmessage').css({'border':'1px solid #ccc'});
			$('#user_editmessage').val('');
		}
		
  function update_reseller_plans(id){
  	var currency = $('#currency_type_'+id).val();
	var fixed_per = $('#fixed_per_'+id+':checked').val();
	var fixed_per_val = $('#fixed_per_val_'+id).val();
	var product_plans_price = $('#product_plans_price_'+id).val();
	var activation_price = $('#act_price_'+id).val();
	
	$('#currency_type_'+id).css({'border':'1px solid #ccc'});
	$('#fixed_per_val_'+id).css({'border':'1px solid #ccc'});
	 if(currency == ''){
	 	$('#currency_type_'+id).css({'border':'1px solid red'});
	 }else if(fixed_per_val == ''){
	 	$('#fixed_per_val_'+id).css({'border':'1px solid red'});
	 }else if((fixed_per == '2') && (parseInt(fixed_per_val) > 100)){
	 	$('#fixed_per_val_'+id).css({'border':'1px solid red'});
	 }else{
	 	$('#fixed_per_val_'+id).css({'border':'1px solid #ccc'});
         $.ajax({
            url:"<?php echo base_url(); ?>reseller/resellerplansupdate",
            method:"POST",
			 /*dataType: 'json',*/
            data:{id:id, currency:currency,fixed_per:fixed_per,fixed_per_val:fixed_per_val,product_plans_price:product_plans_price,activation_price:activation_price},
            success:function(response){ 
				var responsejsondata = JSON.parse(response);
                if(responsejsondata.msg == 'success'){
			   		$('#dealer_price_'+id).html(responsejsondata.dealer_price);
			    }
            }
          });
        }
  }
</script>