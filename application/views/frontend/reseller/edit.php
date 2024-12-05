 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>reseller/details/<?php echo $id;?>" class="form-horizontal needs-validation">
             
			
              <div class="row"> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">Name *</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Name" />
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div>
              </div>

              
              <div class="row"> 
                <div class="form-group">
                  <label for="phone" class="col-sm-2 control-label">Mobile *</label>
                  <div class="col-sm-4">
                   <input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo $mobile; ?>" placeholder="Mobile" />
                   <span class="text-danger"><?= form_error('mobile'); ?></span>
                  </div>
                </div>
              </div>

              
              <div class="row"> 
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email *</label>
                  <div class="col-sm-4">
                   <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="Email" readonly="readonly" />
                   <span class="text-danger"><?= form_error('email'); ?></span>
				   
                  </div>
				  
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_country" class="col-sm-2 control-label">Country *</label>
                  <div class="col-sm-4">
                      <select id="billing_country" name="billing_country" class="form-control" >
                        <option value="">Please Select Country</option>
                        <?php foreach($countries as $country){?>
                            <option value="<?=$country->id?>" <?php if($country->id == $billing_country){ echo 'selected'; } ?>><?=$country->name?></option>
                        <?php }?>
                      </select>
					  <span class="text-danger"><?= form_error('billing_country'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">State *</label>
                  <div class="col-md-4">
                    <select id="billing_state" name="billing_state" class="form-control" >
                      <?php foreach($states as $state){?>
                          <option value="<?=$state->id?>" <?php if($state->id == $billing_state){ echo 'selected'; } ?>><?=$state->name?></option>
                      <?php }?>
                    </select>
					<span class="text-danger"><?= form_error('billing_state'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_city" class="col-sm-2 control-label">City *</label>
                  <div class="col-md-4">
                      <input type="text" name="billing_city" class="form-control" value="<?php echo $billing_city; ?>" placeholder="Address" />
                      <!--  <select id="billing_city" name="billing_city" class="form-control" required> 
                        <?php foreach($cities as $city){?>
                          <option value="<?=$city->id?>"><?=$city->name?></option>
                        <?php }?>
                      </select> -->
					  <span class="text-danger"><?= form_error('billing_city'); ?></span>
                  </div>
                </div> 
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_street" class="col-sm-2 control-label">Street *</label>
                  <div class="col-sm-4">
                   <input type="text" id="billing_street" name="billing_street" class="form-control" value="<?php echo $billing_street; ?>" placeholder="Street" />
                   <span class="text-danger"><?= form_error('billing_street'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_zip" class="col-sm-2 control-label">Zip *</label>
                  <div class="col-sm-4">
                   <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="<?php echo $billing_zip; ?>" placeholder="Zip" />
                   <span class="text-danger"><?= form_error('billing_zip'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_zip" class="col-sm-2 control-label">Password*</label>
                  <div class="col-sm-4">
                   <input type="text" id="password" name="password" class="form-control" value="<?php echo $password; ?>" placeholder="Password" />
                   <span class="text-danger"><?= form_error('password'); ?></span>
                  </div>
                </div>
              </div>

			  <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Currency Type *</label>
                  <div class="col-md-4">
                    <select id="currency_type" name="currency_type" class="form-control"> 
						<option value="">Select Currency</option> 
						 <?php foreach(COUNTRY_CURRENCY as $key=>$val){?>
                          <option value="<?php echo $val;?>" <?php if($currency_type == $val){ echo 'selected'; } ?>><?php echo $key;?></option>
                        <?php }?>                   
                        
                    </select>
					<span class="text-danger"><?= form_error('currency_type'); ?></span>
                  </div>
                </div>
              </div>
			  
			  
			   <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Message Customer Dashboard *</label>
                  <div class="col-md-8">
                   <textarea id="customer_msgcontent" name="customer_msgcontent" class="form-control" placeholder="Customer message..." rows="4"><?php echo $customer_msgcontent; ?></textarea>
					<span class="text-danger"><?= form_error('customer_msgcontent'); ?></span>
                  </div>
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Reseller can Edit message? *</label>
                  <div class="col-md-4">
                    <select id="reseller_msgedit" name="reseller_msgedit" class="form-control">
						<option value="0" <?php if($reseller_msgedit == '0'){ echo 'selected'; }?>>No</option>                     
                        <option value="1" <?php if($reseller_msgedit == '1'){ echo 'selected'; }?>>Yes</option>                     	
                    </select>
					<span class="text-danger"><?= form_error('billing_state'); ?></span>
                  </div>
                </div>
              </div>
			  
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Message Reseller To Customer</label>
                  <div class="col-md-8">
                   <textarea id="messageto_customer_reseller" name="messageto_customer_reseller" class="form-control" placeholder="Customer message..." readonly="readonly" rows="4"><?php echo $messageto_customer_reseller; ?></textarea>
					<span class="text-danger"><?= form_error('customer_msgcontent'); ?></span>
                  </div>
                </div>
              </div>
			  
			 
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Can See Customer Password? *</label>
                  <div class="col-md-4">
                    <select id="see_customer_password" name="see_customer_password" class="form-control">
						<option value="0" <?php if($see_customer_password == '0'){ echo 'selected'; }?>>No</option>                     
                        <option value="1" <?php if($see_customer_password == '1'){ echo 'selected'; }?>>Yes</option>                     	
                    </select>
					<span class="text-danger"><?= form_error('billing_state'); ?></span>
                  </div>
                </div>
              </div>
			  
			  <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Reseller can Create Wallet code? *</label>
                  <div class="col-md-4">
                    <select id="can_create_walletcode" name="can_create_walletcode" class="form-control">
						<option value="0" <?php if($can_create_walletcode == '0'){ echo 'selected'; }?>>No</option>                     
                        <option value="1" <?php if($can_create_walletcode == '1'){ echo 'selected'; }?>>Yes</option>                     	
                    </select>
					<span class="text-danger"><?= form_error('can_create_walletcode'); ?></span>
                  </div>
                </div>
              </div>
			  
			  <div class="row" id="wallet_code_discount_div" style="display:<?php if($can_create_walletcode == '1'){ echo 'block'; }else{ echo 'none'; }; ?>"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Wallet code discount(%)</label>
                  <div class="col-md-4">
                    <input type="number" name="wallet_code_discount" id="wallet_code_discount" value="<?php echo $wallet_code_discount;?>" class="form-control"  />
					<span class="text-danger"><?= form_error('wallet_code_discount'); ?></span>
                  </div>
                </div>
              </div>


              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Reseller can View Customer Devices? *</label>
                  <div class="col-md-4">
                    <select id="can_view_devices" name="can_view_devices" class="form-control">
            <option value="0" <?php if($can_view_devices == '0'){ echo 'selected'; }?>>No</option>                     
                        <option value="1" <?php if($can_view_devices == '1'){ echo 'selected'; }?>>Yes</option>                      
                    </select>
          <span class="text-danger"><?= form_error('can_view_devices'); ?></span>
                  </div>
                </div>
              </div>
        

              <div class="row"> 
                <div class="form-group">
                  <label for="plan_type" class="col-sm-2 control-label">Plan Type *</label>
                  <div class="col-md-4">
                    <select id="plan_type" name="plan_type" class="form-control">
						            <option value="1" <?php if($plan_type == '1'){ echo 'selected'; } ?>>Digital Plan</option>                     
                        <option value="2" <?php if($plan_type == '2'){ echo 'selected'; } ?>>Activation/Renewal Plan</option>                     	
                    </select>
					<span class="text-danger"><?= form_error('plan_type'); ?></span>
                  </div>
                </div>
              </div>
			  


              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Status *</label>
                  <div class="col-md-4">
                    <select id="status" name="status" class="form-control">                     
                        <option value="1" <?php if($status == '1'){ echo 'selected'; } ?> >Active</option>
                      	<option value="0" <?php if($status == '0'){ echo 'selected'; } ?> >In-Active</option>
                        <option value="3" <?php if($status == '3'){ echo 'selected'; } ?> >Delete</option>
                    </select>
					<span class="text-danger"><?= form_error('billing_state'); ?></span>
                  </div>
                </div>
              </div>
			
			  
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="submit" class="btn btn-success" name="add_reseller" value="Edit Reseller">
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<script>
//$(document).ready(function(){
//  $("button").click(function(){
function check_email_available(){
    $.ajax({
			url: '<?php echo BASE_URL ?>customers/emailCheckAvailable',
			data: { email: $('#email').val()} ,
			success: function(result){
			  //$("#div1").html(result);
			  if(result == 'available'){
			  	$('#eavamsg').html('<span style="color:#00a65a;">Email is Available.</span>');
			  }else if(result == 'notavailable'){
			  	$('#eavamsg').html('<span style="color:red;">Email already used.</span>');
			  }else{
			  	$('#eavamsg').html('<span style="color:red;">There is a problem. Please try again.</span>');
			  }
			  //alert(result);
			}
		});
}
//  });
//});
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create( document.querySelector( '#messageto_customer_reseller' ) )
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );


ClassicEditor
.create( document.querySelector( '#customer_msgcontent' ) )
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );
</script>