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
                          
                          <div class="nav-tabs-custom">  
                            <ul class="nav nav-tabs">
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">CDN Security</a></li>
                              <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Tokens </a></li>
                              <li class=""><a href="#tab_3" data-toggle="tab" id="tab-menu-3">SMTP Server </a></li>
                              <li class=""><a href="#tab_4" data-toggle="tab" id="tab-menu-4">DRM</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="box">
                                      <div class="box-body">
                                        <div id="ajax_search_responce">
                                          <?php if($responce = $this->session->flashdata('success')){ ?>
                                              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                          <?php } ?>
                                          <table id="securities" class="table table-bordered table-striped">
                                          <thead>
                                            <tr>
                                              <th>Key</th>
                                              <th>Value</th>
                                              <th>Edit</th>
                                            </tr> 
                                          </thead>
                                          
                                          <tbody>
                                            <?php foreach($securities as $security){?>
                                             <tr id="row_<?=$security->id?>">
                                                <td id="name_<?=$security->id?>"><?=$security->name?></td>
                                                <td id="column_key_<?=$security->id?>"><?=$security->value?></td>
                                                <td id="row_btn_<?=$security->id?>"><a href="javascript:void(0);" data-id="<?=$security->id?>" id="edit_btn_<?=$security->id?>" class="edit-btn" onclick="edit('<?=$security->id?>')"><i class="fa fa-edit"></i></a></td>
                                            </tr>
                                            <?php }?>
                                          </tbody>
                                        </table>
                                        </div>
                                      </div>
                                      <!-- /.box-body -->
                                    </div>
                                </div>

                                 <div class="tab-pane" id="tab_2">
                                    <div class="box">
                                      <div class="box-body">
                                        <div id="ajax_search_responce">
                                          <table id="tokens" class="table table-bordered table-striped">
                                          <thead>
                                            <tr>
                                              <th>Key</th>
                                              <th>Short Code</th>
                                              <th>Value</th>
                                              <th>Edit</th>
                                            </tr> 
                                          </thead>
                                          
                                          <tbody>
                                            <?php foreach($tokens as $token){?>
                                              <tr id="row_<?=$token->id?>">
                                                <td id="column_name_<?=$token->id?>"><?=$token->name?></td>
                                                <td id="column_sc_<?=$token->id?>"><?=$token->token_short_code?></td>
                                                <td id="column_key_<?=$token->id?>"><?=$token->key?></td>
                                                <td id="row_btn_<?=$token->id?>"><a href="javascript:void(0);" data-id="<?=$token->id?>" id="edit_btn_<?=$token->id?>" class="edit-btn" onclick="editToken('<?=$token->id?>')"><i class="fa fa-edit"></i></a></td>
                                              </tr>
                                            <?php }?>
                                          </tbody>
                                        </table>
                                        </div>
                                      </div>
                                      <!-- /.box-body -->
                                    </div>
                                 </div>

                                 <div class="tab-pane" id="tab_3">
                                    <div class="box">
                                      <div class="box-body">
                                        <div id="ajax_search_responce">
                                          <?php if($responce = $this->session->flashdata('success')){ ?>
                                              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                          <?php } ?>
                                          <table id="smtp" class="table table-bordered table-striped">
                                          <thead>
                                            <tr>
                                              <th>Key</th>
                                              <th>Value</th>
                                              <th>Edit</th>
                                            </tr> 
                                          </thead>
                                          
                                          <tbody>
                                            <?php foreach($smtps as $smtp){?>
                                             <tr id="row_<?=$smtp->id?>">
                                                <td id="name_<?=$smtp->id?>"><?=$smtp->name?></td>
                                                <td id="column_key_<?=$smtp->id?>"><?=$smtp->value?></td>
                                                <td id="row_btn_<?=$smtp->id?>"><a href="javascript:void(0);" data-id="<?=$smtp->id?>" id="edit_btn_<?=$smtp->id?>" class="edit-btn" onclick="edit('<?=$smtp->id?>')"><i class="fa fa-edit"></i></a></td>
                                            </tr>
                                            <?php }?>
                                          </tbody>
                                        </table>
                                        </div>
                                      </div>
                                      <!-- /.box-body -->
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_4">
                                    <div class="box">
                                      <div class="box-body">
                                        <div id="ajax_search_responce">
                                          <?php if($responce = $this->session->flashdata('success')){ ?>
                                              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                          <?php } ?>
                                          <table id="drm" class="table table-bordered table-striped">
                                          <thead>
                                            <tr>
                                              <th>Key</th>
                                              <th>Value</th>
                                              <th>Edit</th>
                                            </tr> 
                                          </thead>
                                          
                                          <tbody>
                                            <?php foreach($drms as $drm){?>
                                             <tr id="row_<?=$drm->id?>">
                                                <td id="name_<?=$drm->id?>"><?=$drm->name?></td>
                                                <td id="column_key_<?=$drm->id?>"><?=$drm->value?></td>
                                                <td id="row_btn_<?=$drm->id?>"><a href="javascript:void(0);" data-id="<?=$drm->id?>" id="edit_btn_<?=$drm->id?>" class="edit-btn" onclick="edit('<?=$drm->id?>')"><i class="fa fa-edit"></i></a></td>
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
                </section>
            </div>
