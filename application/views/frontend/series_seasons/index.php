<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(45);  // channel module id

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
                  <div class="box-header">
                    <h3 class="box-title">Search Result With Filters</h3>
                  </div>

                  <?php if($is_allow->allow_create) {?> 
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo anchor('series_seasons/create/'.$series_id, '<i class="fa fa-plus"></i> '.$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                        <h3 class="box-title pull-right"><?php echo anchor('series/', '<i class="fa fa-arrow-left"></i> Back to Series', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                  <?php } ?>

                  <div class="box-header">
                    <h3 class="box-title">Series: <?php echo $series_info->name;?></h3>
                  </div>

                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="ajax_search_responce" class="table-responsive">
                      <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                      <?php } ?>

                       <?php if($this->session->flashdata('failure')){ ?>
                          <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $this->session->flashdata('failure');?></div>
                      <?php } ?>
                      <table id="seasons" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Title</th>
			  
                          <th style=" <?php //echo ($seasons[0]['dbselect'] == 'imdb') ? 'display:none' : '' ; ?>">Image</th> 

                          <th></th> 
                          <?php //if($series_info->episode_update == '1'){?>
                          <th>Daily Episode Update</th>
                          <?php  //} ?>
                          <th>Edit</th>
			  
                          <th>Delete</th>
                        </tr> 
                      </thead>
                      <tbody>
                        <?php 
				$counters = 1;
				foreach($seasons as $season){ //print_r($season); ?>
                          <tr>
                            <td><a href="<?=site_url('series_seasons/edit/'.$season['id'])?>"><?=$counters?></a></td>
                            <!--<td><?php echo "<a href='".site_url('series_seasons/episodes/'.$season['id'])."'>".ucwords($season['name'])."</a>";?></td>-->
                            <td><?php echo ucwords($season['name']);?></td>
                            <th style=" <?php //echo ($season['dbselect'] == 'imdb') ? 'display:none' : '' ; ?>"><img src="<?php echo BASE_URL.LOCAL_PATH_IMAGES_CMS.$season['poster']; ?>" width="100" /></th>

                            <td><span class="box-title"><?php echo anchor('series_seasons/episodes/'.$season['id'], '<i class="fa fa-eye"></i> View Episodes', array('class' => 'btn btn-block btn-primary btn-flat')); ?></span></td>

                            <?php if($series_info->episode_update == '1'){?>
                            <th><?php if($season['episode_update'] == '1'){ echo '<span style=" color:#009900;">ON</span>';}else{ echo '<span style="color:red;">OFF</span>'; } ?></th>
                            <?php }else{ ?>
                            <th><span style="color:red;">OFF</span></th>
				                    <?php } ?>
                            <td><?=btn_edit(BASE_URL.'series_seasons/edit/'.$season['id'])?></td>
                            <td><?=btn_delete(BASE_URL.'series_seasons/delete/'.$season['id'])?></td>
                          </tr> 
                        <?php 
					$counters++;
				}
			?>
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