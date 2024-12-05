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
                  <li class="active"><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Renewal Plans</a></li>							 
                  <li><a href="#tab_2" data-toggle="tab">Activation Plans</a></li>
	                <li><a href="#tab_3" data-toggle="tab">Digital Plans</a></li>
                  <li><a href="#tab_4" data-toggle="tab">Trial Plans</a></li>
                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <?=$renewal_keys?>
                  </div>
	                <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    <?=$activation_keys?>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_3">
                    <?=$master_keys?>                   
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_4">
                    <?=$trial_keys?>                   
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