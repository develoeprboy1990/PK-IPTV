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
            <form method="post" action="<?= BASE_URL ?>reseller/addplans" class="form-horizontal needs-validation">
             
			<div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Reseller Name *</label>
                  <div class="col-md-4">
                    <select id="reseller_id" name="reseller_id" class="form-control"> 
						<option value="">Select Reseller</option> 
						 <?php foreach($recellers as $key=>$val){?>
                          <option value="<?php echo $val['id'];?>" <?php if($reseller_id == $val['id']){ echo 'selected'; } ?>><?php echo $val['name'].' ( '.$val['email'].' ) ';?></option>
                        <?php }?>  
                    </select>
					<span class="text-danger"><?= form_error('reseller_id'); ?></span>
                  </div>
                </div>
              </div>
			  
              <div class="row"> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">Code *</label>
                  <div class="col-sm-4">
                   <input type="text" id="key_code" name="key_code" class="form-control" value="<?php echo $key_code; ?>" placeholder="Key Code" />
                   <span class="text-danger"><?= form_error('key_code'); ?></span>
                  </div>
                </div>
              </div> 
			  
			  
              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <input type="submit" class="btn btn-success" name="add_code" value="Add Code">
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