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
       
    });
	
	
	function cancel_plan(){
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
	
	
	function call_plan(id, free_change){		 
		  		$.ajax({
				  url:"<?php echo base_url(); ?>customer/callaplan",
				  method:"POST",
				  data:{planid:id, free_change:free_change},
				  dataType : "html",
				  success:function(data){				  	
						$('#plan_id').html(data);					
				  }
			   });
		  
	}
	
	
	function change_plan(id, free_change){
		 //let text;
		  //if (confirm("Sure to cancel Plan?") == true) {
		  		$('#message_alert').html('');
		  		$.ajax({
				  url:"<?php echo base_url(); ?>customer/changeplan",
				  method:"POST",
				  data:{planid:id, free_change : free_change},
				  success:function(data){
				  	if(data == 'success'){
						window.location.href = '<?php echo base_url(); ?>customer';
					} else if(data == 'shortmoney'){
						$('#message_alert').html('<span style="color:red;">There is no enough Wallet money.</span>');
					}
				  }
			   });
		 /* } else {
			text = "You canceled!";
		  }*/
	}
	
	function planchange(){
		let text = "Are you sure to change Plan?";
		  if (confirm(text) == true) {
			$('#renewal_change').css({'display':'none'});
			$('#planchange').css({'display':'block'});
		  } 
		
	}
	
	function renuewplan(){
		//let text = "Are you sure to Renuew Plan?";
		  //if (confirm(text) == true) {
				$('#renewal_change').css({'display':'none'});
				$('#select_plans').css({'display':'block'});
		  //} 
		
	}
	
	function renuew_plan(id,plantype){
		let text = "Are you sure to Renuew Plan?";
		  if (confirm(text) == true) {
			$.ajax({
				  url:"<?php echo base_url(); ?>customer/renuewplan",
				  method:"POST",
				  data:{planid:id,plantype:plantype},
				  success:function(data){
				  	if(data == 'success'){
						window.location.href = '<?php echo base_url(); ?>customer';
					} else if(data == 'shortmoney'){
						$('#renuew_msg').html('<span style="color:red;">There is no enough Wallet money.</span>');
					}
				  }
			   });
		  } 
		
	}
	
	function renuew_plan_subscribe(id,plantype){
		let text = "Are you sure to Renuew Plan?";
		var plan_keycode = $('#plan_keycode').val();
		//alert(plan_keycode);
		  if (plan_keycode != '') {
			$.ajax({
				  url:"<?php echo base_url(); ?>customer/renuebysubsscription",
				  method:"POST",
				  data:{plan_keycode:plan_keycode},
				  success:function(data){
				  	if(data == 'success'){
						window.location.href = '<?php echo base_url(); ?>customer';
					} else if(data == 'usedcode'){
						$('#renuew_msg').html('<span style="color:red;">This Code already used.</span>');
					}else if(data == 'invalidcode'){
						$('#renuew_msg').html('<span style="color:red;">This Code is Invalid.</span>');
					}
				  }
			   });
		  } else{
		  	$('#renuew_msg').html('<span style="color:red;">Required Subscription Code.</span>');
		  }
		
	}
  </script>