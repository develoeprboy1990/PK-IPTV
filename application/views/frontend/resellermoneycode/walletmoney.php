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
                  <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Reseller Wallet Money</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
	  								<?php if($is_allow->allow_create) {?> 
										<div class="box box-primary">
											<div class="box-header"><h4><i class="fa fa-plus"></i>Add Reseller Wallet coupon code</h4></div>
											<?php if($responce = $this->session->flashdata('success')){ ?>
												<div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
											<?php } ?>
											<div class="box-body">
											  <form method="post" action="<?= BASE_URL ?>reseller/resellermoneycode" class="form-horizontal">
													<div class="row"> 
													  <div class="form-group">
														<label for="length" class="col-sm-2 control-label">Keycode Length<a title="What is Keycode Length"> ? </a>  </label>
														<div class="col-sm-4">
														 <input type="text" id="length" name="length" class="form-control" placeholder="10" required/>
														 <span class="text-danger"></span>
														</div>
													  </div>
													</div>
													<div class="row"> 
													  <div class="form-group">
														<label for="prefix-code" class="col-sm-2 control-label"><a title="What is Keycode Prefix">Keycode Prefix</a></label>
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
														 <input type="text" pattern="[0-9]*[.,]?[0-9]*" id="price" name="price" class="form-control" placeholder="50" required value="<?php echo @$price;?>"/>
														 <span class="text-danger"><?= form_error('quantity'); ?></span>
														</div>
													  </div>
													</div>
													<div class="row"> 
														<div class="form-group">
														  <label for="billing_state" class="col-sm-2 control-label">Currency Type *</label>
														  <div class="col-md-4">
															<select id="currency_type" name="currency_type" class="form-control" required> 
																<option value="">Select Currency</option> 
																 <?php foreach(COUNTRY_CURRENCY as $key=>$val){?>
																  <option value="<?php echo $val;?>"><?php echo $key;?></option>
																<?php }?>                   
																
															</select>
															<span class="text-danger"><?= form_error('currency_type'); ?></span>
														  </div>
														</div>
													  </div>
													  
													<div class="row"> 
													  <div class="form-group">
														<label class="col-sm-2 control-label"></label>
														<div class="col-sm-4">
														  <input type="submit" class="btn btn-success " name="walet_plans" value="Create Money Code">
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
											  <div>
												<table id="resellermoneycode" class="table table-bordered table-striped">
												  <thead>
													<tr>
													  <th>S.No</th>
													  <th><a title="Keycode" style="cursor: pointer;">Keycode</a></th>
													  <th><a title="Price" style="cursor: pointer;">Price</a></th>
													  <th><a title="Used" style="cursor: pointer;">Used</a></th>
													  <th>Status</th>
													  <?php if($is_allow->allow_delete) {?> 											  
													  <th><a title="Delete Record" style="cursor: pointer;">Action</a></th>
													  <?php } ?>
													</tr> 
												  </thead>
												  
												  <tbody>
													<?php $i=1;
													 foreach($wallet_cupons as $key){?>
													    <tr><td><?php echo @$i ?></td>
														<td><?php echo @$key['key_code']; ?></td>
														<td><?php echo @$key['price'].' '.$key['currency_type']; ?></td>
														<td><?php echo @($key['used']==1) ? "<a href='".BASE_URL."reseller/details/".$key['used_by']."' target='_blank'>Reseller</a>" : "Not-Used"; ?></td>
														<td><?php echo @($key['active']==1) ? "Active" : "Inactive"; ?></td>
														<?php if(@$is_allow->allow_delete) {?> 
														<td><?php echo btn_delete(BASE_URL.'reseller/deleteresellermoneycode/'.@$key['id'])?></td>
														<?php $i++ ;} ?>
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