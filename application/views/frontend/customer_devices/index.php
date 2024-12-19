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
                                    <h3 class="box-title"><?php echo anchor('customer_devices/create', '<i class="fa fa-plus"></i> Add Device', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce" class="table-responsive">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="devices" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>Date</th>
                                      <th>Location</th>
                                      <th>Model</th>
                                      <th>Serial</th>
                                      <th>Status</th>
                                      <th>Edit</th>
                                      <th>Delete</th>
                                    </tr> 
                                  </thead>
                                  
                                  <tbody>
                                  print
                                    <?php foreach($devices as $device){?>
                                     <tr>
                                        <td><?=$device['date_added']?></td>
                                        <td><?=$device['location']?></td>
                                        <td><?=$device['model']?></td>
                                        <td><?=$device['serial']?></td>
                                        <td><?=($device['status']==0) ? "Not Used" : "Used"?></td>
                                        <td><?php echo btn_edit(BASE_URL.'customer_devices/edit/'.$device['id']);?> </td>
                                        <td><?php echo btn_delete(BASE_URL.'customer_devices/delete/'.$device['id'])?></td>
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
