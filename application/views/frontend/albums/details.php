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
                          <!-- Custom Tabs -->
                          <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Album Details</a></li>
                              <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Songs</a></li>
                              <li class="dropdown pull-right">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  Settings <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                  <li role="presentation"><?php if($details->status==1){?><a role="menuitem" tabindex="-1" href="<?=site_url('albums/disable/'.$details->id)?>">Disable Album</a><?php }else{?><a role="menuitem" tabindex="-1" href="<?=site_url('albums/enable/'.$details->id)?>">Enable Album</a> <?php }?></li>
                                </ul>
                              </li>
                            </ul>
                            <div class="tab-content">
                              <?php if($responce = $this->session->flashdata('success')){ ?>
                                <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                              <?php } ?>

                              <div class="tab-pane active" id="tab_1">
                                <?=$album_view?>
                              </div>

                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_2">
                                <?php 
                                  if($song_form_action=="add"){
                                    echo $add_songs_view;
                                    echo $songs_list_view;
                                  }
                                  else
                                    echo $edit_songs_view;
                                ?>
                               
                                
                                
                              </div>
                              <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                          </div>
                          <!-- nav-tabs-custom -->
                        </div>
                    </div>
                </section>
            </div>
