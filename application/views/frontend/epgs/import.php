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
								<div class="box-header"> <h4><strong>XML Import</strong></h4> </div>
								<div class="box-body">
								 <form action="<?php echo BASE_URL;?>settings/epgedit/<?php echo $info->id;?>" method="post">
									
								 
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
									 	<span class="input-group-btn">
										<div class="input-group input-group-sm col-sm-6" style="padding-left: 20px;padding-right: 20px;">
											<input type="submit" style="float:right" class="btn large btn-success btn-flat w-sm waves-effect waves-light" value="Import" name="submit">
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
