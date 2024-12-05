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
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Subscription Group</a></li>
                              
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
							  <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>customerpanel/subscriptiongroupedit/<?php echo $pid;?>" enctype="multipart/form-data" class="form-horizontal">
              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Group Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="group_name" name="group_name" class="form-control" placeholder="Group Name"  value="<?=$group_name?>" required/>
                   <span class="text-danger"><?= form_error('group_name'); ?></span>
                  </div>
                </div>
              </div>
        
               
	 		
              

              

              <div class="row"> 
          <div class="form-group">
            <label for="product_id" class="col-sm-2 control-label">Product</label>
            <div class="col-sm-4">
               <select id="product_id" name="product_id" class="form-control" readonly>
                    <option value="">Select a Product</option>
                  <?php 
				  	foreach($products as $product){
				  		if (!in_array($product['id'], $group_dataall_product_id)){	
								if($product['customer_can_change_plan'] == '1'){
				  ?>
                    <option value="<?php echo $product['id']; ?>" <?php if($product_id == $product['id']){ echo 'selected="selected"'; } ?>><?php echo $product['name']; ?></option>
                  <?php 
				  				}
						}
						
						if($product_id == $product['id']){
						?>
							  <option value="<?php echo $product['id']; ?>" <?php if($product_id == $product['id']){ echo 'selected="selected"'; } ?>><?php echo $product['name']; ?></option>
						<?php 
						
						}
				  }
				  
				  ?>
               </select>
            </div>
          </div>
        </div>

              
            
              
			<div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Free change plan</label>
                  <div class="col-sm-4">
                   <input type="checkbox" id="free_change" name="free_change" value="1" <?php if($free_change == '1'){?> checked="checked" <?php } ?> >
                   <span class="text-danger"><?= form_error('free_change'); ?></span>
                  </div>
                </div>
              </div>
              

              <div class="row"> 
                <div class="form-group">
                  <label for="available_devices" class="col-sm-2 control-label">Subscription Plans</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_devices" id="multiselect_left_devices" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($customerpanel_m as $customerpanel) { 
								  		if (!in_array($customerpanel['id'], $subscription_pans)){
								  ?>
                                    <option value="<?=$customerpanel['id']?>"><?php echo $customerpanel['name'].'('.$gui_settings_array['id_'.$products_array['id_'.$customerpanel['product_id']]['gui_setting_id']].')'; ?></option>
                                  <?php }else{ ?>
										<option value="<?=$customerpanel['id']?>" style="display:none;"><?php echo $customerpanel['name'].'('.$gui_settings_array['id_'.$products_array['id_'.$customerpanel['product_id']]['gui_setting_id']].')'; ?></option>
								  <?php	
										}
								  }
								  ?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_devices" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_devices" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_devices" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_devices" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_devices" class="form-control" name="subscription_pans[]" size="15" multiple="multiple">
							
							 <?php foreach ($customerpanel_m as $customerpanel) { 
							 		if (in_array($customerpanel['id'], $subscription_pans)){
							 ?>
                                    <option value="<?=$customerpanel['id']?>"><?php echo $customerpanel['name'].'('.$gui_settings_array['id_'.$products_array['id_'.$customerpanel['product_id']]['gui_setting_id']].')'; ?></option>
                                  <?php }
								  	}
								  ?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_devices" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_devices" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
				  <input type="submit" class="btn btn-success " name="subscription_group" value="Edit Subscription Group">
                    <!--<button type="submit" class="btn btn-success ">Add Group</button>-->
                  </div>
                </div>
              </div>
            </form>
          </div>
		  
                               

                             
                            </div>
                            <!-- /.tab-content -->
                          </div>
                          <!-- nav-tabs-custom -->
                        </div>
                    </div>
                </section>
            </div>
			
			
			
			
