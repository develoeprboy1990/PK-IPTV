<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(11);  // channel module id
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
                <div class="box">
                  <div class="box box-primary">
					<div class="box-header"> <h4><strong>Electronic Programme Guide (EPG)</strong></h4> </div>
					<div class="box-body">
					 <form action="<?php echo BASE_URL;?>settings/epg" method="post">
						<div class="row"> 
						  <div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
							  <input type="text" id="epg_name" name="epg_name" class="form-control" value="" required/>										  
							</div>
							
						  </div>
						</div>
					 
					 	<div class="row"> 
						  <div class="form-group">
							<label class="col-sm-2 control-label">URL</label>
							<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
							  <input type="text" id="epg_url" name="epg_url" class="form-control" value="" required/>										 
							</div>										
						  </div>
						</div>
						
						
						<div class="row"> 
						  <div class="form-group">
							<label class="col-sm-2 control-label">Status</label>
							<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
							  										  
							  <select name="epg_status" id="epg_status" class="form-control" required>
							  	  <option value="">Select Status</option>
								  <option value="1">ON</option>
								  <option value="0">OFF</option>
							  </select>
							 
							</div>										
						  </div>
						</div>
						
						
						<div class="row"> 
						  <div class="form-group">
							<label class="col-sm-2 control-label">EPG Offset Time(min)</label>
							<div class="input-group input-group-sm col-sm-2" style="padding-left: 20px;padding-right: 20px;">
							  <input type="number" id="epg_offset" name="epg_offset" class="form-control" value="" required/>										 
							</div>
																	
						  </div>
						</div>
						
						
						<div class="row"> 
						  <div class="form-group">
							<label class="col-sm-2 control-label">DAYS TO STORE</label>
							<div class="input-group input-group-sm col-sm-2" style="padding-left: 20px;padding-right: 20px;">
							  <input type="number" id="epg_offset_date" name="epg_offset_date" class="form-control" value="" required/>										 
							</div>
																	
						  </div>
						</div>
						
						<div class="row"> 
						  <div class="form-group">
							<label class="col-sm-2 control-label">URL Type</label>
							<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
							  										  
							  <select name="url_type" id="url_type" class="form-control" required>
							  	  <option value="">Select Type</option>
								  <option value="1">Logo Type</option>
								  <option value="2">EPG</option>
							  </select>
							 
							</div>										
						  </div>
						</div>
						
						<div class="row"> 
						  <div class="form-group">
						 	<span class="input-group-btn">
							<div class="input-group input-group-sm col-sm-6" style="padding-left: 20px;padding-right: 20px;">
								<input type="submit" style="float:right" class="btn large btn-success btn-flat w-sm waves-effect waves-light" value="Add" name="submit">
							</div>
						  </div>
						</div>
						</form>
						
					</div>
				  </div>

                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="ajax_search_responce" class="table-responsive">
                      <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                      <?php } ?>
					  
					   <?php if($this->session->flashdata('failure')){ ?>
                          <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $this->session->flashdata('failure');?></div>
                      <?php } ?>
                      <table id="apps" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>									 
                          <th>Name</th>									 
                          <th>Url</th>
						  <th>Url Type</th>
						  <th>Status</th>
						  <th>Import</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr> 
                      </thead>
                      
                      <tbody>
                        <?php 
							$counterbm = 1;
							$status_arr = array('0'=>'OFF', '1'=> 'ON');
							$url_type = array('1'=>'Logo Type', '2'=> 'Other Type');
							foreach($epgs as $epg){										
						?>
                         <tr>
                            <td><?php echo @$counterbm;?></td>
                            <td><?php echo @$epg['name'];?></td>										
                            <td><?php echo @$epg['url'];?></td>  
							<td><?php echo @$url_type[$epg['url_type']];?></td>  
							<td><?php echo @$status_arr[$epg['epg_status']];?></td>                                        
							<td><a href="<?php echo BASE_URL.'settings/epgimport/'.@$epg['id'];?>">Import</a></td>
							<td><?php echo btn_edit(BASE_URL.'settings/epgedit/'.@$epg['id']);?>
                            <td><?php echo btn_delete(BASE_URL.'settings/epgdelete/'.@$epg['id']);?></td>
                        </tr>
                        <?php 
								$counterbm++;
							}
						?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                
             </div>
        </div>
    </section>
</div>
