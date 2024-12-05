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
                <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Daily Episode Update</a></li>                
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
								  <div class="box-body">
								  
								   <?php if($responce = $this->session->flashdata('success')){ ?>
								   	<div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
								                    <?php } ?>

								                     <?php if($this->session->flashdata('failure')){ ?>
								                        <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $this->session->flashdata('failure');?></div>
								                    <?php } ?>
									  
								<form method="post" action="<?= BASE_URL ?>daily_episode_update" enctype="multipart/form-data" class="form-horizontal">
								<div class="row"> 
								  <div class="form-group">
								    <label for="name" class="col-sm-2 control-label">Season Date</label>
								    <div class="col-sm-4">
								     <input type="text" id="episode_date" name="episode_date" class="form-control" placeholder="Episode Date"   data-date-format='yy-mm-dd' value="" required    onchange="fetch_Season();" />
								     <span class="text-danger"><?= form_error('episode_date'); ?></span>
								    </div>
								  </div>
								</div>



								<div class="row"> 
								  <div class="form-group">
								    <label for="available_devices" class="col-sm-2 control-label">Season</label>
								    <div class="col-sm-10">
								      <div class="panel panel-default" style="background-color:#fff; width: 800px;">
								        <div class="panel-body" >
								           <div class="row">
								             <div class="col-sm-5">
								                 <select name="available_devices" id="multiselect_left_devices" class="form-control" size="15" multiple="multiple">
								   		
								                    <?php foreach ($series as $serie) { ?>
									  <!--<span><?php echo $serie['name']; ?></span>-->
								                      <!--<option value="<?=$serie['id']?>" readonly ><?php echo $serie['name']; ?></option>-->
										
										<!--<optgroup label="<?php echo $serie['name']; ?>">
											<option value="jquery">jQuery.js</option>
											<option value="jqueryui">ui.jQuery.js</option>
										</optgroup>-->
										<span id="sessions"></span>


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
								              <select id="multiselect_right_devices" class="form-control" name="season_set[]" size="15" multiple="multiple" required>
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
								<input type="submit" class="btn btn-success " name="daily_episode_update" value="Reviews">
								      <!--<button type="submit" class="btn btn-success ">Add Group</button>-->
								    </div>
								  </div>
								</div>
								</form>
</div>

             <div class="box box-primary">
	<div class="box-header">
		<h4>Daily Episode Update List</h4>
		<div id="data_log">
		<span  id="data_log_span" style="float: right;margin-top: -38px;padding: 5px 10px;border: 1px solid red;font-weight: bold; cursor:pointer; color:red; ">Show Logs</span>
		
		<span id="data_add_span" style="float: right;margin-top: -38px;padding: 5px 10px;border: 1px solid #008d4c;font-weight: bold; cursor:pointer; color:#00a65a;display:none;">Show Data</span>
		
		
		</div>
		<span  id="data_log_span_search" style="float: right;margin-top: -38px;padding: 5px 10px;margin-right: 90px; display:none;">Select Date : <input type="date" name="select_log_data" id="select_log_data" onchange="show_logdata();"/></span>
		<span id="data_add_all" style="float: right;margin-top: -38px;padding: 5px 10px;border: 1px solid #008d4c;font-weight: bold; cursor:pointer; color:#00a65a;margin-right: 100px;"><a href="<?php echo BASE_URL; ?>daily_episode_update/addalldata" style="color:#00a65a;" onclick="return confirm('Are you sure? To add All.');">Add All Data</a></span>
	</div>
	<!--<div class="box-header">
	  <span class="pull-right"><span class="export-icon">Export to: </span>
		<a href="<?php //echo site_url('keys/subscriptionExportExcel'); ?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
		<a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
	  </span> 
	</div>-->
									<div class="box-body">
									  <div id="ajax_search_responce">
										<table id="apps" class="table table-bordered table-striped">
										  <thead>
											<tr>
											<th>Season Date</th>
											<th>Title</th>
											  
											  <!--<th>Sequence</th>-->
											  <th>Series Name</th>
											   <th>Season Name</th>
											  <th>URL</th>
											  <th>Description</th>			 
											  <?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
											  <th>Action</th>
											  <?php } ?>
											</tr> 
										  </thead>
										  
										  <tbody>
											<?php 
											//print_r($series_all_array);
											foreach($daily_episode_update as $key){
												if($key['is_added'] == '0'){
											?>
											 <tr>
											 	<td><?php echo date ('d-m-Y', strtotime($key['episode_date'])); ?></td>
												<td><?php echo $key['title']; ?></td>
												
												<!--<td><?php echo $key['sequence']; ?></td>-->
												<td><?php echo $series_all_array[$key['series_name']]; ?></td>
												<td><?php echo $key['season_name']; ?></td>
												<td><?php echo $key['url']; ?></td>
												<td><?php echo $key['seasons_description']; ?></td>
												
												<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
												<td>
													<?php if($is_allow->allow_delete) {?> 
														<?php echo btn_delete(BASE_URL.'daily_episode_update/deleted/'.$key['id'])?>  &nbsp;
													<?php } 
														//if($is_allow->allow_edit) {
													?> 
													<?php if($key['is_added'] == '0'){ ?>
														<a href="<?php echo BASE_URL; ?>daily_episode_update/edit/<?php echo $key['id'];?>"><i class="glyphicon glyphicon-edit text-primary"></i></a> &nbsp; 
														<?php } ?>
														
														<?php //if($key['is_added'] == '0'){ ?>
														<a href="<?php echo BASE_URL; ?>daily_episode_update/add/<?php echo $key['id'];?>" style="color:#00CC00;">ADD</a>
														<?php //}else{ ?>
														<!--<a href="<?php echo BASE_URL; ?>daily_episode_update/add/<?php echo $key['id'];?>"  style="color:red;">ADDED</a>-->
														<?php //} ?>
														
													<?php //} ?>
													
												</td>
												<?php } ?>
											</tr>
											<?php }
												}
											?>
										  </tbody>
										</table>
										
										<table id="apps_log" class="table table-bordered table-striped" style="display:none;">
										  <thead>
											<tr>
											<th>Season Date</th>
											<th>Title</th>
											  
											  <!--<th>Sequence</th>-->
											  <th>Series Name</th>
											   <th>Season Name</th>
											  <th>URL</th>
											  <th>Description</th>			 
											 
											  <th>Action</th>
											
											</tr> 
										  </thead>
										  
										  <tbody>
											
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
  </section>
</div>	
<style>
#apps_log_length{ display:none;}
#apps_log_filter{ display:none;}
#apps_log_info{ display:none;}
#apps_log_paginate{ display:none;}
</style>