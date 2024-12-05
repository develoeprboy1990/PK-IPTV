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
            <form method="post" action="<?= BASE_URL ?>reseller/addwallet" class="form-horizontal needs-validation">
        		  <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label"><a title="Name" style="cursor:pointer;">Name</a>* </label>
                  <div class="col-md-4">
                    <select id="reseller_id" name="reseller_id" class="form-control"> 
          						<option value="">Select Reseller</option> 
          						 <?php foreach($recellers as $key=>$val){?>
                            <option value="<?php echo @$val['id'];?>" <?php if($reseller_id == @$val['id']){ echo 'selected'; } ?>><?php echo @$val['name'].' ( '.$val['email'].' ) ';?></option>
                          <?php }?> 
                    </select>
          					<span class="text-danger"><?= form_error('reseller_id'); ?></span>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label"><a title="Name" style="cursor:pointer;">Amount *</a></label>
                  <div class="col-sm-4">
                   <input type="text" pattern="[0-9]*[.,]?[0-9]*" id="wallet_money" name="wallet_money" class="form-control" value="<?php echo @$wallet_money; ?>" placeholder="Wallet Money" />
                   <span class="text-danger"><?= form_error('wallet_money'); ?></span>
                  </div>
                </div>
              </div>
			        <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Currency Type *</label>
                  <div class="col-md-4">
                    <select id="currency_type" name="currency_type" class="form-control"> 						
          						<?php foreach(COUNTRY_CURRENCY as $key=>$val){?>
          						 <?php if($currency_type == $val){ ?>
                          <option value="<?php echo @$val;?>" ><?php echo @$key;?></option>
          						 <?php } ?>
                      <?php }?>   
                    </select>
					         <span class="text-danger"><?= form_error('currency_type'); ?></span>
                  </div>
                </div>
              </div>
			        <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label"><a title="paid/unpaid" style="cursor:pointer;">Payment Status *</a></label>
                  <div class="col-md-4">
                    <select id="payment_status" name="payment_status" class="form-control"> 						
          						<option value="notpaid">Not Paid</option>
          						<option value="paid">Paid</option> 
                    </select>
          					<span class="text-danger"><?= form_error('payment_status'); ?></span>
                  </div>
                </div>
              </div>
			        <div class="row"> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label"><a title="message" style="cursor:pointer;">Message *</label>
                  <div class="col-sm-4">
                   <textarea id="message" name="message" class="form-control" rows="6"><?php echo @$message;?></textarea>
                   <span class="text-danger"><?= form_error('message'); ?></span>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="submit" class="btn btn-success" name="add_wallet" value="Add Wallet">
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