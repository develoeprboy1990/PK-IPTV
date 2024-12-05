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
                            
                              <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title pull-right"><?php echo anchor('server_locations/', '<i class="fa fa-arrow-left"></i> Back to Server Locations', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div> 
                              <?php } ?>

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
                                    <?php foreach($items as $item){?>
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
                </section>
            </div>
