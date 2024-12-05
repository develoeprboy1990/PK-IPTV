<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(11);  // channel module id
if(!isset($is_allow))
{
   redirect('login', 'refresh');
}
?> 
<style>
.btn-group {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
}

.btn-group .btn {
  flex: 1;
  padding: 2px 5px;
  font-size: 12px;
}

@media (max-width: 768px) {
  .btn-group {
    flex-direction: column;
    gap: 5px;
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
                  <div onclick="showsearchoption()" style="margin-right: 10px;padding: 3px 10px;border: 1px solid #ccc;font-weight: bold;cursor: pointer; position: absolute;margin-left: 85%;z-index: 200000;" id="showsearchoptionbm">View Details &uarr;</div>
                  <div class="box-header">
                    <h3 class="box-title">Search Result With Filters</h3>
                  
                     <div style="margin:10px 0; display:none;" id="searchbm_select">
                     <!-- <span style="margin-right:10px;"><input type="checkbox" name="" id="" value="" style="margin-right:5px;" checked="checked" />SL. NO</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="" id="" value="" style="margin-right:5px;" checked="checked" />Name</span>-->
                      <span style="margin-right:10px;"><input type="checkbox" name="store" id="store" value="1" style="margin-right:5px;" checked="checked"  />Store</span>
                     <!-- <span style="margin-right:10px;"><input type="checkbox" name="sub_store" id="sub_store" value="1" style="margin-right:5px;" checked="checked" />Sub Stores</span>-->
                      <span style="margin-right:10px;"><input type="checkbox" name="movie_tag" id="movie_tag" value="1" style="margin-right:5px;" checked="checked" />Movie Tags</span>
                        <span style="margin-right:10px;"><input type="checkbox" name="movie_gen" id="movie_gen" value="1" style="margin-right:5px;" checked="checked" />Movie Genres</span>
                      
                      <span style="margin-right:10px;"><input type="checkbox" name="poster" id="poster" value="1" style="margin-right:5px;" checked="checked" />Poster</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="backdrop" id="backdrop" value="1" style="margin-right:5px;" />Backdrop</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="myear" id="myear" value="1" style="margin-right:5px;" />Year</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="mcast" id="mcast" value="1" style="margin-right:5px;" />Movie Cast</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="trailer" id="trailer" value="1" style="margin-right:5px;" />Trailer Url</span>           
                      <span style="margin-right:10px;"><input type="checkbox" name="language" id="language" value="1" style="margin-right:5px;" checked="checked" />Language</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="rating" id="rating" value="1" style="margin-right:5px;" checked="checked" />Rating</span>
                      <span style="margin-right:10px;"><input type="checkbox" name="crating" id="crating" value="1" style="margin-right:5px;" />Content Rating</span>
                  </div>
                  </div>
                 
<!--                            <div class="box-header with-border"> 
                            <?php if($is_allow->allow_create) {?> 
                            <h3 class="box-title"><?php echo anchor('movies/create/'.(isset($type) ? $type : ""), '<i class="fa fa-plus"></i> '.$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                            <?php } ?>
                            <div class="col-sm-2" style="float:right;">
                            <input type="text" value="" name="moviesearch" id="moviesearch" placeholder="Search Movies..." class="form-control" />
                            </div>
                            </div> -->

                  <!-- /.box-header -->
                  <div class="box-body">
                 
                    <div id="ajax_search_responce">
                      <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                      <?php } ?>

                       <?php if($this->session->flashdata('failure')){ ?>
                          <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $this->session->flashdata('failure');?></div>
                      <?php } ?>
                                    <table id="movies" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>SL. NO</th>
                          <th>Name</th>
                                                    <th class="poster_row">Poster</th>
                                                    <th style="display:none;" class="backdrop_row">Backdrop</th>
                                                    <th class="store_row">Store</th>
                                                    <!-- <th class="sub_store_row">Sub Store</th>-->
                                                    <th class="movie_tag_row">Tag</th>
                                                    <th class="movie_gen_row">Genres</th>
                                                    <th class="ott_platforms_row">OTT Platforms</th>
                                                    <th class="language_row">Language</th>
                                                    <th class="myear_row" style="display:none;">Year</th>
                                                    <th style="display:none;" class="mcast_row">Movie Cast</th>
                                                    <th style="display:none;" class="trailer_row">Trailert</th>
                                                    <th class="rating_row">Rating</th>
                                                    <th style="display:none;" class="crating_row">Content Rating</th>       
                                                    <th>Show Home</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                        </tr> 
                      </thead>
                      <tbody ><!-- id="movie_search" -->
                        <?php 
                        //print_r( $store);
                        foreach ($movies as $movie) { ?>
                         <tr>
                           <td><a href="<?=site_url('movies/edit/'.$movie['id'])?>"><?=$movie['id']?></a></td>
                           <td><?=ucwords(stripslashes($movie['name']))?></td>
                           <td class="poster_row">
                            <img src="<?php echo base_url().LOCAL_PATH_IMAGES_CMS.$movie['poster'];?>" width="50" >
                           </td>
                           <td style="display:none;" class="backdrop_row">
                            <img src="<?php echo base_url().LOCAL_PATH_IMAGES_CMS.$movie['backdrop'];?>" width="80" >
                           </td>
                            <?php
                                $store_id = explode(',',$movie['store_id']);
                                //echo $store_id[0];
                                $storeparentid = @$sub_store['id_'.$store_id[0]]['parent_id'];
                                //$store_name_set = $store['id_'.$storeparentid];
                                if($storeparentid == ''){
                                    $store_name_set = $store['id_'.$movie['store_id']];
                                }else{
                                    $store_name_set = @$store['id_'.$storeparentid];
                                }
                                
                                $sub_store_name_set = '';
                                foreach($store_id as $val){                                             
                                    $sub_store_name_set.= @$sub_store['id_'.$val]['name'].' , ';
                                }
                            ?> 
                            <td class="store_row"><?php echo $store_name_set;?></td>
                            <!--<td class="sub_store_row"><?php echo rtrim($sub_store_name_set,' , '); ?></td>-->
                            <td class="movie_tag_row">
                               <?php
                               $movie_tag = explode(',',$movie['tags']);
                               $tag_string = '';
                               foreach($movie_tag as $val){
                                    $tag_string.=   $tags['tags_'.$val].' , ';
                               }
                               
                               echo rtrim($tag_string,' , ');
                               ?>
                            </td>
                            <td class="movie_gen_row">
                               <?php
                               $movie_tag = explode(',',$movie['select_genres']);
                               $tag_string = '';
                               foreach($movie_tag as $val){
                                    $tag_string.=   $genres['id_'.$val].' , ';
                               }
                               
                               echo rtrim($tag_string,' , ');
                               ?>
                            </td>
                            <td class="ott_platforms_row">
                               <?php
                                if (empty($movie['ott_platforms'])) {
                                    echo "No Selection";
                                } else {
                                    $movie_platforms = explode(',', $movie['ott_platforms']);
                                    $platform_string = '';
                                    foreach ($movie_platforms as $val) {
                                        $platform_string .= @$ott_platforms['platform_'.$val].' , ';
                                    }
                                    echo rtrim($platform_string, ' , ');
                                }
                                ?>
                            </td>
                            <td class="language_row"><?php echo $languages['lang_'.$movie['language']];?></td>
                            <td class="myear_row" style="display:none;"><?=$movie['year']?></td>
                            <td style="display:none;" class="mcast_row"><?=ucwords($movie['actor'])?></td>
                            <td style="display:none;" class="trailer_row"><?=$movie['trailer']?></td>
                            <td class="rating_row"><?=$movie['rating']?></td>
                            <td style="display:none;" class="crating_row"><?=$movie['age_rating']?></td>
                            <td><?=($movie['show_on_home']==1) ? "ON" : "OFF"?></td>
                            <td><?=($movie['status']==1) ? "Active" : "Disabled"?></td>
                      
                            <td>
                              <div class="btn-group" role="group" aria-label="Movie actions">
                                <a href="<?=BASE_URL.'movies/edit/'.$movie['id']?>" class="btn btn-xs btn-primary" title="Edit">
                                  <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="<?=BASE_URL.'movies/delete/'.$movie['id']?>" class="btn btn-xs btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this movie?');">
                                  <i class="fa fa-trash"></i> Delete
                                </a>
                                <a href="javascript:void(0);" class="btn btn-xs btn-success play-movie" data-movie-id="<?=$movie['id']?>" title="Play">
                                  <i class="fa fa-play"></i> Play
                                </a>
                              </div>
                            </td>
                        </tr>
                        <?php }?>
                      </tbody>
                    </table>
                                        <!-- <ul class="pagination" style="    float: right;" id="movie_pagination">
                                            <?php echo $this->pagination->create_links();?>
                                        </ul> -->
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
             </div>
        </div>
    </section>
</div>
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
        <?php if($movie_url_permission && $movie_url_permission->allow_view == 1): ?>
                  <button id="copyUrlBtn" class="btn btn-sm btn-primary">
                    <i class="fa fa-copy"></i> Copy URL
                  </button>
                <?php endif; ?>
        <select id="videoSelector" class="form-control" style="display: inline-block; width: auto;">
          <option value="">Select Video</option>
        </select>
        <!-- <button onclick="toggleVideoStats()" class="btn btn-sm btn-info">
          <i class="fa fa-info-circle"></i> Toggle Stats
        </button> -->
      </div>
    </div>
  </div>
</div>