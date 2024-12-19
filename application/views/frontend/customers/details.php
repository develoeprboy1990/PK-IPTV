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
			        <!--<li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Resend Email </a></li>-->
              <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Subscription </a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" id="tab-menu-3">Devices </a></li>
              <li class=""><a href="#tab_4" data-toggle="tab" id="tab-menu-4">Extra Packages</a></li>
              <li class=""><a href="#tab_7" data-toggle="tab" id="tab-menu-7">Messages</a></li>
              <li class=""><a href="#tab_5" data-toggle="tab" id="tab-menu-5">Log </a></li>
              <li class=""><a href="#tab_6" data-toggle="tab" id="tab-menu-6">Debug Logs </a></li>
              <li class="dropdown pull-right">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Settings <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><?php if($details->status==1){?><a role="menuitem" tabindex="-1" href="<?=site_url('customers/disable/'.$details->id)?>">Disable Customer</a><?php }else{?><a role="menuitem" tabindex="-1" href="<?=site_url('customers/activate/'.$details->id)?>">Enable Customer</a> <?php }?></li>
                </ul>
              </li>
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
                      <form method="post" action="<?= BASE_URL ?>customers/details/<?php echo $details->id?>" enctype="multipart/form-data" class="form-horizontal">
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
                        <!--<div class="row"> 
                          <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone *</label>
                            <div class="col-sm-4">
                             <input type="text" id="phone" name="phone" class="form-control" value="<?php //echo $details->phone; ?>" placeholder="Phone" required/>
                             <span class="text-danger"><?php //echo form_error('phone'); ?></span>
                            </div>
                          </div>
                        </div>-->
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
                        <!--<div class="row"> 
                          <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email *</label>
                            <div class="col-sm-4">
                             <input type="email" id="email" name="email" class="form-control" value="<?=$details->email?>" placeholder="Email" required/>
                             <span class="text-danger"><?= form_error('email'); ?></span>
                            </div>
                          </div>
                        </div>-->
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
                          <label for="allow_theme" class="col-sm-4 control-label">Tester *</label>
                          <div class="col-sm-8">
                            <select id="allow_theme" name="allow_theme" class="form-control">
                                <option value="0" <?php if($details->allow_theme == '0'){ echo 'selected'; }?>>No</option>
                                <option value="1" <?php if($details->allow_theme == '1'){ echo 'selected'; }?>>Yes</option>
                            </select>
                            <span class="text-danger"><?= form_error('allow_theme'); ?></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="is_beta" class="col-sm-4 control-label">isBeta *</label>
                          <div class="col-sm-8">
                            <select id="is_beta" name="is_beta" class="form-control">
                                <option value="0" <?php if($details->is_beta == '0'){ echo 'selected'; }?>>No</option>
                                <option value="1" <?php if($details->is_beta == '1'){ echo 'selected'; }?>>Yes</option>
                            </select>
                            <span class="text-danger"><?= form_error('is_beta'); ?></span>
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
                      <h3>Comments</h3>
                      <form method="post" action="<?= BASE_URL ?>customers/addComments/<?php echo $details->id?>" class="form-horizontal">
                        <div class="form-group">
                          <label for="comments" class="col-sm-4 control-label">Comments *</label>
                          <div class="col-sm-8">
                            <textarea id="comments" name="comments" class="form-control" rows="5" required><?=$details->comments?></textarea>
                            <span class="text-danger"><?= form_error('comments'); ?></span>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-success">Update Comments</button>
                          </div>
                        </div>
                      </form>

                      <?php if($details->is_migrate == 1){?>
                      <h3>Subscription Info</h3>
                        <form method="post" action="<?= BASE_URL ?>customers/setProfile/<?php echo $details->id?>" class="form-horizontal">
                          <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">AccountID *</label>
                            <div class="col-sm-8">
                              <input type="text" id="account_id" name="account_id" class="form-control" value="<?php echo $details->account_id; ?>" placeholder="AccountID" required readonly/>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">uDaysLeft *</label>
                            <div class="col-sm-8">
                              <input type="text" id="days_left" name="days_left" class="form-control" value="<?php echo $details->days_left; ?>" placeholder="uDaysLeft" required readonly/>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">Package *</label>
                            <div class="col-sm-8">
                              <input type="text" id="package" name="package" class="form-control" value="<?php echo $details->package; ?>" placeholder="Package" required readonly/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">Start Date</label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control" value="<?=@$details->vcodelife?>" placeholder="Package" required readonly/>
                            </div>
                          </div>
                        </form>
                        <?php }else{?>

                          <form method="post" action="" class="form-horizontal">
                          
                          <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">Start Date</label>
                            <div class="col-sm-8">
                              <input type="text" readonly class="form-control" value="<?=@$details->vcodelife?>" placeholder="Package" required readonly/>
                            </div>
                          </div>
                        </form>
                       <?php  } ?>

                        
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab_2">
                  <div class="box box-primary">
                    <div class="box-header"><h3>General</h3></div>
                    <div class="box-body">
                        <div class="form-horizontal">
                          <div class="row m-4"> 
                            <div class="form-group">
                              <label for="" class="col-sm-2 control-label">Expire Date</label>
                              <div class="col-sm-4">
                               <h4><?=$details->subscription_expire?></h4>
                              </div>
                            </div>
                          </div>
                        </div>

                        <form method="post" action="<?=site_url('customers/extendDate/'.$details->id)?>" class="form-horizontal">
                        <div class="row m-4"> 
                          <div class="form-group">
                            <label for="extend_date" class="col-sm-2 control-label">Extend Expire Date</label>
                            <div class="col-sm-3">
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="extend_date" name="subscription_expire" value="<?=$details->subscription_expire?>" required>
                              </div>     
                            </div>
                          </div>
                        </div>


                        <div class="row mb-4">
                          <div class="form-group">
                            <label for="extend" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                              <button type="submit" class="btn btn-success">Extend Date</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

				          <div class="box box-primary">
                    <div class="box-header"><h3>Resend Registration</h3></div>
                    <div class="box-body">
                        <form method="post" action="<?=site_url('customers/resendRegistration/'.$details->id)?>" class="form-horizontal">
                        <div class="row m-4"> 
                          <div class="form-group">
                            <label for="extend_date" class="col-sm-2 control-label">Resend Registration</label>
						                <button type="submit" class="btn btn-success">Resend Registration</button>
                          </div>
                        </div>

                        <div class="row mb-4"> 
                          <div class="form-group">
                            <label for="extend" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                             
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
				
                  <div class="box box-primary">
                    <div class="box-header"><h3>Account</h3></div>
                    <div class="box-body">
                        <form method="post" action="<?=site_url('customers/updateWallet/'.$details->id)?>" class="form-horizontal">
                        <div class="row m-4"> 
                          <div class="form-group">
                            <label for="currency" class="col-sm-2 control-label">Currency</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control pull-right" id="currency" name="currency" value="<?=$details->currency?>" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="row m-4"> 
                          <div class="form-group">
                            <label for="wallet_balance" class="col-sm-2 control-label">Wallet Balance</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control pull-right" id="wallet_balance" name="wallet_balance" value="<?=$details->walletbalance?>" required>
                            </div>
                          </div>
                        </div>

                        <div class="row mb-4"> 
                          <div class="form-group">
                            <label for="wallet" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                              <button type="submit" class="btn btn-success">Update Wallet Balance</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="box box-primary">
                    <div class="box-header"><h3>Login</h3></div>
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>UserID</th>
                              <th>Username</th>
                              <th>Password</th>
                              <th>Device Allowed</th>
                            </tr> 
                          </thead>
                          <tbody>
                            <tr>
                              <td><span id="customer-id"><?=$details->id?></span></td>
                              <td><?=$details->email?></td>
                              <td><?=base64_decode($details->password)?></td>
                              <td>
              									<span id="decrement" style="border-radius: 5px;border: 2px solid #00a65a;padding: 5px; cursor:pointer;">
              										<i class="fa fa-minus"></i>
              									</span> 
              									<span id="devices-allowed" style="margin:0 20px;"><?=$details->devices_allowed?></span> 
              									<span id="increment" style="border-radius: 5px;border: 2px solid #00a65a;padding: 5px;cursor:pointer;">
              										<i class="fa fa-plus"></i>
              									</span>
              								</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="box box-primary">
                    <div class="box-header"><h3>Subscription</h3></div>
                    <div class="box-body">
                      <div class="row m-4"> 
                        <div class="form-group">
                          <label for="" class="col-sm-2 control-label">Change Subscription</label>
                          <div class="col-sm-2">
                             <a href="<?=site_url('customers/changeSubscription/'.$details->id)?>" class="btn btn-success">Change Subscription</a>     
                          </div>
                        </div>
                      </div>

                      <div class="table-responsive">

                        <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Product Name</th>
                              <th>Plan Name</th>
                              <th>Start Date</th>
                              <th>Expire Date</th>
                            </tr> 
                          </thead>
                          
                          <tbody>
                            <tr>
                                <td><?=@$current_product->name?></td>
                                <td><?=@$current_plan->name?></td>
                                <td><?=@$details->vcodelife?></td>
                                <td><?=@$details->subscription_expire?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
              </div>                
              <div class="tab-pane" id="tab_3">
                <div class="box-header clearfix">
                    <h3 class="box-title pull-left">Devices</h3>
                    <div class="pull-right">
                        <button id="releaseAllDevices" class="btn btn-danger btn-sm">Release All Devices</button>
                    </div>
                </div>
                <div class="box box-primary">
                  <div class="box-body">
                    <div id="ajax_search_responce" class="table-responsive">
                      <table id="devices" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>UUID</th>
                                  <th>Model</th>
                                  <th>Type</th>
                                  <th>IP Address</th>
                                  <th>Reseller Id</th>
                                  <th>Country</th>
                                  <th>City</th>
                                  <th>State</th>
                                  <th>Appversion</th>
                                  <th>Valid</th>
                                  <th>Action</th>
                              </tr> 
                          </thead>
                          <tbody>
                              <?php
                              if(isset($devices['devices']) && is_array($devices['devices'])):
                                  foreach($devices['devices'] as $device): ?>
                                      <tr>
                                          <td><?= $device['uuid'] ?></td>
                                          <td><?= $device['model'] ?></td>
                                          <td><?= $device['type'] ?></td>
                                          <td><?= $device['ip'] ?></td>
                                          <td><?= $device['resellerId'] ?></td>
                                          <td><?= $device['country'] ?></td>
                                          <td><?= $device['city'] ?></td>
                                          <td><?= $device['state'] ?></td>
                                          <td><?= $device['appversion'] ?></td>
                                          <td><?= date('Y-m-d H:i:s', $device['valid']) ?></td>
                                           <td>
                                             <!--  <a href="<?= site_url('customers/editDevice/'.$details->id.'/'.$device['uuid']) ?>" class="btn btn-primary btn-sm">Edit</a> -->
                                              <a href="<?= site_url('customers/deleteDevice/'.$details->id.'/'.$device['uuid']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this device?')">Release device</a>
                                          </td>
                                      </tr>
                                  <?php endforeach;
                              else: ?>
                                  <tr>
                                      <td colspan="11">No devices found</td>
                                  </tr>
                              <?php endif; ?>
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab_4">
                  <div class="box box-primary">
                    <div class="box-body">
                      <form method="post" action="<?= BASE_URL ?>customers/addPackage/<?=$details->id?>" class="form-horizontal">
                        <div class="row"> 
                          <input type="hidden" name="total_channel_package" id="multiselect_right_package_number">
                          <div class="form-group">
                            <label for="available_packages" class="col-sm-2 control-label">Channel Packages</label>
                            <div class="col-sm-10">
                              <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                                <div class="panel-body" >
                                   <div class="row">
                                     <div class="col-sm-5">
                                         <select name="available_packages" id="multiselect_left_package" class="form-control" size="15" multiple="multiple">
                                            <?php foreach ($packages as $package) { ?>
                                              <option value="<?=$package['id']?>"><?=$package['name']?></option>
                                            <?php }?>
                                         </select>
                                     </div>

                                    <div class="col-sm-2">
                                       <button type="button" id="btn_rightAll_package" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                       <button type="button" id="btn_rightSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                       <button type="button" id="btn_leftSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                       <button type="button" id="btn_leftAll_package" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                    </div>

                                    <div class="col-sm-5">
                                      <select id="multiselect_right_package" class="form-control" name="packages[]" size="15" multiple="multiple">
                                            <?php foreach ($packages as $package) { ?>
                                              <?php if(in_array($package['id'],$selected_packages)) {?>
                                              <option value="<?=$package['id']?>"><?=$package['name']?></option>
                                              <?php }?>
                                            <?php }?>
                                      </select>
                                      <div class="row">
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_up_package" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                        </div>
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_down_package" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row"> 
                          <input type="hidden" name="total_movie_stores" id="multiselect_right_movie_stores_number">
                          <div class="form-group">
                            <label for="available_movie_stores" class="col-sm-2 control-label">Movie Stores</label>
                            <div class="col-sm-10">
                              <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                                <div class="panel-body" >
                                   <div class="row">
                                     <div class="col-sm-5">
                                         <select name="available_movie_stores" id="multiselect_left_movie_stores" class="form-control" size="15" multiple="multiple">
                                            <?php foreach ($movie_stores as $store) { ?>
                                              <option value="<?=$store->id?>"><?=$store->name?></option>
                                            <?php }?>
                                         </select>
                                     </div>

                                    <div class="col-sm-2">
                                       <button type="button" id="btn_rightAll_movie_stores" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                       <button type="button" id="btn_rightSelected_movie_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                       <button type="button" id="btn_leftSelected_movie_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                       <button type="button" id="btn_leftAll_movie_stores" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                    </div>

                                    <div class="col-sm-5">
                                      <select id="multiselect_right_movie_stores" class="form-control" name="movie_stores[]" size="15" multiple="multiple">
                                            <?php foreach ($movie_stores as $store) { ?>
                                              <?php if(in_array($store->id,$selected_movie_stores)) {?>
                                              <option value="<?=$store->id?>"><?=$store->name?></option>
                                              <?php }?>
                                            <?php }?>
                                      </select>
                                      <div class="row">
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_up_movie_stores" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                        </div>
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_down_movie_stores" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row"> 
                          <input type="hidden" name="total_series_stores" id="multiselect_right_series_stores_number">
                          <div class="form-group">
                            <label for="available_series_stores" class="col-sm-2 control-label">Series Stores</label>
                            <div class="col-sm-10">
                              <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                                <div class="panel-body" >
                                   <div class="row">
                                     <div class="col-sm-5">
                                         <select name="available_series_stores" id="multiselect_left_series_stores" class="form-control" size="15" multiple="multiple">
                                            <?php foreach ($series_stores as $store) { ?>
                                              <option value="<?=$store['id']?>"><?=$store['name']?></option>
                                            <?php }?>
                                         </select>
                                     </div>

                                    <div class="col-sm-2">
                                       <button type="button" id="btn_rightAll_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                       <button type="button" id="btn_rightSelected_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                       <button type="button" id="btn_leftSelected_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                       <button type="button" id="btn_leftAll_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                    </div>

                                    <div class="col-sm-5">
                                      <select id="multiselect_right_series_stores" class="form-control" name="series_stores[]" size="15" multiple="multiple">
                                            <?php foreach ($series_stores as $store) { ?>
                                              <?php if(in_array($store['id'],$selected_series_stores)) {?>
                                              <option value="<?=$store['id']?>"><?=$store['name']?></option>
                                              <?php }?>
                                            <?php }?>
                                      </select>
                                      <div class="row">
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_up_series_stores" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                        </div>
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_down_series_stores" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row"> 
                          <input type="hidden" name="total_music_categories" id="multiselect_right_music_categories_number">
                          <div class="form-group">
                            <label for="available_music_categories" class="col-sm-2 control-label">Music Stores</label>
                            <div class="col-sm-10">
                              <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                                <div class="panel-body" >
                                   <div class="row">
                                     <div class="col-sm-5">
                                         <select name="available_music_categories" id="multiselect_left_music_categories" class="form-control" size="15" multiple="multiple">
                                            <?php foreach ($music_categories as $category) { ?>
                                              <option value="<?=$category['id']?>"><?=$category['name']?></option>
                                            <?php }?>
                                         </select>
                                     </div>

                                    <div class="col-sm-2">
                                       <button type="button" id="btn_rightAll_music_categories" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                       <button type="button" id="btn_rightSelected_music_categories" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                       <button type="button" id="btn_leftSelected_music_categories" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                       <button type="button" id="btn_leftAll_music_categories" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                    </div>

                                    <div class="col-sm-5">
                                      <select id="multiselect_right_music_categories" class="form-control" name="music_categories[]" size="15" multiple="multiple">
                                            <?php foreach ($music_categories as $category) { ?>
                                              <?php if(in_array($category['id'],$selected_music_categories)) {?>
                                              <option value="<?=$category['id']?>"><?=$category['name']?></option>
                                              <?php }?>
                                            <?php }?>
                                      </select>
                                      <div class="row">
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_up_music_categories" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                                        </div>
                                        <div class="col-xs-6">
                                          <button type="button" id="multiselect_move_down_music_categories" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row"> 
                          <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                              <button type="submit" class="btn btn-success ">Update Extra Packages</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
              </div>
              <div class="tab-pane" id="tab_7">

                  <div class="box box-primary">
                    <?php if($is_allow->allow_create) {?> 
                      <div class="box-header with-border">
                          <h3 class="box-title">
                            <a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat btn-add-message"><i class="fa fa-plus"></i> Add a Message</a>
                          </h3>
                      </div>
                    <?php } ?>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div id="ajax_search_responce" class="table-responsive">
                        <table id="messages" class="table table-bordered table-striped " style="width: 100%;">
                        <thead>
                          <tr>
                            <th width="20%">Date</th>
                            <th width="60%">Subject</th>
                            <th width="10%">Status</th>
                            <th width="10%">Action</th>
                          </tr> 
                        </thead>
                        
                        <tbody>
                          <?php foreach($messages as $msg){?>
                          <tr>
                            <td><?=$msg['created_date']?></td>
                            <td><?=$msg['subject']?></td>
                            <td><?=$msg['status']?></td>
                            <td></td>                               
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
              </div>
              <div class="tab-pane" id="tab_5">
                  <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div id="ajax_search_responce" class="table-responsive">
                        <table id="logs" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Customer ID</th>
                            <th>Action</th>
                            <th>IP</th>
                            <th>Delete</th>
                          </tr> 
                        </thead>
                        
                        <tbody>
                          <?php foreach($logs as $log){?>
                           <tr>
                              <td><?=date('Y-m-d H:i:s',$log['timestamp'])?></td>
                              <td><?=$log['username']?></td>
                              <td><?=$log['action']?></td>
                              <td><?=$log['client_ip']?></td>
                              <td><?php echo btn_delete(BASE_URL.'customers/deleteLog/'.$log['id'].'/'.$details->id)?></td>
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
              </div>
              <div class="tab-pane" id="tab_6">
                  <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div id="ajax_search_responce" class="table-responsive">
                        <table id="debug_logs" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Customer ID</th>
                            <th>Client</th>
                            <th>Message</th>
                            <th>UID</th>
                            <th>Device Type</th>
                          </tr> 
                        </thead>
                        
                        <tbody>
                          <?php foreach($debug_logs as $log){?>
                           <tr>
                              <td><?=$log['date_str']?></td>
                              <td><?=$log['user_id']?></td>
                              <td><?=$log['client']?></td>
                              <td><?=$log['message']?></td>
                              <td><?=$log['uuid']?></td>
                              <td><?=$log['device_type']?></td>
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <!-- /.box-body -->
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
<div class="modal fade" id="modal-delete-confirmation-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              Are you sure you want to delete this Message ?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-delete-message-confirmed">Delete</button>
          </div>
      </div>
  </div>
</div>
<!--  Modal Create Contact Persons -->
<div class="modal fade" id="modal-create-message">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content loader-parent">
            <div class="modal-header">
                <h5 class="modal-title">Add a Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <?=form_open('', ['id' => 'form-create-message', 'class' => 'cmxform']);?>
                    <div class="message-container"></div>
                    <div class="clearfix">         
                        <div class="form-group clearfix">
                            <label for="name">Subject</label>
                            <?=form_input(['name' => 'subject', 'id' => 'subject', 'class' => 'form-control']);?>
                        </div>
                        
                        <div class="form-group">
                          <label for="body">Message Body</label>
                           <textarea id="body" name="body" class="form-control"></textarea>
                        </div>
                       
                        <div class="form-group clearfix">
                            <input type="hidden" id="customer_id" name="customer_id" value="<?=$details->id?>" />
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-message">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content loader-parent">
            <div class="modal-header">
                <h5 class="modal-title">Edit Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <?=form_open('', ['id' => 'form-update-message', 'class' => 'cmxform']);?>
                    <div class="message-container"></div>
                     <div class="clearfix">
                        <div class="form-group clearfix">
                            <label for="name">Subject</label>
                            <?=form_input(['name' => 'subject', 'id' => 'subject', 'class' => 'form-control']);?>
                        </div>

                        <div class="form-group">
                          <label for="updated-body">Message Body</label>
                          <textarea id="updated-body" name="body" class="form-control"></textarea>
                        </div>
                       
                        <div class="form-group clearfix">
                            <input type="hidden" name="id" value="" />
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-send-confirmation-message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to send this Message?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-send-message-confirmed">Send</button>
            </div>
        </div>
    </div>
  </div>
<script>
//$(document).ready(function(){
//  $("button").click(function(){
function editcheck_email_available(useremail){
    $.ajax({
			url: '<?php echo BASE_URL ?>customers/emailCheckAvailable',
			data: { email: $('#email').val()} ,
			success: function(result){
			  //$("#div1").html(result);
			  if(result == 'available'){
			  	$('#eavamsg').html('<span style="color:#00a65a;">Email is Available.</span>');
			  }else if(result == 'notavailable'){
			  	$('#eavamsg').html('<span style="color:red;">Email already used.</span>');
				$("#email").val(useremail);
			  }else{
			  	$('#eavamsg').html('<span style="color:red;">There is a problem. Please try again.</span>');
				$("#email").val(useremail);
			  }
			  //alert(result);
			}
		});
}

function make_email_change(){
	$("#email").attr("readonly", false); 
	$("#make_change").hide();
	$("#chekavl").show();
}
//  });
//});



  <?php if($this->session->flashdata('success')): ?>
      Swal.fire({
          icon: 'success',
          title: 'Success',
          text: '<?= $this->session->flashdata('success') ?>',
      });
  <?php elseif($this->session->flashdata('error')): ?>
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '<?= $this->session->flashdata('error') ?>',
      });
  <?php elseif($this->session->flashdata('info')): ?>
      Swal.fire({
          icon: 'info',
          title: 'Information',
          text: '<?= $this->session->flashdata('info') ?>',
      });
  <?php endif; ?>
</script>