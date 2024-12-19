<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(13);  // channel module id

if(!isset($is_allow))
{
    
   redirect('unauthorize', 'refresh');
}
?>  
<style>
  .custom-list {
      list-style-type: none; /* Removes bullet points */
      padding: 0;           /* Removes default padding */
      margin: 0;            /* Removes default margin */
  }

  .custom-list li {
      float: left;          /* Floats the list items to the left */
      margin-right: 10px;   /* Adds some space between the items */
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
      <?php echo $page_title; ?>
      <?php echo $breadcrumb; ?>
  </section>
  <section class="content">
    <div class="row">
       <!-- Main Search Bar -->
          <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">                
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Regular Customers</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Migrate Customer</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Unverified Customer</a></li>
                  <li><a href="#tab_4" data-toggle="tab">Trial Customer</a></li>

<!--                   <div class="col-md-12">
  <div class="input-group mb-3">
    <input type="text" class="form-control" id="main-search" placeholder="Search customers...">
    <div class="input-group-append">
      <button class="btn btn-primary" type="button" id="search-button">Search</button>
    </div>
  </div>
</div> -->

                  <li class="pull-right" style="display: flex; align-items: center; margin-top: 5px;">
                    <div style="margin-right: 10px;">
                        <input type="text" class="form-control" id="main-search" placeholder="Search customers..." style="width: 200px;">
                    </div>
                    <div style="margin-right: 10px;">
                      <a href="#" class="btn btn-primary btn-flat" id="search-button"><i class="fa fa-search"></i>Search</a>
                    </div>
                    <?php if($is_allow->allow_create) { ?>
                        <div>
                            <?php echo anchor('customers/create', '<i class="fa fa-plus"></i> Add a Customer', array('class' => 'btn btn-primary btn-flat')); ?>
                        </div>
                    <?php } ?>
                </li>

                  <!-- <li class="pull-right">
                      <div class="box-header with-border" style="margin-bottom: 0;">
                           <h3 class="box-title">Search Customers</h3>
                           <input type="text" class="form-control" id="main-search" placeholder="Search customers...">
                      </div>
                    <?php if($is_allow->allow_create) {?> 
                      <div class="box-header with-border">
                          <h3 class="box-title"><?php echo anchor('customers/create', '<i class="fa fa-plus"></i> Add a Customer', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                      </div>
                    <?php } ?>
                  </li> -->
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <div class="row">
                      <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                            <div id="ajax_search_responce" class="table-responsive">
                              <?php if($responce = $this->session->flashdata('success')){ ?>
                              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                              <?php } ?>
                              <div class="pull-right">
                                <div style="float:left; margin-top: 5px;">Sort By Reseller: </div>
                                <div style="float:left; margin-left:7px;">
                                  <select class="form-control input-sm" data-control="select2" data-hide-search="true" data-placeholder="Resellers" 
                                    data-kt-ecommerce-product-filter="resellers">                           
                                    <option value="all">All</option>
                                    <option value="Admin">Admin</option>
                                    <?php foreach($resellers as $key=>$val){?>                            
                                    <option value="<?php echo $val['name'];?>"><?php echo $val['name'];?></option>
                                    <?php } ?>                            
                                  </select>
                                </div>
                              </div>
                              <table id="customers" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>S.No</th>
                                    <th>User ID</th>
                                    <th>Pin/Password</th>
                                    <th>Alpha Password</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <td>Plan Status</td>
                                    <th>Status</th>
                                    <th>Reseller Name</th>                    
                                    <th>Action</th>
                                  </tr> 
                                </thead>
                                <tbody>
                                <?php $i=1;
                                foreach($all_customers as $customer){
                                  if($customer['plan_type'] == 'master' && $customer['status'] == '1' && $customer['is_migrate'] == '0' ){ ?>
                                    <tr class="customer-row"  data-type="regular">
                                      <td><?=$i;?></td>
                                      <td><?=$customer['username'];?></td>
                                      <td><?=base64_decode($customer['password'])?></td>
                                      <td><?=base64_decode($customer['alpha_password'])?></td>
                                      <td><?=$customer['first_name']. " ".$customer['last_name'];?></td>
                                      <td><?=$customer['email']?></td>
                                      <td><?=$customer['mobile']?></td>
                                      <td><?=$customer['billing_city']?></td>
                                      <td>
                                      <?php
                                      if($customer['status'] == '0'){
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                                      }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                                      }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                                      $today = date("Y-m-d H:i:s");
                                      $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                                      if($diff_time>0){
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                                      }else{
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                                      }
                                      }
                                      ?>
                                      </td>
                                      <td>
                                      <label class="switch">
                                      <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                                      <span class="slider round"></span>
                                      </label>
                                      </td>
                                      <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                                      <td>
                                        <ul class="custom-list">
                                          <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                          <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                                        </ul>
                                      </td>
                                    </tr>
                                <?php $i++; 
                                  } 
                                }?>
                              </tbody>
                            </table>
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_2">
                    <div class="row">
                    <div class="col-md-12">
                    <div class="box">
                    <div class="box-body">
                    <div id="ajax_search_responce" class="table-responsive">
                    <?php if($responce = $this->session->flashdata('success')){ ?>
                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                    <?php } ?>
                    <table id="migrated-customers" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>S.No</th>
                    <th>User ID</th>
                    <th>Pin/Password</th>
                    <th>Alpha Password</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <td>Plan Status</td>
                    <th>Status</th>
                    <th>Reseller Name</th>  
                    <th>Account ID</th>                  
                    <th>Action</th>
                    </tr> 
                    </thead>
                    <tbody>
                    <?php $i=1;
                    foreach($all_customers as $customer){
                    if($customer['is_migrate'] == 1){ ?>
                    <tr class="customer-row" data-type="migrated">
                    <td><?=$i?></td>
                    <td><?=$customer['username']?></td>
                    <td><?=base64_decode($customer['password'])?></td>
                    <td><?=base64_decode($customer['alpha_password'])?></td>
                    <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                    <td><?=$customer['email']?></td>
                    <td><?=$customer['mobile']?></td>
                    <td><?=$customer['billing_city']?></td>
                    <td>
                    <?php
                    if($customer['status'] == '0'){
                    echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                    }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                    echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                    }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                    $today = date("Y-m-d H:i:s");
                    $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                    if($diff_time>0){
                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                    }else{
                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                    }
                    }
                    ?>
                    </td>
                    <td>
                    <label class="switch">
                    <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                    <span class="slider round"></span>
                    </label>
                    </td>
                    <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                    <td><?php echo $customer['account_id']; ?></td>
                    <td>
                    <ul class="custom-list">
                      <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                      <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                    </ul>
                    </td>
                    </tr>
                    <?php $i++;} } ?>
                    </tbody>
                    </table>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_3">
                    <div class="row">
                    <div class="col-md-12">
                      <div class="box">
                        <div class="box-body">
                          <div id="ajax_search_responce" class="table-responsive">
                            <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                            <?php } ?>
                            <table id="unverified-customers" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>S.No</th>
                                  <th>User ID</th>
                                  <th>Pin/Password</th>
                                  <th>Alpha Password</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th>
                                  <td>Plan Status</td>
                                  <th>Status</th>
                                  <th>Reseller Name</th>  
                                  <th>Account ID</th>                  
                                  <th>Action</th>
                                </tr> 
                              </thead>
                              <tbody>
                              <?php $i=1;
                              foreach($all_customers as $customer){
                                if($customer['is_migrate'] == 2 || $customer['status'] == 0){ ?>
                                <tr class="customer-row" data-type="unverified">
                                  <td><?=$i?></td>
                                  <td><?=$customer['username']?></td>
                                  <td><?=base64_decode($customer['password'])?></td>
                                  <td><?=base64_decode($customer['alpha_password'])?></td>
                                  <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                                  <td><?=$customer['email']?></td>
                                  <td><?=$customer['mobile']?></td>
                                  <td><?=$customer['billing_city']?></td>
                                  <td>
                                  <?php
                                  if($customer['status'] == '0'){
                                    echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                                  }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                                    echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                                  }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                                    $today = date("Y-m-d H:i:s");
                                    $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                                    if($diff_time>0){
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                                    }else{
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                                    }
                                  }
                                  ?>
                                  </td>
                                  <td>
                                  <label class="switch">
                                  <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                                  <span class="slider round"></span>
                                  </label>
                                  </td>
                                  <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                                  <td><?php echo $customer['account_id']; ?></td>
                                  <td>
                                    <ul class="custom-list">
                                      <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                      <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                                      <li><button title="Resend Verification" class="btn btn-info btn-xs resend-verification" data-id="<?=$customer['id']?>">Resend</button></li>
                                      <li><button title="Manually Verify" class="btn btn-success btn-xs manual-verify" data-id="<?=$customer['id']?>">Verify</button></li>


                                    </ul>
                                  </td>
                                </tr>
                              <?php $i++; } } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab_4">
                    <div class="row">
                    <div class="col-md-12">
                      <div class="box">
                        <div class="box-body">
                          <div id="ajax_search_responce" class="table-responsive">
                            <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                            <?php } ?>
                            <table id="trial-customers" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>S.No</th>
                                  <th>User ID</th>
                                  <th>Pin/Password</th>
                                  <th>Alpha Password</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th>
                                  <td>Plan Status</td>
                                  <th>Status</th>
                                  <th>Reseller Name</th>                    
                                  <th>Action</th>
                                </tr> 
                              </thead>
                              <tbody>
                              <?php $i=1;
                              foreach($all_customers as $customer){
                                if($customer['plan_type'] == 'trial'){ ?>
                                <tr class="customer-row" data-type="trial">
                                  <td><?=$i?></td>
                                  <td><?=$customer['username']?></td>
                                  <td><?=base64_decode($customer['password'])?></td>
                                  <td><?=base64_decode($customer['alpha_password'])?></td>
                                  <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                                  <td><?=$customer['email']?></td>
                                  <td><?=$customer['mobile']?></td>
                                  <td><?=$customer['billing_city']?></td>
                                  <td>
                                  <?php
                                  if($customer['status'] == '0'){
                                    echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                                  }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                                    echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                                  }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                                    $today = date("Y-m-d H:i:s");
                                    $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                                    if($diff_time>0){
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                                    }else{
                                      echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                                    }
                                  }
                                  ?>
                                  </td>
                                  <td>
                                  <label class="switch">
                                  <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                                  <span class="slider round"></span>
                                  </label>
                                  </td>
                                  <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                                  <td>
                                    <ul class="custom-list">
                                      <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                      <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                                    </ul>
                                  </td>
                                </tr>
                              <?php $i++;} } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- nav-tabs-custom -->
            </div>
        </div>

<!--  <div class="row">
      <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Regular Customers</a></li>
              <li><a href="#tab_2" data-toggle="tab">Migrate Customer</a></li>
              <li><a href="#tab_3" data-toggle="tab">Unverified Customer</a></li>
              <li><a href="#tab_4" data-toggle="tab">Trial Customer</a></li>
              <li class="pull-right">
                <?php if($is_allow->allow_create) {?> 
                  <div class="box-header with-border">
                      <h3 class="box-title"><?php echo anchor('customers/create', '<i class="fa fa-plus"></i> Add a Customer', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                  </div>
                <?php } ?>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                 <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                        <div id="ajax_search_responce" class="table-responsive">
                          <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                          <?php } ?>
                          <div class="pull-right">
                            <div style="float:left;    margin-top: 5px;">Sort By Reseller: </div>
                            <div style="float:left; margin-left:7px;">
                              <select class="form-control input-sm" data-control="select2" data-hide-search="true" data-placeholder="Sesellers" 
                                data-kt-ecommerce-product-filter="resellers">                           
                                <option value="all">All</option>
                                <option value="Admin">Admin</option>
                                <?php foreach($resellers as $key=>$val){?>                            
                                <option value="<?php echo $val['name'];?>"><?php echo $val['name'];?></option>
                                <?php } ?>                            
                              </select>
                            </div>
                          </div>
                          <table id="customers" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>User ID</th>
                                <th>Pin/Password</th>
                                <th>Alpha Password</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <td>Plan Status</td>
                                <th>Status</th>
                                <th>Reseller Name</th>                    
                                <th>Action</th>
                              </tr> 
                            </thead>
                            <tbody>
                            <?php foreach($customers as $customer){?>
                            <tr>
                              <td><?=$customer['username']?></td>
                              <td><?=base64_decode($customer['password'])?></td>
                              <td><?=base64_decode($customer['alpha_password'])?></td>
                              <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                              <td><?=$customer['email']?></td>
                              <td><?=$customer['mobile']?></td>
                              <td><?=$customer['billing_city']?></td>
                              <td>
                              <?php
                              if($customer['status'] == '0'){
                              //echo '<i class="fi fi-tr-circle-xmark" style="color: #cc0000;font-size: 30px;"></i>';
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                              }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                              //echo '<i class="fi fi-tr-clipboard-list-check" style="color: #4287f5;font-size: 30px;"></i>';                                 
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                              }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                              $today = date("Y-m-d H:i:s");
                              $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                              if($diff_time>0){
                              //echo '<i class="fi fi-tr-check-double" style="color: #14b50e;font-size: 30px;"></i>';                                 
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                              }else{
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                              //echo '<i class="fi fi-bs-badge-check" style="color: #ffcc00;font-size: 30px;"></i>';

                              }
                              }
                              ?>
                              </td>
                              <td><?php //echo ($customer['status']==1) ? "Active" : "Disabled" ?>
                              <label class="switch">
                              <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                              <span class="slider round"></span>
                              </label>
                              </td>
                              <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                              <td>
                                <?php //echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?>
                                <?php //echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?>

                                <ul class="custom-list">
                                  <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                  <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                              
                                </ul>
                              </td>
                            </tr>
                            <?php }?>
                          </tbody>
                        </table>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              <div class="tab-pane" id="tab_2">
                 <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                        <div id="ajax_search_responce" class="table-responsive">
                          <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                          <?php } ?>
                          <table id="migrated-customers" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>User ID</th>
                                <th>Pin/Password</th>
                                <th>Alpha Password</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <td>Plan Status</td>
                                <th>Status</th>
                                <th>Reseller Name</th>  
                                <th>Account ID</th>                  
                                <th>Action</th>
                              </tr> 
                            </thead>
                            <tbody>
                            <?php foreach($migratedCustomers as $customer){?>
                            <tr>
                              <td><?=$customer['username']?></td>
                              <td><?=base64_decode($customer['password'])?></td>
                              <td><?=base64_decode($customer['alpha_password'])?></td>
                              <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                              <td><?=$customer['email']?></td>
                              <td><?=$customer['mobile']?></td>
                              <td><?=$customer['billing_city']?></td>
                              <td>
                              <?php
                              if($customer['status'] == '0'){
                              //echo '<i class="fi fi-tr-circle-xmark" style="color: #cc0000;font-size: 30px;"></i>';
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                              }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                              //echo '<i class="fi fi-tr-clipboard-list-check" style="color: #4287f5;font-size: 30px;"></i>';                                 
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                              }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                              $today = date("Y-m-d H:i:s");
                              $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                              if($diff_time>0){
                              //echo '<i class="fi fi-tr-check-double" style="color: #14b50e;font-size: 30px;"></i>';                                 
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                              }else{
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                              //echo '<i class="fi fi-bs-badge-check" style="color: #ffcc00;font-size: 30px;"></i>';

                              }
                              }
                              ?>
                              </td>
                              <td><?php //echo ($customer['status']==1) ? "Active" : "Disabled" ?>
                              <label class="switch">
                              <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                              <span class="slider round"></span>
                              </label>
                              </td>
                              <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                              <td><?php echo $customer['account_id']; ?></td>
                              <td>
                                <?php //echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?>
                                <?php //echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?>

                                <ul class="custom-list">

                                  <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                  
                                  <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                                </ul>
                              </td>
                            </tr>
                            <?php }?>
                          </tbody>
                        </table>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane" id="tab_3">
                 <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                        <div id="ajax_search_responce" class="table-responsive">
                          <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                          <?php } ?>
                          <table id="unverified-customers" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>User ID</th>
                                <th>Pin/Password</th>
                                <th>Alpha Password</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <td>Plan Status</td>
                                <th>Status</th>
                                <th>Reseller Name</th>  
                                <th>Account ID</th>                  
                                <th>Action</th>
                              </tr> 
                            </thead>
                            <tbody>
                            <?php foreach($unverifiedCustomers as $customer){?>
                            <tr>
                              <td><?=$customer['username']?></td>
                              <td><?=base64_decode($customer['password'])?></td>
                              <td><?=base64_decode($customer['alpha_password'])?></td>
                              <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                              <td><?=$customer['email']?></td>
                              <td><?=$customer['mobile']?></td>
                              <td><?=$customer['billing_city']?></td>
                              <td>
                              <?php
                              if($customer['status'] == '0'){
                              //echo '<i class="fi fi-tr-circle-xmark" style="color: #cc0000;font-size: 30px;"></i>';
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                              }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                              //echo '<i class="fi fi-tr-clipboard-list-check" style="color: #4287f5;font-size: 30px;"></i>';                                 
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                              }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                              $today = date("Y-m-d H:i:s");
                              $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                              if($diff_time>0){
                              //echo '<i class="fi fi-tr-check-double" style="color: #14b50e;font-size: 30px;"></i>';                                 
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                              }else{
                              echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                              //echo '<i class="fi fi-bs-badge-check" style="color: #ffcc00;font-size: 30px;"></i>';

                              }
                              }
                              ?>
                              </td>
                              <td><?php //echo ($customer['status']==1) ? "Active" : "Disabled" ?>
                              <label class="switch">
                              <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                              <span class="slider round"></span>
                              </label>
                              </td>
                              <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                              <td><?php echo $customer['account_id']; ?></td>
                              <td>
                                <?php //echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?>
                                <?php //echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?>

                                <ul class="custom-list">

                                  <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                  
                                  <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>

                                 
                                </ul>
                              </td>
                            </tr>
                            <?php }?>
                          </tbody>
                        </table>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane" id="tab_4">
                 <div class="row">
                  <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                        <div id="ajax_search_responce" class="table-responsive">
                          <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                          <?php } ?>
                          <table id="trial-customers" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>User ID</th>
                                <th>Pin/Password</th>
                                <th>Alpha Password</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <td>Plan Status</td>
                                <th>Status</th>
                                <th>Reseller Name</th>                    
                                <th>Action</th>
                              </tr> 
                            </thead>
                            <tbody>
                            <?php foreach($trialCustomers as $customer){?>
                            <tr>
                              <td><?=$customer['username']?></td>
                              <td><?=base64_decode($customer['password'])?></td>
                              <td><?=base64_decode($customer['alpha_password'])?></td>
                              <td><?=$customer['first_name']. " ".$customer['last_name']?></td>
                              <td><?=$customer['email']?></td>
                              <td><?=$customer['mobile']?></td>
                              <td><?=$customer['billing_city']?></td>
                              <td>
                              <?php
                              if($customer['status'] == '0'){
                                echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/cross_red.png" alt="Trial" width="50" />';
                              }elseif(($customer['sebscription_trpe'] == '') && ($customer['status'] == '1')){
                                echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/pending_tick_blue.png" alt="Trial" width="50" />';
                              }elseif(($customer['subscription_expire'] != '0000-00-00 00:00:00') && ($customer['status'] == '1')){
                                $today = date("Y-m-d H:i:s");
                                $diff_time=((strtotime($customer['subscription_expire']) - strtotime($today)));
                                if($diff_time>0){
                                  echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/dark_green_check.png" alt="Trial" width="50" />';
                                }else{
                                  echo '<img src="'.DEFAULT_ASSETS_CUSTOMER_NEW.'media/avatars/yellow_check.png" alt="Trial" width="50" />';
                                }
                              }
                              ?>
                              </td>
                              <td>
                              <label class="switch">
                              <input type="checkbox" <?=($customer['status']==1) ? "checked" : "" ?>>
                              <span class="slider round"></span>
                              </label>
                              </td>
                              <td><?php echo ($customer['reseller_name'] != '') ? $customer['reseller_name'] : 'Admin';?></td>
                              <td>
                                <ul class="custom-list">
                                  <li><button title="Edit"><?php echo btn_edit(BASE_URL.'customers/details/'.$customer['id']);?></button></li>
                                  <li><button title="Delete"><?php echo btn_delete(BASE_URL.'customers/delete/'.$customer['id'])?></button></li>
                                </ul>
                              </td>
                            </tr>
                            <?php }?>
                          </tbody>
                        </table>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div> -->
  </section>
</div>
 <style>
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 17px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 10px;
  width: 11px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-straight/css/uicons-bold-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css'>                  