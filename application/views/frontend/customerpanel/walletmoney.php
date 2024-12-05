<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(11);  // channel module id

if(!isset($is_allow))
{
    
   redirect('login', 'refresh');
}
?>  
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Wallet Money</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
	  								<?php if($is_allow->allow_create) {?> 
										<div class="box box-primary">
											<div class="box-header"><h4><i class="fa fa-plus"></i>Add Wallet coupon code</h4></div>
											<?php if($responce = $this->session->flashdata('success')){ ?>
												<div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
											<?php } ?>
											<div class="box-body">
											  <form method="post" action="<?= BASE_URL ?>customerpanel/walletmoney" class="form-horizontal">
													<div class="row"> 
													  <div class="form-group">
														<label for="length" class="col-sm-2 control-label">Keycode Length</label>
														<div class="col-sm-4">
														 <input type="text" id="length" name="length" class="form-control" placeholder="10" required/>
														 <span class="text-danger"></span>
														</div>
													  </div>
													</div>
													<div class="row"> 
													  <div class="form-group">
														<label for="prefix-code" class="col-sm-2 control-label">Keycode Prefix</label>
														<div class="col-sm-4">
														 <input type="text" id="prefix-code" name="prefix_code" class="form-control" placeholder="333" required/>
														 <span class="text-danger"></span>
														</div>
													  </div>
													</div>
													<div class="row"> 
													  <div class="form-group">
														<label for="quantity" class="col-sm-2 control-label">Quantity</label>
														<div class="col-sm-4">
														 <input type="text" id="quantity" name="quantity" class="form-control" placeholder="50" required/>
														 <span class="text-danger"></span>
														</div>
													  </div>
													</div>
													<div class="row"> 
													  <div class="form-group">
														<label for="quantity" class="col-sm-2 control-label">Price</label>
														<div class="col-sm-4">
														 <input type="number" id="price" name="price" class="form-control" placeholder="50" required value="<?php echo @$price;?>"/>
														 <span class="text-danger"><?= form_error('quantity'); ?></span>
														</div>
													  </div>
													</div>
													<div class="row"> 
													  <div class="form-group">
														<label class="col-sm-2 control-label"></label>
														<div class="col-sm-4">
														  <input type="submit" class="btn btn-success " name="walet_plans" value="Create Subscription Plans">
														</div>
													  </div>
													</div>
											  </form>
											</div>
										</div>
                   	<?php } ?>
										<div class="box box-primary">
											<div class="box-header"><h4>Wallet coupon</h4></div>
											<div class="box-header">
											 <!-- <span class="pull-right"><span class="export-icon">Export to: </span>
												<a href="<?=site_url('keys/subscriptionExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
												<a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
											  </span> -->
											</div>
											<div class="box-body">
											  <div id="ajax_search_responce">
												<table id="apps" class="table table-bordered table-striped">
												  <thead>
													<tr>
													  <th>Keycode</th>
													  <th>Price</th>
													  <th>Used</th>
													  <th>Status</th>
													  <?php if($is_allow->allow_delete) {?> 											  
													  <th>Action</th>
													  <?php } ?>
													</tr> 
												  </thead>
												  
												  <tbody>
													<?php foreach($wallet_cupons as $key){?>
													 <tr>
														<td><?php echo $key['key_code']; ?></td>
														<td><?php echo $key['price']; ?></td>
														<td><?php echo ($key['used']==1) ? "Used" : "Not-Used"; ?></td>
														<td><?php echo ($key['active']==1) ? "Active" : "Inactive"; ?></td>
														<?php if($is_allow->allow_delete) {?> 
														<td><?php echo btn_delete(BASE_URL.'customerpanel/deletewalletcode/'.$key['id'])?></td>
														<?php } ?>
													</tr>
													<?php }?>
												  </tbody>
												</table>
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
    </section>
</div>