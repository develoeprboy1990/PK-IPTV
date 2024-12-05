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
                                <h3 class="box-title">Channel : <strong><?=$channel_info->channel_name?></strong></h3>
                              </div>

                              <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('channels', '<i class="fa fa-arrow-left"></i> Back to Channels', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="epgs" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Title</th>
                                      <th>Start</th>
                                      <th>End</th>
                                      <th>Delete</th>
                                    </tr> 
                                  </thead>

                                  <tbody>
                                    <?php foreach($epgs as $epg){?>
                                       <tr>
                                        <td><?=$epg['id']?></td>
                                        <td><?=$epg['name']?></td>
                                        <td><?=$epg['t_start']?></td>
                                        <td><?=$epg['t_end']?></td>
                                        <td><?php echo btn_delete(BASE_URL.'channels/delete_epg/'.$epg['id'])?></td>
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
