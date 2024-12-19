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
                <form method="post" action="<?= BASE_URL ?>customerpanel/subscriptiongroup" enctype="multipart/form-data" class="form-horizontal">
                <div class="row"> 
                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Group Name</label>
                      <div class="col-sm-4">
                       <input type="text" id="group_name" name="group_name" class="form-control" placeholder="Group Name"  value="<?=set_value('group_name')?>" required/>
                       <span class="text-danger"><?= form_error('group_name'); ?></span>
                      </div>
                    </div>
                  </div>
                <div class="row"> 
                  <div class="form-group">
                  <label for="product_id" class="col-sm-2 control-label">Product</label>
                  <div class="col-sm-4">
                   <select id="product_id" name="product_id" class="form-control" required>
                        <option value="">Select a Product</option>
                      <?php 
                  foreach($products as $product){
                  if (!in_array($product['id'], $group_dataall_product_id)){	
                  	if($product['customer_can_change_plan'] == '1'){				
                  ?>
                        <option value="<?php echo $product['id']; ?>" <?php if($product_id == $product['id']){ echo 'selected="selected"'; } ?>><?php echo $product['name'].'('.$gui_settings_array['id_'.$product['gui_setting_id']].')'; ?></option>
                      <?php 
                  		}
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
                       <input type="checkbox" id="free_change" name="free_change" value="1" checked="checked">
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
                                      <?php foreach ($customerpanel_m as $customerpanel) { ?>
                                        <option value="<?=$customerpanel['id']?>"><?php echo $customerpanel['name'].'('.$gui_settings_array['id_'.$products_array['id_'.$customerpanel['product_id']]['gui_setting_id']].')'; ?></option>
                                      <?php }?>
                                   </select>
                               </div>

                              <div class="col-sm-2">
                                 <button type="button" id="btn_rightAll_devices" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                 <button type="button" id="btn_rightSelected_devices" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                 <button type="button" id="btn_leftSelected_devices" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                 <button type="button" id="btn_leftAll_devices" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                              </div>

                              <div class="col-sm-5">
                                <select id="multiselect_right_devices" class="form-control" name="subscription_pans[]" size="15" multiple="multiple" required>
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
                  <input type="submit" class="btn btn-success " name="subscription_group" value="Create Subscription Group">
                        <!--<button type="submit" class="btn btn-success ">Add Group</button>-->
                      </div>
                    </div>
                  </div>
              </form>
            </div>
            <div class="box box-primary">
              <div class="box-header"><h4>Group</h4></div>
              <!--<div class="box-header">
              <span class="pull-right"><span class="export-icon">Export to: </span>
              <a href="<?php //echo site_url('keys/subscriptionExportExcel'); ?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
              <a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
              </span> 
              </div>-->
            	<div class="box-body">
            	  <div id="ajax_search_responce" class="table-responsive">
            		<table id="apps" class="table table-bordered table-striped">
            		  <thead>
            			<tr>
            			  <th>Group Name</th>
            			  <th>Product</th>
            			  <th>Free change plan</th>
            			  <th>Status</th>									 
            			  <?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
            			  <th>Action</th>
            			  <?php } ?>
            			</tr> 
            		  </thead>
            		  
            		  <tbody>
            			<?php 
            			//print_r(PRODUCTGROUP);
            			foreach($group_dataall as $key){
            			?>
            			 <tr>
            				<td><?php echo $key['group_name']; ?></td>
            				<td><?php echo @$products_array['id_'.$key['product_id']]['name']; ?></td>
            				<td><?php echo ($key['free_change']==1) ? "Yes" : "No"; ?></td>											
            				<td><?php echo ($key['status']==1) ? "Active" : "Inactive"; ?></td>                				
            				<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
            				<td>
            					<?php if($is_allow->allow_delete) {?> 
            						<?php echo btn_delete(BASE_URL.'customerpanel/subscriptiongroupdelete/'.$key['id'])?> &nbsp; 
            					<?php } 
            						if($is_allow->allow_edit) {
            					?> 
            						<a href="<?php echo BASE_URL; ?>customerpanel/subscriptiongroupedit/<?php echo $key['id'];?>"><i class="glyphicon glyphicon-edit text-primary"></i></a>
            					<?php } ?>
            					<?php if($key['status'] == '1'){ ?>
            					<a href="<?php echo BASE_URL; ?>customerpanel/subscriptiongroupddisable/<?php echo $key['id'];?>" style="margin-left:10px; color:#00CC33;">Enable</a>
            					<?php } ?>
            					
            					<?php if($key['status'] == '0'){ ?>
            					<a href="<?php echo BASE_URL; ?>customerpanel/subscriptiongroupdenable/<?php echo $key['id'];?>" style="margin-left:10px; color: #FF0000;">Disable</a>
            					<?php } ?>	
            				</td>
            				<?php } ?>
            			</tr>
            			<?php }?>
            		  </tbody>
            		</table>
            	  </div>
            	</div>
            </div>
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      </div>
      </div>
    </div>
  </section>
</div>