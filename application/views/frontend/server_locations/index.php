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
                              <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('server_locations/create', '<i class="fa fa-plus"></i> Add a Server', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce" class="table-responsive">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="locations" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>Name</th>
                                      <th></th>
                                      <th></th>
                                    </tr> 
                                  </thead>
                                  
                                  <tbody>
                                    <?php foreach($locations as $location){?>
                                     <tr>
                                        <td id="server_<?=$location->id?>"><a href="<?=site_url('server_locations/items/'.$location->id)?>"><?=$location->name?></a></td>
                                        <td><a href="<?=site_url('server_locations/items/'.$location->id)?>"><i class="fa fa-eye"></i> View Items</a></td>
                                        <td id="btn_<?=$location->id?>"><a href="javascript:void(0);" onclick="edit('<?=$location->id?>')"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                    <?php }?>
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
