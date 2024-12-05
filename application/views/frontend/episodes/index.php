<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(45);  // channel module id
if(!isset($is_allow))
{    
   redirect('login', 'refresh');
}
?>  
<style>
.btn-group {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}

.btn-group .btn {
  flex: 1;
  min-width: 70px; /* Adjust as needed */
}

@media (max-width: 768px) {
  .btn-group {
    flex-direction: column;
  }
  
  .btn-group .btn {
    width: 100%;
  }
}
</style>
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
                    <h3 class="box-title" style="float:left;"><?php echo anchor('episodes/create/'.$season_id, '<i class="fa fa-plus"></i> '.$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
	                  <h3 class="box-title" style="float:left; margin:0 20px;" onclick="$('#dfggdg').toggle();"> <span class="btn btn-block btn-primary btn-flat"><i class="fa fa-plus"></i> <?php echo $import_text; ?></span></h3>
                		<div style="width: 40%;float: left;border: 1px solid #ccc;padding: 20px; display:none;" id="dfggdg">
                  		<form action="" method="post" enctype="multipart/form-data">
                  			<span style="width: 70%;float: left;">
                  				<input type="file" name="csv" id="csv" class="form-control input-sm"  />
                  			</span>
                  			<span style="width: 28%;float: right;">
                  				<input type="submit" name="import_csv" id="import_csv" value="Import" class="btn btn-block btn-primary btn-flat" />
                  			</span>
                  		</form>
                		  <div><a href="<?=BASE_URL?>series_seasons/downloadcsv">Download Sample</a></div>
                		</div>
                    <h3 class="box-title pull-right"><?php echo anchor('series/seasons/'.$season_info->series_id, '<i class="fa fa-arrow-left"></i> Back to Seasons', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                </div>
                <?php } ?>
                <div class="box-header">
                  <h3 class="box-title">Season: <?php echo $season_info->name;?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="ajax_search_responce">
                    <?php if($responce = $this->session->flashdata('success')){ ?>
                        <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                    <?php } ?>
                    <table id="episodes" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sequence</th>
                        <th>image</th>
                        <th>Title</th> 
                        <th>URL</th> 
                        <th style="width:200px;">Actions</th>    
                      </tr> 
                    </thead>
                    <tbody>
                      <?php foreach($episodes as $episode){?>
                        <tr>
                          <td><a href="<?=site_url('episodes/edit/'.$episode['id'])?>"><?=@$episode['sequence_id']?></a></td>                                        
                          <td><img src="<?=BASE_URL.LOCAL_PATH_IMAGES_CMS.@$episode['image']?>" width="80" /></td>
                          <td><?=$episode['title']?></td>    
                          <td><?=@$episode['url']?></td>     
                          
                          <td>
                            <div class="btn-group" role="group" aria-label="Episode actions">
                              <a href="<?=BASE_URL.'episodes/edit/'.@$episode['id']?>" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-edit"></i> Edit
                              </a>
                              <a href="<?=BASE_URL.'episodes/delete/'.@$episode['id']?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this episode?');">
                                <i class="fa fa-trash"></i> Delete
                              </a>
                              <a href="#" class="btn btn-sm btn-success play-url" data-url="<?=@$episode['url']?>" data-server-url-id="<?=@$episode['server_url_id']?>" data-title="<?=$episode['title']?>" title="Play">
                                <i class="fa fa-play"></i> Play
                              </a>
                            </div>
                          </td>
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

<!-- Modal for video player -->
<div class="modal fade" id="videoPlayerModal" tabindex="-1" role="dialog" aria-labelledby="videoPlayerModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="videoPlayerModalLabel">Video Player</h4>
      </div>
      <div class="modal-body">
        <div id="videoContainer" style="position: relative;">
          <video id="videoPlayer" controls style="width: 100%;">
            Your browser does not support the video tag.
          </video>
          <div id="videoStats" style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 10px; font-size: 12px; display: none;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        
          <button id="copyUrlBtn" class="btn btn-sm btn-primary">
            <i class="fa fa-copy"></i> Copy URL
          </button>
       
      </div>
    </div>
  </div>
</div>