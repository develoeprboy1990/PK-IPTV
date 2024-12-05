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
                                  <h3 class="box-title"><?php echo anchor('news_groups/create', '<i class="fa fa-plus"></i> Add a News Group', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                              </div>
                            <?php } ?>

                            <!-- /.box-header -->
                            <div class="box-body">
                              <div id="ajax_search_responce">
                                <?php if($responce = $this->session->flashdata('success')){ ?>
                                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                <?php } ?>
                                <table id="news_groups" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>Name</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tr> 
                                </thead>
                                
                                <tbody>
                                  <?php foreach($news_groups as $group){?>
                                   <tr>
                                      <td id="group_<?=$group['id']?>"><a href="<?=site_url('news/items/'.$group['id'])?>"><?=$group['name']?></a></td>
                                      <td id="btn_<?=$group['id']?>"><a href="javascript:void(0);" onclick="edit('<?=$group['id']?>')"><i class="fa fa-edit"></i></a></td>
                                      <td><?php echo btn_delete(BASE_URL.'news_groups/delete/'.$group['id'])?></td>
                                      <td class="text-right"><a href="<?=site_url('news/items/'.$group['id'])?>"><i class="fa fa-eye"></i> View News</a>  </td>
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
