<script type="text/javascript">
  $(document).ready(function(){

    	function IsEmail(email) {
			  var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			  return regex.test(email);
			}


		var countdownvar = "<?php echo $count_down;?>";

		if(countdownvar == 'authcountdown'){
			OTPcountDown();
		}

		// New code for toggling between email and SMS input
    $('input[name="reset_method"]').change(function() {
      if ($(this).val() === 'email') {
        $('#email-input').show();
        $('#mobile-input').hide();
      } else {
        $('#email-input').hide();
        $('#mobile-input').show();
      }
    });

    $('#forget_password').click(function(){ 
      var reset_method = $('input[name="reset_method"]:checked').val();
      var email = '';
      var mobile = '';
      var c_code = '';

      $('#msgalert').html(''); // Clear previous messages
      $('#msgalert_success').html('');
      
      if (reset_method === 'email') {
        email = $('#email').val();
        if(email == ''){
          $('#msgalert').html('<p style="color:red;">Please enter Email</p>'); 
          return;
        }
        if(IsEmail(email) == false){
          $('#msgalert').html('<p style="color:red;">Please enter valid Email</p>');
          return;
        }
      } 
      else {
        c_code = $('#kt_ecommerce_select2_country').val();
        mobile = $('input[name="mobile"]').val();
        if(c_code == '' || mobile == ''){
          $('#msgalert').html('<p style="color:red;">Please enter Country Code and Mobile Number</p>'); 
          return;
        }
      }

      $(this).find('.indicator-label').hide();
      $(this).find('.indicator-progress').show();
      $(this).prop('disabled', true);
      
      $.ajax({
        url: "<?php echo base_url(); ?>customer/customerforgetpass_send",
        method: "POST",
        data: {
          email: email, 
          mobile: mobile,
          c_code: c_code,
          reset_method: reset_method
        },
        success: function(data){
          console.log("AJAX response:", data);
          var response = JSON.parse(data);
          if(response.success) {
            window.location.href = "<?php echo base_url(); ?>customer/forgetpassword_success?method=" + reset_method;
          } else {
            $('#msgalert').html('<p style="color:red;">' + response.message + '</p>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error("AJAX error:", textStatus, errorThrown);
          $('#msgalert').html('<p style="color:red;">An error occurred. Please try again.</p>');
        },
        complete: function() {
          $('#forget_password').find('.indicator-label').show();
          $('#forget_password').find('.indicator-progress').hide();
          $('#forget_password').prop('disabled', false);
        }
      });
    });

		$('#forget_password_v1').click(function(){ 
	    var email = $('#email').val();
	    console.log("Email entered:", email);
	    
	    var reset_method = $('input[name="reset_method"]:checked').val();

	    $('#msgalert').html(''); // Clear previous messages
	    $('#msgalert_success').html('');
	    
	    if(email == ''){
	        $('#msgalert').html('<p style="color:red;">Please enter Email</p>'); 
	    }
	    else if(IsEmail(email)==false){
	        console.log("Email validation failed");
	        $('#msgalert').html('<p style="color:red;">Please enter valid Email</p>');
	    }
	    else {
	        console.log("Email validation passed");
	        $(this).find('.indicator-label').hide();
	        $(this).find('.indicator-progress').show();
	        $(this).prop('disabled', true);
	        
	        $.ajax({
		        url: "<?php echo base_url(); ?>customer/customerforgetpass_send",
		        method: "POST",
		        data: {email : email, reset_method : reset_method},
		        success: function(data){
		            console.log("AJAX response:", data);
		            var response = JSON.parse(data);
		            if(response.success) {
		                window.location.href = "<?php echo base_url(); ?>customer/forgetpassword_success?email=" + encodeURIComponent(email) + "&method=" + reset_method;
		            } else {
		                $('#msgalert').html('<p style="color:red;">' + response.message + '</p>');
		            }
		        },
		        error: function(jqXHR, textStatus, errorThrown) {
		            console.error("AJAX error:", textStatus, errorThrown);
		            $('#msgalert').html('<p style="color:red;">An error occurred. Please try again.</p>');
		        },
		        complete: function() {
		            $('#forget_password').find('.indicator-label').show();
		            $('#forget_password').find('.indicator-progress').hide();
		            $('#forget_password').prop('disabled', false);
		        }
		    });
	    }
	});

		$('#forget_password_old').click(function(){ 
			var email = $('#email').val();
			console.log("Email entered:", email);
			
			var send_by_email = '';
			var send_by_sms = '';

			$('#msgalert').html(''); // Clear previous messages
  		$('#msgalert_success').html('');
			
			var reset_method = $('input[name="reset_method"]:checked').val();
			
			//alert(send_sms);
			$('#msgalert').html('');
			$('#msgalert_success').html('');
			if(email == ''){
				$('#msgalert').html('<p style="color:red;">Please enter Email</p>'); 
			} else if(IsEmail(email)==false){
				 console.log("Email validation failed");
				$('#msgalert').html('<p style="color:red;">Please enter valid Email</p>');
			}else{
				 console.log("Email validation passed");
				$('#forget_password').css({'display':'none'});
		  		$('#waittext').css({'display':'block'});
				
				$.ajax({
				  url:"<?php echo base_url(); ?>customer/customerforgetpass_send",
				  method:"POST",
				  data:{email : email, reset_method : reset_method},
				  success:function(data){
				  	console.log("AJAX response:", data);
					if(reset_method == 'email' ){
						$('#msgalert_success').html('<p style="color:#00a65a;font-size: 16px;font-weight: bold;">Password has been sent to your Email</p>');
						$('#forget_password').css({'display':'block'});
		  				$('#waittext').css({'display':'none'});
					}
					else if(reset_method == 'sms' ){
						$('#msgalert_success').html('<p style="color:#00a65a;font-size: 16px;font-weight: bold;">Password has been sent to your SMS</p>');
						$('#forget_password').css({'display':'block'});
		  				$('#waittext').css({'display':'none'});
					}
					else if(data == 'nodata'){
						$('#msgalert_success').html('<p style="color:red;font-size: 16px;font-weight: bold;">Email not in system</p>');
						$('#forget_password').css({'display':'block'});
						$('#waittext').css({'display':'none'});
					}
					else{
						$('#msgalert_success').html('<p style="color:red;font-size: 16px;font-weight: bold;">Error . Try again</p>');
						$('#forget_password').css({'display':'block'});
						$('#waittext').css({'display':'none'});
					}
					// $('#billing_state').html(data);
					 //$('#billing_city').html('<option value="">Select City</option>');
				  },
				  error: function(jqXHR, textStatus, errorThrown) {
				    console.error("AJAX error:", textStatus, errorThrown);
				    $('#msgalert').html('<p style="color:red;">An error occurred. Please try again.</p>');
				    $('#forget_password').css({'display':'block'});
				    $('#waittext').css({'display':'none'});
				  }
				});
			}
		});

    $('#submitbtn').click(function(){ 
		  /*$('#submitbtn').css({'display':'none'});
		  $('#waittext').css({'display':'block'});	*/	 
          var user_id = $('#user_id').val();
		  var code_1 = $('#code_1').val();
          var code_2 = $('#code_2').val();
		  var code_3 = $('#code_3').val();
		  var code_4 = $('#code_4').val();
		  var code_5 = $('#code_5').val();
		  var code_6 = $('#code_6').val();
		  var vcode = code_1+code_2+code_3+code_4+code_5+code_6;
          if(user_id != '' && code_1 != '' && code_2 != ''&& code_3 != ''&& code_4 != ''&& code_5 != ''&& code_6 != '' ){
           $.ajax({
              url:"<?php echo base_url(); ?>customer/verification",
              method:"POST",
              data:{user_id:user_id, vcode:vcode},
              success:function(data){
			  	if(data == 'expire' ){
					$('#msgalert').html('<p style="color:red;">OTP expire</p>');
					$('#submitbtn').css({'display':'block'});
				    $('#waittext').css({'display':'none'});
				}else if(data == 'success' ){
					window.location.href = '<?php echo base_url(); ?>customer/customerlogin';
				}  else if(data == 'error'){
					$('#msgalert').html('<p style="color:red;">Enter Valid Code</p>');
					$('#submitbtn').css({'display':'block'});
				    $('#waittext').css({'display':'none'});
				}
                // $('#billing_state').html(data);
                 //$('#billing_city').html('<option value="">Select City</option>');
              }
            });
          }
          else{
                $('#msgalert').html('<p style="color:red;">Enter 6 code value</p>');
              	$('#submitbtn').css({'display':'block'});
				$('#waittext').css({'display':'none'});
            }
        });
       
  });
	
	function inputfocus(cid,nid){
		var cid = $('#code_'+cid).val();
		if(cid != ''){
			//$('#code_'+nid).val('');		
			$('#code_'+nid).focus();
			
		}
	}

	function onafterpaste(f,elm) {
	  setTimeout(function() {f(elm)},0);
	}

	function  myFunction(elm) {
	  var pasteval = elm.value;
	  var j = 1;
	  var c = '';
	  for(var i=0;i<=5;i++ ){
	  	c = pasteval.charAt(i);
		$('#code_'+j).blur();
	  	$('#code_'+j).val(c);
		j++;
	  }
	}
	
	function resendOTP(){ 
			var user_id = $('#user_id').val();		
			$.ajax({
					  url:"<?php echo base_url(); ?>customer/resendcode",
					  method:"POST",
					  data:{user_id:user_id},
					  success:function(data){
						if(data == 'success' ){
							OTPcountDown();
						} 
					  }
					});
			
	}

	function OTPcountDown(){
			const now_time = new Date();
			var minutes_get = now_time.getMinutes();
			var setmin = minutes_get+parseInt('<?php echo OTP_VAL_TIME;?>')
			
			now_time.setMinutes(setmin);
			// Set the date we're counting down to
			var countDownDate = new Date(now_time).getTime();
			
			// Update the count down every 1 second
			var x = setInterval(function() {
			
			  // Get today's date and time
			  var now = new Date().getTime();
			
			  // Find the distance between now and the count down date
			  var distance = countDownDate - now;
			
			  // Time calculations for days, hours, minutes and seconds
			 // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			 // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			
			  // Display the result in the element with id="demo"
			  /*document.getElementById("demo").innerHTML = days + "d " + hours + "h "
			  + minutes + "m " + seconds + "s ";*/
			  document.getElementById("countdown_auth").innerHTML = 'OTP Expire in : '+minutes + "m "+ seconds + "s ";
			
			  // If the count down is finished, write some text
			  if (distance < 0) {
				clearInterval(x);
				document.getElementById("countdown_auth").innerHTML = "<span onclick='resendOTP()'  style='cursor: pointer;color: red;'>RESEND</span>";
			  }
			}, 1000);}
</script>