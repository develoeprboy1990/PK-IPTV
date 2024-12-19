<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($is_allow)){    
   redirect('login', 'refresh');
}
?>  
<style>
    select[multiple] {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    select[multiple] option {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
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
            
               <li class="<?php if($active_tab == 'plans'){ echo 'active'; } ?>"><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Select Plans</a></li> 
			   <li class="<?php if($active_tab == 'customer'){ echo 'active'; } ?>"><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Reseller's Plans</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?php if($active_tab == 'customer'){ echo 'active'; } ?>" id="tab_1">
			  	<div class="box-body">
				
				<div class="row"> 
						<div class="row">
						  <div class="col-sm-12">
							  <div id="ajax_search_responce" class="table-responsive">
								<table id="apps_fff" class="table table-bordered table-striped">
								  <thead>
									<tr>
										<th>S.No</th>
									  	<th>Plan Name</th>
									  	<th>Product</th>			 
									  	<th>Total Retail Price</th>
									  	<th>Currency</th>
									  	<th>Plan Time</th> 
									 	<th>Device Allowed</th>
									   	<th>Plan Category</th> 
									  	<th><a title="commission" style="cursor: pointer;">Commission</a></th>	
									  	<th>Dealer price </th>
									  	<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
									  	<th>Action</th>
									  	<?php } ?>
									</tr> 
								  </thead>
								  <tbody>
									<?php
									/*echo '<pre>'; 
									print_r($selected_plans_list);*/
									$i=1;
									foreach($selected_plans_list as $key => $val){
									?>
									<?php //if (in_array($key['id'], $selected_plans)){ ?>
									 <tr>
										<td><?=@$i?></td>
										<td><?php /*print_r($val); print_r($reseller_plansArray['id_'.$val['product_plans']]);*/ echo @$reseller_plansArray['id_'.$val['product_plans']]['name']; ?></td>
										<td><?php echo @$products_list['products_'.$reseller_plansArray['id_'.$val['product_plans']]['product_id']]; ?></td>
										<td>
										<?php echo @($reseller_plansArray['id_'.$val['product_plans']]['monthly_price']*$reseller_plansArray['id_'.$val['product_plans']]['length_months'] + $val['activation_price']); ?>

										<input type="hidden" id="product_plans_price_<?php echo @$val['id'];?>" name="product_plans_price_<?php echo @$val['id'];?>" value="<?php echo @(($reseller_plansArray['id_'.$val['product_plans']]['monthly_price']*$reseller_plansArray['id_'.$val['product_plans']]['length_months'])+$val['activation_price']); ?>"  />
										</td>
										<td>
											<?php foreach(COUNTRY_CURRENCY as $key_currency=>$val_currency){?>	
											<?php if($val_currency == $reseller_currency_type){ ?>													
											  <?php echo @$key_currency;?> 							
											<?php }?>							
											<?php }?> 
										<?php //echo $key['currency_type']; ?>
										</td>
										<td><?php echo @($reseller_plansArray['id_'.$val['product_plans']]['length_months'].' '.$reseller_plansArray['id_'.$val['product_plans']]['month_day']); ?></td>
										<td><?php echo @$reseller_plansArray['id_'.$val['product_plans']]['devices_allowed']; ?></td>
										<td>	
											<?php if((@$reseller_plansArray['id_'.$val['product_plans']]['plan_type'] == 'master') || (@$reseller_plansArray['id_'.$val['product_plans']]['plan_type'] == 'activation')){?>
												Activation price : <b><?php echo @$val['activation_price'];?></b>
												<input type="hidden" value="<?php echo @$val['activation_price'];?>" name="act_price_<?php echo @$val['id'];?>" id="act_price_<?php echo @$val['id'];?>" style="width: 90px;" readonly="readonly" />
												<br />
											<?php } ?>
											<?php echo @$reseller_plansArray['id_'.$val['product_plans']]['plan_type']; ?>
										</td>
										<td>
										<input type="radio" name="fixed_per_<?php echo @$val['id'];?>" id="fixed_per_<?php echo @$val['id'];?>" value="1" checked="checked" /> Fixed Price

										<input type="radio" name="fixed_per_<?php echo @$val['id'];?>" id="fixed_per_<?php echo @$val['id'];?>" value="2" style="margin-left:20px;"  <?php if($val['discount_type'] == '2' ){ echo 'checked';} ?> /> Percentage <br/>

										<input type="number" value="<?php echo @$val['discount_value'];?>" id="fixed_per_val_<?php echo @$val['id'];?>" name="fixed_per_val_<?php echo @$val['id'];?>"  /> 
										</td>
										<td><span id="dealer_price_<?php echo @$val['id'];?>"><?php echo @$val['dealer_price'];?></span></td>
										<td>
											<a href="#" onclick="update_reseller_plans('<?php echo $val['id'];?>');return false;" class="btn btn-block btn-primary btn-flat">Update</a>
										</td>
										
									</tr>
									<?php //} ?>
									<?php $i++; }?>
								  </tbody>
								</table>
							  </div>
						  </div>
						</div>
					</div>
				</div>
              </div>
			  <div class="tab-pane <?php if($active_tab == 'plans'){ echo 'active'; } ?>" id="tab_2">
			  <div class="box-body">
				<form method="post" action="<?php echo BASE_URL; ?>reseller/resellersdetails/<?php echo $reseller_id;?>" class="form-horizontal">
				<div class="row">
				   <div class="col-sm-5">
					   <select name="allreseller_products" id="multiselect_left" class="form-control" size="20" multiple="multiple" style="width: 100%;">
						<?php											
							foreach($reseller_m as $key){
								$option = $key['name'].' ('.$products_list['products_'.$key['product_id']].' - '.$key['monthly_price'].' '.$key['currency_type'].' For : '.$key['length_months'].' '.$key['month_day'].' Device:'.$key['devices_allowed'].'  ) ';
								if($reseller_currency_type == $key['currency_type']){
								
								if($key['plan_type'] == 'renewal'){
									$background_color = '#CCCCCC'; 													
								}elseif($key['plan_type'] == 'master'){
									$background_color = '#CCFFFF'; 												
								}if($key['plan_type'] == 'activation'){
									$background_color = '#FFFFCC'; 
								}
							?>										
							<option <?php if (in_array($key['id'], $selected_plans)){ echo 'style="display:none"'; } ?>  value="<?php echo $key['id'];?>" title="<?php echo $option; ?>" style="color: #000; background-color: <?php echo $background_color;?>; border-bottom:1px solid #fff"><?php echo $option; ?></option>
							
						<?php 
								}
							}
						
						 ?>
						 <!--<option>Weba</option> -->
					   </select>
				   </div>

				  <div class="col-sm-2">
					 <button type="button" id="btn_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
					 <button type="button" id="btn_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
					 <button type="button" id="btn_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
					 <button type="button" id="btn_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
				  </div>

				  <div class="col-sm-5">
				 
					<select id="multiselect_right" class="form-control" name="selected_plans[]" size="20" multiple="multiple" style="width:100%;">
					<?php foreach($reseller_m as $key){
						$selected_option =  $key['name'].' ('.$products_list['products_'.$key['product_id']].' - '.$key['monthly_price'].' '.$key['currency_type'].' For : '.$key['length_months'].' '.$key['month_day'].' Device:'.$key['devices_allowed'].' ) '; 
						if (in_array($key['id'], $selected_plans)){
								if($key['plan_type'] == 'renewal'){
									$background_color = '#CCCCCC'; 													
								}elseif($key['plan_type'] == 'master'){
									$background_color = '#CCFFFF'; 												
								}if($key['plan_type'] == 'activation'){
									$background_color = '#FFFFCC'; 
								}
						?>
						<option value="<?php echo $key['id'];?>" title="<?php echo $selected_option; ?>" style="color: #000; background-color: <?php echo $background_color;?>; border-bottom:1px solid #fff"><?php echo $selected_option; ?></option>
						
						<?php } ?>	
					<?php } ?>
					</select>
					
				  </div>
        		</div>
				
				<div class="row" style="margin-top:20px;"> 
					<div class="form-group">
						<label class="col-sm-5 control-label"></label>
						<div class="col-sm-4">
						  <input type="submit" class="btn btn-success " name="add_plans" value="Add Reseller Plans">
						</div>
					</div>
				</div>
				</form>
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