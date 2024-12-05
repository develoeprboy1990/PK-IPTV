<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Edit</a></li>
                              
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
								<div class="box box-primary">
									
									<?php if($responce = $this->session->flashdata('success')){ ?>
										<div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
									<?php } ?>
									<div class="box-body">
									  <form method="post" action="<?= BASE_URL ?>daily_episode_update/edit/<?php echo $episode_details['id'];?>" class="form-horizontal">
										
										<div class="row"> 
										  <div class="form-group">
											<label for="group_name" class="col-sm-2 control-label">Season Name</label>
											<div class="col-sm-4">
											 <input type="text" id="season_name" name="season_name" class="form-control" value="<?php echo $episode_details['season_name'];?>" required/>
											 <span class="text-danger"><?= form_error('season_name'); ?></span>
											</div>
										  </div>
										</div>
									
          
		
										<div class="row"> 
										  <div class="form-group">
											<label for="product_id" class="col-sm-2 control-label">Sequence</label>
											<div class="col-sm-4">
											  <input type="text" id="sequence" name="sequence" class="form-control" value="<?php echo $episode_details['sequence'];?>" required/>
											</div>
										  </div>
										</div>
										
										<div class="row"> 
										  <div class="form-group">
											<label for="product_id" class="col-sm-2 control-label">URL</label>
											<div class="col-sm-4">
											  <input type="text" id="url" name="url" class="form-control" value="<?php echo $episode_details['url'];?>" required/>
											</div>
										  </div>
										</div>
										
										
									
		
										<!--<div class="row" style="display:none;"> 
										  <div class="form-group">
											<label for="devices_allow" class="col-sm-2 control-label">Number of Devices Allowed</label>
											<div class="col-sm-4">
											 <input type="number" id="devices_allowed" name="devices_allowed" class="form-control" placeholder="5" required value="<?php echo $devices_allowed;?>"/>
											 <span class="text-danger"><?= form_error('devices_allowed'); ?></span>
											</div>
										  </div>
										</div>-->
								
										<!--<div class="row"> 
										  <div class="form-group">
											<label for="quantity" class="col-sm-2 control-label">Price</label>
											<div class="col-sm-4">
											 <input type="number" id="price" name="price" class="form-control" placeholder="50" required value="<?php echo $price;?>"/>
											 <span class="text-danger"><?= form_error('quantity'); ?></span>
											</div>
										  </div>
										</div>-->
								
										<!--<div class="row"> 
										  <div class="form-group">
											<label for="length_months" class="col-sm-2 control-label">Episode Date</label>
											
											 <div class="col-sm-4">
											  <input type="date" name="episode_date" id="episode_date" value="<?php echo $episode_details['episode_date']?>" />
											   
											 <span class="text-danger"><?= form_error('length_months'); ?></span>
											</div>
										  </div>
										</div>-->
										
										<!--<div class="row"> 
										  <div class="form-group">
											<label for="quantity" class="col-sm-2 control-label">Tag Title</label>
											<div class="col-sm-4">
											 <input type="text" id="tag_title" name="tag_title" class="form-control" placeholder="Tag Title..." required value="<?php echo $tag_title;?>"/>
											 <span class="text-danger"><?= form_error('quantity'); ?></span>
											</div>
										  </div>
										</div>-->
										
										<div class="row"> 
										  <div class="form-group">
											<label for="quantity" class="col-sm-2 control-label">Seasons Description</label>
											<div class="col-sm-6">
											 <textarea id="seasons_description" name="seasons_description" class="form-control" rows="5" cols="20" placeholder="Plan Description write here..." required ><?php echo $episode_details['seasons_description'];?></textarea>
											 <span class="text-danger"><?= form_error('episode_details'); ?></span>
											</div>
										  </div>
										</div>
										
										
										<div class="row"> 
										  <div class="form-group">
											<label class="col-sm-2 control-label"></label>
											<div class="col-sm-4">
											  <input type="submit" class="btn btn-success " name="episode_edit" value="Edit" row>
											</div>
										  </div>
										</div>
									  </form>
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
