<script type="text/javascript">
    $(document).ready(function(){
		$('#reseller_keycode,#customer_list,#reseller_wallet,#customer_plan').DataTable({
          'paging'      : true,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,        
          'lengthMenu': [ 10, 20, 50, 100 ]
        });
    	$('#billing_country').change(function(){
          var country_id = $('#billing_country').val();
        
          if(country_id != ''){
           $.ajax({
              url:"<?php echo base_url(); ?>dynamic_dependent/fetch_state",
              method:"POST",
              data:{country_id:country_id},
              success:function(data){
                 $('#billing_state').html(data);
                 $('#billing_city').html('<option value="">Select City...</option>');
              }
            });
          }
          else{
               $('#billing_state').html('<option value="">Select State...</option>');
               $('#billing_city').html('<option value="">Select City...</option>');
            }
        });
        $('#billing_state').change(function(){
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
          $('#billing_city').html('<option value="">Select City...</option>');
          }
        });
    
        // New upgrade functionality
        $('.upgradeBtn').click(function() {
            var resellerPlanId = $(this).data('reseller-plan-id');
            var customerId = $(this).data('customer-id');
            var planName = $(this).data('plan-name');
            var deviceAllowed = $(this).data('device-allowed');
            var totalBalance = $(this).data('total-balance');

            $('#popupResellerPlanId').val(resellerPlanId);
            $('#popupCustomerId').val(customerId);
            $('#popupPlanName').text(planName);
            $('#popupDeviceAllowed').text(deviceAllowed);
            $('#popupTotalBalance').text(totalBalance);

            $('#UpgradePopup').addClass('show');
        });

        $('#closeUpgradePopup').click(function() {
            $('#UpgradePopup').removeClass('show');
        });

        $('#closeUpgradeStatusPopup').click(function() {
		    $('#upgradeStatusPopup').removeClass('show');
		    location.reload(); // Reload the page to reflect the changes
		});

        $(window).click(function(event) {
            if ($(event.target).is('#UpgradePopup')) {
                $('#UpgradePopup').removeClass('show');
            }
        });       
    });
	
	function deleteRowoption(username, id){
		  let text = "Are you sure to delete "+username+" ?";
		  if (confirm(text) == true) {
			$.ajax({
				url:"<?php echo base_url(); ?>resellers/deletecustomer",
				method:"POST",
				data:{customer_id:id},
				dataType : "html",
				success:function(data){
					if(data == 'success'){
						window.location.href = "<?php echo base_url(); ?>resellers/customerslist";	
					}			
				}
			});
		  } else {
			text = "You canceled!";
		  }		 
					/**/
			  
	}
	
	function deletekeycode(codename, id){
		  let text = "Are you sure to delete code : "+codename+" ?";
		  if (confirm(text) == true) {
			$.ajax({
				url:"<?php echo base_url(); ?>resellers/deletekeycode",
				method:"POST",
				data:{code_id:id},
				dataType : "html",
				success:function(data){
					if(data == 'success'){
						window.location.href = "<?php echo base_url(); ?>resellers";	
					}			
				}
			});
		  } else {
			text = "You canceled!";
		  }		 
			
	}
	
	function disable_walletkey(id){
		myPopup.classList.add("show");
		$('#code_id').val(id);
		$('#enable_disable_title').html('Disable Key');
		$('#change_type').val('1');
	}
	
	function makedisablewalletcode(){
			var code_id = $('#code_id').val(); 
			var user_message = $('#user_message').val();
			var change_type = $('#change_type').val();
			if(user_message.trim() == ''){
				$('#user_message').css({'border':'1px solid red'});
			} else{ 
				$.ajax({
					url:"<?php echo base_url(); ?>resellers/disablewaletkeycode",
					method:"POST",
					data:{id:code_id,msg:user_message,change_type:change_type},
					success:function(data){						
						myPopup.classList.remove("show");
						  if(data == 'success'){
							 window.location.href = "<?php echo base_url(); ?>resellers/walletmoney";	
						  }
					}
				  });
			}
	}
	
	function disable_key(id){
		myPopup.classList.add("show");
		$('#code_id').val(id);
		$('#enable_disable_title').html('Disable Key');
		$('#change_type').val('1');
	}
	
	function enaable_key(id){
		myPopup.classList.add("show");
		$('#code_id').val(id);
		$('#change_type').val('0');
		$('#enable_disable_title').html('Enable Key');
	}

	function makedisablecode(){
			var code_id = $('#code_id').val(); 
			var user_message = $('#user_message').val();
			var change_type = $('#change_type').val();
			if(user_message.trim() == ''){
				$('#user_message').css({'border':'1px solid red'});
			} else{ 
				$.ajax({
					url:"<?php echo base_url(); ?>resellers/disablekeycode",
					method:"POST",
					data:{id:code_id,msg:user_message,change_type:change_type},
					success:function(data){						
						myPopup.classList.remove("show");
						  if(data == 'success'){
							 window.location.href = "<?php echo base_url(); ?>resellers/masterkeys";	
						  }
					}
				  });
			}
	}
	
    closePopup.addEventListener("click", function () {
        myPopup.classList.remove("show");
    });

    window.addEventListener("click", function (event) {
        if (event.target == myPopup) {
            myPopup.classList.remove("show");
        }
    });
	
	function message_history(id){		
		messagHistory.classList.add("show");
		$.ajax({
				url:"<?php echo base_url(); ?>resellers/messagehistory",
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
	
	function message_history_wallet(id){		
		messagHistory.classList.add("show");
		$.ajax({
				url:"<?php echo base_url(); ?>resellers/messagehistorywallet",
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
	
	closePopupMessageHistory.addEventListener("click", function () {
        messagHistory.classList.remove("show");
    });

	window.addEventListener("click", function (event) {
        if (event.target == messagHistory) {
            messagHistory.classList.remove("show");
        }
    });

    // Add this to your existing JavaScript
	function showUpgradeStatus(message, remainingBalance) {
	    $('#upgradeStatusMessage').html(message);
	    $('#remainingBalance').text(remainingBalance);
	    $('#upgradeStatusPopup').addClass('show');
	}
    // New function for handling upgrade submission
    function submitUpgrade() {
        var resellerPlanId = $('#popupResellerPlanId').val();
        var customerId = $('#popupCustomerId').val();
        var activationKey = $('#activationKey').val();

        $.ajax({
            url: "<?php echo base_url(); ?>resellers/upgrade_customer_ajax",
            method: "POST",
            data: {
            	action: 'upgrade_customer',
                reseller_plan_id: resellerPlanId,
                customer_id: customerId,
                activation_key: activationKey
            },
            dataType: "json",
            success: function(data) {
				$('#UpgradePopup').removeClass('show');
				if(data.success) {
					showUpgradeStatus(data.message);
				} else {
					alert('Upgrade failed: ' + data.message);
				}
            },
            error: function() {
                alert('An error occurred while processing your request');
            }
        });
    }


			
	/*function cancel_plan(){
		 let text;
		  if (confirm("Sure to cancel Plan?") == true) {
				$.ajax({
				  url:"<?php echo base_url(); ?>customer/cancelplan",
				  method:"POST",
				  data:{},
				  success:function(data){
				  	if(data == 'success' ){
						window.location.href = '<?php echo base_url(); ?>customer';
					}
				  }
			   });
		  } else {
			text = "You canceled!";
		  }
	}
	
	
	function call_plan(id){		 
		  		$.ajax({
				  url:"<?php echo base_url(); ?>customer/callaplan",
				  method:"POST",
				  data:{planid:id},
				  dataType : "html",
				  success:function(data){				  	
						$('#plan_id').html(data);					
				  }
			   });
		  
	}
	
	
	function change_plan(id){
		
		  		$('#message_alert').html('');
		  		$.ajax({
				  url:"<?php echo base_url(); ?>customer/changeplan",
				  method:"POST",
				  data:{planid:id},
				  success:function(data){
				  	if(data == 'success'){
						window.location.href = '<?php echo base_url(); ?>customer';
					} else if(data == 'shortmoney'){
						$('#message_alert').html('<span style="color:red;">There is no enough Wallet money.</span>');
					}
				  }
			   });
		
	}*/
  </script>