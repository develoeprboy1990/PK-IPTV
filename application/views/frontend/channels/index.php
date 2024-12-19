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
                                    <h3 class="box-title"><?php echo anchor('channels/create', '<i class="fa fa-plus"></i> Add a Channel', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce" class="table-responsive">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="channels" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Channel Number</th>
                                      <th>Channel Name</th>
                                      <th>Status</th>
                                      <th>Edit</th>
                                      <th>Delete</th>
                                    </tr> 
                                  </thead>

                                  <tbody>
                                    <?php foreach($channels as $channel){?>
                                       <tr>
                                        <td><?=$channel['id']?></td>
                                        <td><?=$channel['channel_number']?></td>
                                        <td><?=$channel['channel_name']?></td>
                                        <td><?=($channel['status']==1) ? "Active" : "Inactive"?></td>
                                        <!-- <td><?php echo anchor('channels/epgs/'.$channel['id'], '<i class="fa fa-eye"></i> View EPG', array('class' => 'btn btn-block btn-primary btn-flat')); ?></td> -->
                                        <td><?php echo btn_edit(BASE_URL.'channels/details/'.$channel['id'])?></td></td>
                                        <td><?php echo btn_delete(BASE_URL.'channels/delete/'.$channel['id'])?></td>
                                      </tr> 
                                    <?php } ?>
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
