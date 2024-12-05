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
                      <h3 class="box-title"><?php echo anchor('news/create/'.$group_info->id, '<i class="fa fa-plus"></i> Add a News', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                  </div>
                <?php } ?>

                <div class="box-header">
                  <h3 class="box-title"><strong>News Group:</strong> <?php echo $group_info->name;?></h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                  <div id="ajax_search_responce">
                    <?php if($responce = $this->session->flashdata('success')){ ?>
                        <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                    <?php } ?>
                    <table id="news" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th></th>
                      </tr> 
                    </thead>
                    
                    <tbody>
                      <?php foreach($news_items as $item){?>
                       <tr>
                          <td><?=$item['title']?></td>
                          <td><?=substr(strip_tags($item['description']),0,120)?>...</td>
                          <td><?=date('Y-m-d H:i:s',$item['date_created'])?></td>
                          <td><?php echo btn_edit(BASE_URL.'news/edit/'.$item['news_group_id'].'/'.$item['id']);?> <?php echo btn_delete(BASE_URL.'news/delete/'.$item['news_group_id'].'/'.$item['id'])?></td>
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
