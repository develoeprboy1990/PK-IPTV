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
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Subscription Renewal Keys</a></li>
							  <li class=""><a href="#tab_4" data-toggle="tab" id="tab-menu-2">Resellers Keys</a></li>
                              <!--<li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Channel Package Keys</a></li>-->
                              <li><a href="#tab_3" data-toggle="tab">Activation Keys</a></li>
							  <li><a href="#tab_5" data-toggle="tab">Master Keys</a></li>
                              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
                                <?=$subscription_renewal_keys_view?>
                                <?=$subscription_renewal_keys_list_view?>
                              </div>
							   <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_4">
                               
                                <?=$subscription_renewal_keys_list_view_resellers?>
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_2">
                                <?=$package_keys_view?>
                                <?=$package_keys_list_view?>
                              </div>
                              <!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_3">
                                <?=$activation_keys_view?>
                                <?=$activation_keys_list_view?>
                              </div>
							  
							  <div class="tab-pane" id="tab_5">
                                <?=$master_keys_view?>
                                <?=$master_keys_list_view?>
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
