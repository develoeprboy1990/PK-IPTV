<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(11);  // channel module id
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
                <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Subscription Plans</a></li>                
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <?php if($is_allow->allow_create) {?> 
                      <?=$subscription_renewal_keys_view?>
                  <?php } ?>
                  <?=$subscription_renewal_keys_list_view?>
                </div>
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
      </div>
  </section>
</div>