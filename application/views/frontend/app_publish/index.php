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
                <li><a href="#tab_1" data-toggle="tab">General</a></li>
                <li><a href="#tab_2" data-toggle="tab">Set Up</a></li>
                <li><a href="#tab_3" data-toggle="tab">Beta</a></li>
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
              </ul>
              <div class="tab-content">
                <!-- /.tab-pane -->
                <div class="tab-pane active" id="tab_1">
                  <?=$genral_app_publish_add?>
                  <?=$genral_app_publish_list?>
                </div>
  
                <div class="tab-pane" id="tab_2">
                  <?=$setup_app_publish_add?>
                  <?=$setup_app_publish_list?>
                </div>

                <div class="tab-pane" id="tab_3">
                  <?=$beta_app_publish_add?>
                  <?=$beta_app_publish_list?>
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