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
              <?php foreach ($server_items as $server) { ?>
                  <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=ucfirst($server->name)?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div id="ajax_search_responce" class="table-responsive">
                        <?php if($responce = $this->session->flashdata('success')){ ?>
                            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                        <?php } ?>
                        <table id="table-<?=$server->id?>" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Url</th>
                            <th></th>
                          </tr> 
                        </thead>
                        
                        <tbody>
                          <?php $items = $this->server_items_urls_m->getUrls($server->id); ?>
                          <?php foreach($items as $item){?>
                            <tr id="row-<?=$server->id?>-<?=$item->id?>">
                              <td id="column-name-<?=$server->id?>-<?=$item->id?>"><?=$item->name?></td>
                              <td id="column-url-<?=$server->id?>-<?=$item->id?>"><?=$item->url?></td>
                              <td id="btn-<?=$server->id?>-<?=$item->id?>"><a href="javascript:void(0);" onclick="editItem(<?=$server->id?>,<?=$item->id?>)"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem(<?=$server->id?>,<?=$item->id?>)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                      </div>
                    </div>

                    <div class="box-header with-border">
                        <h3 class="box-title"><a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat" onclick="addItem('<?=$server->id?>')"><i class="fa fa-plus"></i> Add an Item</a></h3>
                    </div>
                    <!-- /.box-body -->
                  </div>
              <?php } ?>
             </div>
        </div>
    </section>
</div>