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
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Channel</a></li>
                              <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Package & Group</a></li>
                              <li class=""><a href="#tab_3" data-toggle="tab" id="tab-menu-3">Advertisement</a></li>
                              <li class=""><a href="#tab_4" data-toggle="tab" id="tab-menu-4">EPG</a></li>
                              <li class=""><a href="#tab_5" data-toggle="tab" id="tab-menu-5">Logs</a></li>
                              <li class="dropdown pull-right">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  Settings <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                  <li role="presentation"><?php if($channel_detail->status==1){?><a role="menuitem" tabindex="-1" href="<?=site_url('channels/disable/'.$channel_detail->id)?>">Disable Channel</a><?php }else{?><a role="menuitem" tabindex="-1" href="<?=site_url('channels/enable/'.$channel_detail->id)?>">Enable Channel</a> <?php }?></li>
                                </ul>
                              </li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
                                <?=$channel_info_view?>
                              </div>

                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_2">
                                <?=$package_group_view?>
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_3">
                                <?=$advertisement_view?>
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_4">
                                <?=$epg_view?>
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_5">
                                <?=$logs_view?>
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
