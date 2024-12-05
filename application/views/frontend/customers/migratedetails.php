 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
      <span class="text-gray-600">Customer Type: <b><?php echo $customer_type; ?></b></span>
       <?php echo $breadcrumb; ?>
    </section>
 
    <!-- Main content -->
     <section class="content loader-parent">
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" id="customer-id" value="<?=$details->id?>">
            <div class="nav-tabs-custom"> 
              <ul class="nav nav-tabs">
                <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Info</a></li>
              </ul>
              <div class="message-container" style="margin-top: 10px;"></div>
              <div class="tab-content">
                <?php if($responce = $this->session->flashdata('success')){ ?>
                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                <?php } ?>

                <?php if($responce = $this->session->flashdata('error')){ ?>
                    <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $responce;?></div>
                <?php } ?>

                <div class="tab-pane active" id="tab_1">
                    <div class="box box-primary">
                      <div class="row box-body">
                        <div class="col-md-6">
                          <h3>Edit Customer</h3>
                          <form method="post" action="<?= BASE_URL ?>customers/migratedetails/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="id" value="<?=$details->id?>">
                            
                            <!-- Form fields for customer details -->
                            <div class="form-group">
                            <label for="title" class="col-sm-4 control-label">Title</label>
                            <div class="col-sm-8">
                            <select id="title" name="title" class="form-control">
                            <option value="Mr." <?=($details->title=="Mr.") ? "selected": ""?>>Mr.</option>
                            <option value="Mrs." <?=($details->title=="Mrs.") ? "selected": ""?>>Mrs.</option>
                            <option value="Ms." <?=($details->title=="Ms.") ? "selected": ""?>>Ms.</option>
                            </select>
                            </div>
</div>
                            <div class="form-group">
                            <label for="first_name" class="col-sm-4 control-label">First Name *</label>
                            <div class="col-sm-8">
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?=$details->first_name?>" placeholder="First Name" required/>
                            <span class="text-danger"><?= form_error('first_name'); ?></span>
                            </div>
</div>
                            <div class="form-group">
                            <label for="last_name" class="col-sm-4 control-label">Last Name *</label>
                            <div class="col-sm-8">
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?=$details->last_name?>" placeholder="Last Name" required/>
                            <span class="text-danger"><?= form_error('last_name'); ?></span>
                            </div>
</div>
                            <div class="form-group">
                              <label for="mobile" class="col-sm-4 control-label">Mobile *</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="c_code">
                                      <option value="">Select</option>
                                      <?php
                                        foreach(COUNTRY_MOBILE_CODE as $key=>$val){
                                          if($key == $details->c_code){
                                            echo '<option value="'.$key.'" selected>'.$val.'</option>';
                                          } else {
                                            echo '<option value="'.$key.'">'.$val.'</option>';
                                          }                                         
                                        }
                                      ?>
                                    </select>
                                    <span class="text-danger"><?= form_error('c_code'); ?></span>
                              </div>
                              <div class="col-sm-4">
                               <input type="text" id="mobile" name="mobile" class="form-control" value="<?=$details->mobile?>" placeholder="Mobile" required/>
                               <span class="text-danger"><?= form_error('mobile'); ?></span>
                              </div>
</div>
                            <div class="form-group">
                              <label for="billing_country" class="col-sm-4 control-label">Country *</label>
                              <div class="col-sm-8">
                                  <select id="billing_country" name="billing_country" class="form-control" required>
                                    <option selected>Please Select Country</option>
                                    <?php foreach($countries as $country){?>
                                        <option value="<?=$country->id?>" <?=($country->id==$details->billing_country) ? "selected":""?>><?=$country->name?></option>
                                    <?php }?>
                                  </select>
                              </div>
</div>                                        
                            <div class="form-group">
                              <label for="billing_state" class="col-sm-4 control-label">State *</label>
                              <div class="col-md-8">
                                <!-- <select id="billing_state" name="billing_state" class="form-control" required>
                                  <?php foreach($billing_states as $state){?>
                                      <option value="<?=$state->id?>" <?=($state->id==$details->billing_state) ? "selected":""?>><?=$state->name?></option>
                                  <?php }?>
                                </select>  -->

                                <input type="text" name="billing_state" class="form-control" value="<?php echo $details->billing_state; ?>" required/>
                                 
                              </div>
</div>
                            <div class="form-group">
                              <label for="billing_city" class="col-sm-4 control-label">City *</label>
                              <div class="col-md-8">
                                  <input type="text" name="billing_city" class="form-control" value="<?php echo $details->billing_city; ?>" required/>
                                  <!-- <select id="billing_city" name="billing_city" class="form-control" required> 
                                    <?php foreach($billing_cities as $city){?>
                                      <option value="<?=$city->id?>" <?=($city->id==$details->billing_city) ? "selected":""?>><?=$city->name?></option>
                                  <?php }?>
                                  </select> -->
                              </div>
</div>
                            <div class="form-group">
                              <label for="billing_street" class="col-sm-4 control-label">Street *</label>
                              <div class="col-sm-8">
                               <input type="text" id="billing_street" name="billing_street" class="form-control" value="<?=$details->billing_street?>" placeholder="Street" required/>
                               <span class="text-danger"><?= form_error('billing_street'); ?></span>
                              </div>
</div>                                           
                            <div class="form-group">
                              <label for="billing_zip" class="col-sm-4 control-label">Zip *</label>
                              <div class="col-sm-8">
                               <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="<?=$details->billing_zip?>" placeholder="Zip" required/>
                               <span class="text-danger"><?= form_error('billing_zip'); ?></span>
                              </div>
</div>
                            <div class="form-group">
                              <label for="billing_state" class="col-sm-4 control-label">Tester *</label>
                              <div class="col-sm-8">
                                <select id="allow_theme" name="allow_theme" class="form-control">
                                    <option value="0" <?php if($details->allow_theme == '0'){ echo 'selected'; }?>>No</option>
                                    <option value="1" <?php if($details->allow_theme == '1'){ echo 'selected'; }?>>Yes</option>
                                </select>
                                <span class="text-danger"><?= form_error('allow_theme'); ?></span>
                              </div>
</div>
                            <div class="form-group">
                              <label for="email" class="col-sm-4 control-label">Login Id Email *</label>
                              <div class="col-sm-6">
                               <input type="email" id="email" name="email" class="form-control" value="<?=$details->email?>" placeholder="Email" required readonly/>
                               <span class="text-danger"><?= form_error('email'); ?></span>
                              <span id="eavamsg"></span>
                            </div>
                            <div class="col-sm-2" style="left: -26px;margin-top: 7px;">
                            <span id="make_change" ><a href="#" onclick="make_email_change();return false;">Make Change</a></span>
                            <span id="chekavl" style="display:none;"><a href="#" onclick="editcheck_email_available('<?=$details->email?>');return false;">Check Available</a></span>
                            </div>

</div>                                           
                            <div class="form-group">
                              <label for="" class="col-sm-4 control-label">Username</label>
                              <div class="col-sm-8">
                               <input type="text" id="" name="" class="form-control" value="<?=$details->username?>" disabled/>
                              </div>
</div>                                            
                            <div class="form-group">
                              <label for="password" class="col-sm-4 control-label">Password</label>
                              <div class="col-sm-8">
                               <input type="text" id="password" name="password" class="form-control" value="<?=base64_decode($details->password)?>"/>
                               <span class="text-danger"><?= form_error('password'); ?></span>
                              </div>
</div>                                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label"></label>
                              <div class="col-sm-8">
                                <input type="checkbox" id="change-password" name="change_password" value="1"/> Change Password ?
                              </div>
</div>
                                          
                            <div class="form-group">
                              <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-success">Update Customer</button>
                              </div>
                            </div>
                          </form>
                        </div>

                        <div class="col-md-6">
                          <h3>Subscription Info</h3>
                          <form method="post" action="<?= BASE_URL ?>customers/addComments/<?php echo $details->id?>" class="form-horizontal">
                            <div class="form-group">
                              <label for="comments" class="col-sm-4 control-label">AccountID *</label>
                              <div class="col-sm-8">
                                <?php echo $accountID; ?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="comments" class="col-sm-4 control-label">uDaysLeft *</label>
                              <div class="col-sm-8">
                                <?php echo $uDaysLeft; ?>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-success">Action</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->