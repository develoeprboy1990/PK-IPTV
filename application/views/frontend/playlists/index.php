<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(12);  // Securities module id

if(!isset($is_allow))
{
    
   redirect('unauthorize', 'refresh');
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
                                    <h3 class="box-title"><?php echo anchor('playlists/create', '<i class="fa fa-plus"></i> Add a Playlist', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                            <?php } ?>

                            <div class="box-body">
                              <div id="ajax_search_responce" class="table-responsive">
                                <?php if($responce = $this->session->flashdata('success')){ ?>
                                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                <?php } ?>
                                <table id="playlists" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>Name</th>
                                    <th>Url</th>
                                    <th>Edit</th>

                                  </tr> 
                                </thead>
                                
                                <tbody>
                                  <?php foreach($playlists as $playlist){?>
                                   <tr>
                                      <td><?=$playlist['name']?></td>
                                      <td><?=$playlist['url']?></td>
                                      <td><a href="<?=site_url('playlists/edit/'.$playlist['id'])?>"><i class="fa fa-edit"></i></a> <a href="<?=site_url('playlists/delete/'.$playlist['id'])?>"><i class="fa fa-trash"></i></a></td>
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
