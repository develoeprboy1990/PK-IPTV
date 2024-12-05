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
                                    <h3 class="box-title"><?php echo anchor('albums/create/', '<i class="fa fa-plus"></i> '.$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="albums" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Artist</th>
                                      <th>Status</th>
                                      <th></th>
                                    </tr> 
                                  </thead>
                                  <?php foreach($albums as $album){?> 
                                     <tr>
                                       <td><a href="<?=site_url('albums/details/'.$album['id'])?>"><?=$album['id']?></a></td>
                                       <td><a href="<?=site_url('albums/details/'.$album['id'])?>"><?=$album['name']?></a></td>
                                       <td><?=$album['artist']?></td>
                                       <td><?=($album['status']==1) ? "Active" : "Inactive"?></td>
                                       <td><?php echo btn_edit(BASE_URL.'albums/details/'.$album['id']);?> <?php echo btn_delete(BASE_URL.'albums/delete/'.$album['id'])?></td>
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
