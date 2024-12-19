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
                            
                            <div class="box" class="table-responsive">
                              
                              <div class="box box-primary">
								<div class="box-header"> <h4><strong>EPG Cron</strong></h4> </div>
								<!--<div class="box-body">
								 	<div class="row"> 
									  <div class="form-group">
										<label class="col-sm-2 control-label">Update all EPG</label>
										<div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
										  <a href="<?php echo BASE_URL;?>settings/runCron" class="btn large btn-success btn-flat w-sm waves-effect waves-light"> Run Cron</a>																			 
										</div>										
									  </div>
									</div>
									
									
									
								</div>-->
							  </div>



							<table id="publishes" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Update Yes/No</th>
                    <!--<th>Last Publish Date</th>-->
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                  </tr>  
                </thead>
                <tbody>
                  <?php //foreach($modules as $module){?>
                    <tr>
                      <td>Update all EPG</td>
                      <td>Yes</td>
                      <!--<td><?=$module['last_update']?></td>-->
                      <td>
                        <a href="<?php echo BASE_URL;?>settings/runCron" style="text-decoration: underline;">Run Cron</a>
                      </td>
                      <td>
                        <a href="#" style="text-decoration: underline;">Edit</a>
                      </td>
                    </tr>
                  <?php //}?>
                 
                </tbody>
              </table>
                             
                            </div>
                            
                         </div>
						 
						 
						 <div class="box-body">
              
            </div>
                    </div>
                </section>
            </div>
