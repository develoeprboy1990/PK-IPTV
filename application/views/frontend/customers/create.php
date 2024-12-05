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
            <form method="post" action="<?= BASE_URL ?>customers/create" class="form-horizontal needs-validation">
              <div class="row"> 
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-2">
                      <select id="title" name="title" class="form-control">
                         <option value="Mr." <?php echo (set_value('title') == 'Mr.') ? 'selected' : ''; ?>> Mr.</option>
                         <option value="Mrs." <?php echo (set_value('title') == 'Mrs.') ? 'selected' : ''; ?>> Mrs.</option>
                         <option value="Ms." <?php echo (set_value('title') == 'Ms.') ? 'selected' : ''; ?>> Ms.</option>
                      </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">First Name *</label>
                  <div class="col-sm-4">
                   <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo set_value('first_name'); ?>" placeholder="First Name" required/>
                   <span class="text-danger"><?= form_error('first_name'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Last Name *</label>
                  <div class="col-sm-4">
                   <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo set_value('last_name'); ?>" placeholder="Last Name" required/>
                   <span class="text-danger"><?= form_error('last_name'); ?></span>
                  </div>
                </div>
              </div>

             <!-- <div class="row"> 
                <div class="form-group">
                  <label for="phone" class="col-sm-2 control-label">Phone *</label>
                  <div class="col-sm-4">
                   <input type="text" id="phone" name="phone" class="form-control" value="<?php //echo set_value('phone'); ?>" placeholder="Phone" required/>
                   <span class="text-danger"><?php //echo form_error('phone'); ?></span>
                  </div>
                </div>
              </div>-->

              <div class="row"> 
                <div class="form-group">
                  <label for="mobile" class="col-sm-2 control-label">Mobile *</label>
				          <div class="col-sm-2">
																<select class="form-control" name="c_code">
																			<option value="">Select</option>
																			<?php
                                      foreach(COUNTRY_MOBILE_CODE as $key=>$val){
                                          echo '<option value="'.$key.'" '.set_select('c_code', $key).'>'.$val.'</option>';
                                      }
																			?>
																		</select>
																		<span class="text-danger"><?= form_error('c_code'); ?></span>
															</div>
                  <div class="col-sm-2">
                   <input type="text" id="mobile" name="mobile" class="form-control" value="<?php echo set_value('mobile'); ?>" placeholder="Mobile" required/>
                   <span class="text-danger"><?= form_error('mobile'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email *</label>
                  <div class="col-sm-4">
                   <input type="email" id="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="Email" required/>
                   <span class="text-danger"><?= form_error('email'); ?></span>
				   <span id="eavamsg"></span>
                  </div>
				  <div class="col-sm-4" style="left: -26px;margin-top: 7px;"><a href="#" onclick="check_email_available();return false;">Check Available</a></div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_country" class="col-sm-2 control-label">Country *</label>
                  <div class="col-sm-4">
                      <select id="billing_country" name="billing_country" class="form-control" required>
                        <option value="">Please Select Country</option>
                        <?php foreach($countries as $country){ ?>
                            <option value="<?=$country->id?>" <?php echo set_select('billing_country', $country->id); ?>>
                                <?=$country->name?>
                            </option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
              </div>
              <!--
              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">State *</label>
                  <div class="col-md-4">
                    <select id="billing_state" name="billing_state" class="form-control" required>
                      <?php foreach($states as $state){?>
                          <option value="<?=$state->id?>"><?=$state->name?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>  -->

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">State *</label>
                  <div class="col-md-4">
                     
                    <input type="text" name="billing_state" class="form-control" value="<?php echo set_value('billing_state'); ?>" placeholder="State" required/>
                   
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_city" class="col-sm-2 control-label">City *</label>
                  <div class="col-md-4">
                      <input type="text" name="billing_city" class="form-control" value="<?php echo set_value('billing_city'); ?>" placeholder="Address" required/>
                      <!--  <select id="billing_city" name="billing_city" class="form-control" required> 
                        <?php foreach($cities as $city){?>
                          <option value="<?=$city->id?>"><?=$city->name?></option>
                        <?php }?>
                      </select> -->
                  </div>
                </div> 
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_street" class="col-sm-2 control-label">Street *</label>
                  <div class="col-sm-4">
                   <input type="text" id="billing_street" name="billing_street" class="form-control" value="<?php echo set_value('billing_street'); ?>" placeholder="Street" required/>
                   <span class="text-danger"><?= form_error('billing_street'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_zip" class="col-sm-2 control-label">Zip *</label>
                  <div class="col-sm-4">
                   <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="<?php echo set_value('billing_zip'); ?>" placeholder="Zip" required/>
                   <span class="text-danger"><?= form_error('billing_zip'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="product_id" class="col-sm-2 control-label">Product</label>
                  <div class="col-sm-4">
                      <select id="product_id" name="product_id" class="form-control" required>
                        <option value="">Please Select a Product</option>
                        <?php foreach($products as $product){ ?>
                            <option value="<?=$product['id']?>" <?php echo set_select('product_id', $product['id']); ?>>
                                <?=$product['name']?>
                            </option>
                        <?php } ?>
                      </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="ui" class="col-sm-2 control-label">Plan</label>
                  <div class="col-sm-4">
                    <select name="plan_id" id="plan_id" class="form-control" required> 
                    <?php if(set_value('plan_id')): ?>
                        <!-- We'll populate this via AJAX but need to maintain the selected value -->
                        <option value="<?php echo set_value('plan_id'); ?>" selected>
                            <?php echo $this->reseller_m->getPlanName(set_value('plan_id')); ?>
                        </option>
                    <?php endif; ?>                     
                    </select>
                    <span class="text-danger"><?=form_error('plan_id')?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">Tester *</label>
                  <div class="col-md-4">
                    <select id="allow_theme" name="allow_theme" class="form-control">
                        <option value="0" <?php echo set_select('allow_theme', '0', true); ?>>No</option>
                        <option value="1" <?php echo set_select('allow_theme', '1'); ?>>Yes</option>                     
                    </select>
                    <span class="text-danger"><?= form_error('allow_theme'); ?></span>
                  </div>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group">
                  <label for="billing_state" class="col-sm-2 control-label">isBeta *</label>
                  <div class="col-md-4">
                    <select id="is_beta" name="is_beta" class="form-control">
                        <option value="0" <?php echo set_select('is_beta', '0', true); ?>>No</option>
                        <option value="1" <?php echo set_select('is_beta', '1'); ?>>Yes</option>                     
                    </select>
                    <span class="text-danger"><?= form_error('is_beta'); ?></span>
                  </div>
                </div>
              </div>

              <!-- <div class="row"> 
                <div class="form-group">
                  <label for="devices_allowed" class="col-sm-2 control-label">Devices allowed</label>
                  <div class="col-sm-4">
                   <input type="text" id="devices_allowed" name="devices_allowed" class="form-control" value="5" required/>
                  </div>
                </div>
              </div> -->

              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add Customer</button>
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