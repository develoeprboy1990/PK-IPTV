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
                                    <h3 class="box-title"><?php echo anchor('prerolls/create', '<i class="fa fa-plus"></i> Add a Video Preroll', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="advertisements" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>Name</th>
                                      <th>Date Start</th>
                                      <th>Date End</th>
                                      <th>Max Views</th>
                                      <th>Edit</th>
                                      <th>Delete</th>
                                    </tr> 
                                  </thead>
                                  
                                  <tbody>
                                    <?php foreach($prerolls as $preroll){?>
                                     <tr>
                                        <td><?=$preroll['name']?></td>
                                        <td><?=$preroll['date_start']?></td>
                                        <td><?=$preroll['date_end']?></td>
                                        <td><?=$preroll['max_views']?></td>
                                        <td><?php echo btn_edit(BASE_URL.'prerolls/edit/'.$preroll['id']);?>
                                        <td><?php echo btn_delete(BASE_URL.'prerolls/delete/'.$preroll['id'])?></td>
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
