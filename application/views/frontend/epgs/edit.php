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
					<?php
						/*echo '<pre>';
						print_r($info);*/
					?>
                        <div class="col-md-12">
                            
                            <div class="box">
                              
                              <div class="box box-primary">
								<div class="box-header"> <h4><strong>Electronic Programme Guide (EPG)</strong></h4> </div>
								<div class="box-body">
								 <form action="<?php echo BASE_URL;?>settings/epgedit/<?php echo $info->id;?>" method="post">
									<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">Name</label>
										<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
										  <input type="text" id="epg_name" name="epg_name" class="form-control" value="<?php echo $info->name;?>" required/>										  
										</div>
										
									  </div>
									</div>
								 
								 	<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">URL</label>
										<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
										  <input type="text" id="epg_url" name="epg_url" class="form-control" value="<?php echo $info->url;?>" required/>										 
										</div>										
									  </div>
									</div>
									
									
									<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">Status</label>
										<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
										  										  
										  <select name="epg_status" id="epg_status" class="form-control" required>
										  	  <option value="">Select Status</option>
											  <option value="1" <?php if($info->epg_status == '1'){ echo 'selected';} ?>>ON</option>
											  <option value="0" <?php if($info->epg_status == '0'){ echo 'selected';} ?>>OFF</option>
										  </select>
										 
										</div>										
									  </div>
									</div>
									
									
									<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">EPG Offset Time(min)</label>
										<div class="input-group input-group-sm col-sm-1" style="padding-left: 20px;padding-right: 20px;">
										  <input type="number" id="epg_offset" name="epg_offset" class="form-control" value="<?php echo $info->epg_offset;?>" required/>										 
										</div>										
									  </div>
									</div>
									
									<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">DAYS TO STORE</label>
										<div class="input-group input-group-sm col-sm-2" style="padding-left: 20px;padding-right: 20px;">
										  <input type="number" id="epg_offset_date" name="epg_offset_date" class="form-control" value="<?php echo $info->epg_offset_date;?>" required/>										 
										</div>
																				
									  </div>
									</div>
									
									<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">URL Type</label>
										<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
										  										  
										  <select name="url_type" id="url_type" class="form-control" required>
										  	  <option value="">Select Type</option>
											  <option value="1" <?php if($info->url_type == '1'){ echo 'selected';} ?>>Logo Type</option>
											  <option value="2" <?php if($info->url_type == '2'){ echo 'selected';} ?>>EPG</option>
										  </select>
										 
										</div>										
									  </div>
									</div>
									
									<div class="row"> 
									  <div class="form-group">
									 	<span class="input-group-btn">
										<div class="col-sm-6">
										<div class="input-group input-group-sm col-sm-12" style="padding-left: 20px;padding-right: 20px;">
											<input type="submit" style="float:right" class="btn large btn-success btn-flat w-sm waves-effect waves-light" value="Edit" name="submit">											<div style="float:right;    margin-right: 10px;">
											<a href="<?php echo BASE_URL;?>settings/epg" class="btn large btn-success btn-flat w-sm waves-effect waves-light">Cancel</a>
											</div>
										</div>
										</div>
									  </div>
									</div>
									</form>
									
								</div>
							  </div>

                             
                            </div>
                            
                         </div>
                    </div>
                </section>
            </div>
