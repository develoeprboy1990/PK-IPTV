<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(11);  // channel module id
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
                  <?php if(@$is_allow->allow_create) {?> 
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo anchor('movies/create/'.@$type, '<i class="fa fa-plus"></i> '.@$add_text, array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                  <?php } ?>
                
                  <!-- /.box-header -->
                  <div class="box-body">
				 
                    <div id="ajax_search_responce" class="table-responsive">
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
						  <!--<th class="sub_store_row">Sub Store</th>-->
						  <th class="movie_tag_row">Tag</th>
						  <th class="movie_gen_row">Genres</th>
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
                      <tbody>
                        <?php foreach ($movies as $movie) { ?>
                         <tr>
                           <td><a href="<?=site_url('movies/edit/'.$movie['id'])?>"><?=$movie['id']?></a></td>
                           <td><?=ucwords(stripslashes($movie['name']))?></td>
						   <td class="poster_row"><img src="<?php echo base_url().LOCAL_PATH_IMAGES_CMS.$movie['poster'];?>" width="50" ></td>
						   <td style="display:none;" class="backdrop_row"><img src="<?php echo base_url().LOCAL_PATH_IMAGES_CMS.$movie['backdrop'];?>" width="80" ></td>
						   
								<?php
									/*$store_id = explode(',',$movie['store_id']);
									//echo $store_id[0];
									$storeparentid = $sub_store['id_'.$store_id[0]]['parent_id'];
									$store_name_set = $store['id_'.$storeparentid];
									$sub_store_name_set = '';
									foreach($store_id as $val){												
										$sub_store_name_set.=$sub_store['id_'.$val]['name'].' , ';
									}*/
									
									$store_id = explode(',',$movie['store_id']);
									//echo $store_id[0];
									$storeparentid = @$sub_store['id_'.$store_id[0]]['parent_id'];
									//$store_name_set = $store['id_'.$storeparentid];
									if($storeparentid == ''){
										$store_name_set = $store['id_'.$movie['store_id']];
									}else{
										$store_name_set = $store['id_'.$storeparentid];
									}
									
									$sub_store_name_set = '';
									foreach($store_id as $val){												
										$sub_store_name_set.=@$sub_store['id_'.$val]['name'].' , ';
									}
								?> 
						   <td class="store_row"><?php echo $store_name_set;?></td>
						  <!-- <td class="sub_store_row"><?php //echo rtrim($sub_store_name_set,' , '); ?></td>-->
						   <td class="movie_tag_row">
						   <?php
						   $movie_tag = explode(',',$movie['tags']);
						   $tag_string = '';
						   foreach($movie_tag as $val){
						   		$tag_string.=	$tags['tags_'.$val].' , ';
						   }
						   
						   echo rtrim($tag_string,' , ');
						   ?>
						   <td class="movie_gen_row">
						   <?php
						   $movie_tag = explode(',',$movie['select_genres']);
						   $tag_string = '';
						   foreach($movie_tag as $val){
						   		$tag_string.=	$genres['id_'.$val].' , ';
						   }
						   
						   echo rtrim($tag_string,' , ');
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
                           <td><?=btn_edit(BASE_URL.'movies/edit/'.$movie['id'])?> <?=btn_delete(BASE_URL.'movies/delete/'.$movie['id'])?></td>
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