<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(17);  // Homescreen
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
                              <li><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Channels</a></li>
                              <li><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Movies</a></li>
                             <!--  <li><a href="#tab_3" data-toggle="tab" id="tab-menu-2">Series</a></li> -->
                              <li><a href="#tab_3" data-toggle="tab" id="tab-menu-3">Series Seasons</a></li>
                            </ul>
                            <div class="tab-content">
                              <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                              <?php } ?>
                              <div class="tab-pane active" id="tab_1">
                                <?=$channels_view?>
                              </div>

                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_2">
                                <?=$movies_view?>
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_3">
                                <?=$series_seasons_view?>
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
