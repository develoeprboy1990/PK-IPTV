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
                              <div class="box-header">
                                <h3 class="box-title">Search Result With Filters</h3>
                              </div>

                              <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('messagedevice/create/', '<i class="fa fa-plus"></i> '.$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
									<h3 class="box-title"><?php echo anchor('messagedevice/makeJson/', '<i class="fa fa-plus"></i> '.'Make Json', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
								
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce" class="table-responsive">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="albums" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Title</th>
									  <th>Start Date</th>
									  <th>End Date</th>
									  <th>Status</th>
                                      <th></th>
                                    </tr> 
                                  </thead>
                                  <?php foreach($albums as $album){?> 
                                     <tr>
                                       <td><a href="<?=site_url('messagedevice/details/'.$album['id'])?>"><?=$album['id']?></a></td>
                                       <td><a href="<?=site_url('messagedevice/details/'.$album['id'])?>"><?=$album['title']?></a></td>                                      
                                       
									   <td><?php echo date('d-m-Y',strtotime($album['start_date'])); ?></td>
									    <td><?php echo date('d-m-Y',strtotime($album['end_date'])); ?></td>
										<td><?=($album['status']==1) ? "Active" : "Inactive"?></td>
                                       <td>
									   		<?php echo btn_edit(BASE_URL.'messagedevice/details/'.$album['id']);?> 
									   		<?php echo btn_delete(BASE_URL.'messagedevice/delete/'.$album['id'])?>
										</td>
                                     </tr>
                                     <?php }?>
                                </table>
                                </div>
                              </div>
                              <!-- /.box-body -->
                            </div>
                            
                         </div>
                    </div>
                </section>
            </div>
