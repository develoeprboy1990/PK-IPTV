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
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">JSON LOCATION</a></li>
                  <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">DOMAIN</a></li>
                  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                  <!-- Location Tab -->
                  <div class="tab-pane active" id="tab_1">
                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title"><strong>Location:</strong> <?php echo $server_info->name;?></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                          <div id="ajax_search_responce">
                            <?php if($responce = $this->session->flashdata('success')){ ?>
                                <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                            <?php } ?>
                            <table id="items" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Url</th>
                                <th></th>
                              </tr> 
                            </thead>
                            
                            <tbody>
                              <?php foreach($location_items as $item){?>
                               <tr>
                                  <td><?=$item->name?></td>
                                  <td id="url_<?=$item->id?>"><?=$item->url?></td>
                                  <td id="btn_<?=$item->id?>"><a href="javascript:void(0);" onclick="editItem('<?=$item->id?>')"><i class="fa fa-edit"></i></a></td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                          </div>
                        </div>
                        <!-- /.box-body -->
                      </div>
                  </div>
                  <!-- Domain Tab -->
                  <div class="tab-pane" id="tab_2">
                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title"><strong>Domain:</strong> <?php echo $server_info->name;?></h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                          <div id="ajax_search_responce">
                            <?php if($responce = $this->session->flashdata('success')){ ?>
                                <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                            <?php } ?>
                            <table id="items" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Name</th>
                                <th>Url</th>
                                <th></th>
                              </tr> 
                            </thead>
                            
                            <tbody>
                              <?php foreach($domain_items as $item){?>
                               <tr>
                                  <td><?=$item->name?></td>
                                  <td id="url_<?=$item->id?>"><?=$item->url?></td>
                                  <td id="btn_<?=$item->id?>"><a href="javascript:void(0);" onclick="editItem('<?=$item->id?>')"><i class="fa fa-edit"></i></a></td>
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
              </div>
             </div>
        </div>
    </section>
</div>
