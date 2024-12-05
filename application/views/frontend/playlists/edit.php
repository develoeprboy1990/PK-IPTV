<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$is_allow = $this->ion_auth->checkPermission(14);  // Securities module id

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
                              <li class=""><a href="#tab_1" data-toggle="tab" id="tab-menu-1">Playlist Details</a></li>
                              <li class=""><a href="#tab_2" data-toggle="tab" id="tab-menu-2">Content Items </a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="box box-primary">
                                      <div class="box-header">General</div>
                                      <div class="box-body">
                                        <?php if($responce = $this->session->flashdata('success')){ ?>
                                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                        <?php } ?>

                                        <form method="post" action="<?= BASE_URL ?>playlists/edit/<?=$details->id?>" class="form-horizontal">
                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="name" class="col-sm-2 control-label">Name</label>
                                              <div class="col-sm-4">
                                               <input type="text" id="name" name="name" class="form-control" value="<?=$details->name?>" placeholder="Name" required/>
                                               <span class="text-danger"><?= form_error('name'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="url" class="col-sm-2 control-label">Url</label>
                                              <div class="col-sm-4">
                                               <input type="text" id="url" name="url" class="form-control" value="<?=$details->url?>" required/>
                                               <span class="text-danger"><?= form_error('name'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="start_time" class="col-sm-2 control-label">Start time (GMT)</label>
                                              <div class="col-sm-4">
                                                <div class="input-group">
                                                  <input type="text" name="start_time" class="form-control pull-right timepicker" value="<?=date("h:i A",strtotime($details->start_time))?>" id="start_time" required>
                                                  <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                  </div>
                                                </div>
                                                <span class="text-danger"><?= form_error('start_time'); ?></span>
                                              </div>
                                            </div>
                                          </div>
                                      
                                          <div class="row"> 
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label"></label>
                                              <div class="col-sm-4">
                                                <button type="submit" class="btn btn-success">Update Playlist</button>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>

                                    <div class="box">
                                      <div class="box-header">Fill Playlist</div>
                                      <div class="box-body">
                                        <p>Note: Fill the playlist to 24 hours by copying the current playlist untill the 24 hours are filled</p>
                                        <div class="row"> 
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label"></label>
                                              <div class="col-sm-4">
                                                <a href="<?=site_url('playlists/fillPlaylist/'.$details->id)?>" class="btn btn-success ">Fill Playlist</a>
                                              </div>
                                            </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="box box-primary">
                                      <div class="box-header">Playout List</div>
                                      <div class="box-body">
                                        <?php if($responce = $this->session->flashdata('success_add_playlist_item')){ ?>
                                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                        <?php } ?>
                                        <form method="post" action="<?= BASE_URL ?>playlists/addPlayListItem/<?=$details->id?>" class="form-horizontal">
                                          <input type="hidden" name="playlist_id" value="<?=$details->id?>">
                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="playlist_content_id" class="col-sm-2 control-label">Content</label>
                                              <div class="col-sm-4">
                                               <select name="playlist_content_id" id="playlist_content_id" class="form-control">
                                                <?php foreach ($playlist_content_items as $content) {?>
                                                    <option value="<?=$content['id']?>"><?=$content['name']?></option>
                                                <?php }?>
                                               </select>
                                               <span class="text-danger"><?= form_error('playlist_content_id'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="position" class="col-sm-2 control-label">Position</label>
                                              <div class="col-sm-4">
                                               <input type="text" id="position" name="position" class="form-control" value="<?=set_value('position')?>" required/>
                                               <span class="text-danger"><?= form_error('position'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label"></label>
                                              <div class="col-sm-4">
                                                <button type="submit" class="btn btn-success ">Add Item</button>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>

                                    <div class="box">
                                      <div class="box-header">Playlist Items</div>
                                      <div class="box-body">
                                        <div id="ajax_search_responce">
                                          <table id="playlist_items" class="table table-bordered table-striped">
                                            <thead>
                                              <tr>
                                                <th>Position</th>
                                                <th>Name</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Url</th>
                                                <th></th>
                                              </tr> 
                                            </thead>
                                            
                                            <tbody>
                                              <?php foreach($playlist_items as $item){?>
                                               <tr id="row_<?=$item->playlist_item_id?>">
                                                  <td id="column_position_<?=$item->playlist_item_id?>"><?=$item->position?></td>
                                                  <td><?=$item->content_name?></td>
                                                  <td><?=date('g:i A', strtotime($item->item_start_time))?></td>
                                                  <td><?=date('g:i A', strtotime($item->item_end_time))?></td>
                                                  <td><?=$item->content_url?></td>
                                                  <td id="row_btn_<?=$item->playlist_item_id?>"><a href="javascript:void(0);" data-id="<?=$item->playlist_item_id?>" onclick="editPlaylistItem(<?=$item->playlist_item_id?>)"><i class="fa fa-edit"></i></a> <a href="<?=site_url('playlists/deletePlaylistItem/'.$details->id.'/'.$item->playlist_item_id)?>" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a></td>
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
                                    <div class="box box-primary">
                                      <div class="box-header">Content</div>
                                      <div class="box-body">
                                        <?php if($responce = $this->session->flashdata('success_add_content')){ ?>
                                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                        <?php } ?>

                                        <form method="post" action="<?= BASE_URL ?>playlists/addContent/<?=$details->id?>" class="form-horizontal">
                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="name" class="col-sm-2 control-label">Name</label>
                                              <div class="col-sm-4">
                                               <input type="text" id="name" name="name" class="form-control" value="<?=set_value('name')?>" placeholder="Name" required/>
                                               <span class="text-danger"><?= form_error('name'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="url" class="col-sm-2 control-label">Url</label>
                                              <div class="col-sm-4">
                                               <input type="text" id="url" name="url" class="form-control" value="<?=set_value('url')?>" required/>
                                               <span class="text-danger"><?= form_error('url'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label for="length_seconds" class="col-sm-2 control-label">Length in Seconds</label>
                                              <div class="col-sm-4">
                                               <input type="text" id="length_seconds" name="length_seconds" class="form-control" value="<?=set_value('length_seconds')?>" required/>
                                               <span class="text-danger"><?= form_error('length_seconds'); ?></span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="row"> 
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label"></label>
                                              <div class="col-sm-4">
                                                <button type="submit" class="btn btn-success ">Add Item</button>
                                              </div>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>

                                    <div class="box">
                                      <div class="box-header">Content Items</div>
                                      <div class="box-body">
                                        <div id="ajax_search_responce">
                                          <table id="playlist_content_items" class="table table-bordered table-striped">
                                          <thead>
                                            <tr>
                                              <th>Name</th>
                                              <th>Length</th>
                                              <th>Url</th>
                                              <th></th>
                                            </tr> 
                                          </thead>
                                          
                                          <tbody>
                                            <?php foreach($playlist_content_items as $item){?>
                                              <tr id="row_<?=$item['id']?>">
                                                <td id="column_name_<?=$item['id']?>"><?=$item['name']?></td>
                                                <td id="column_length_<?=$item['id']?>"><?=$item['length_seconds']?></td>
                                                <td id="column_url_<?=$item['id']?>"><?=$item['url']?></td>
                                                <td id="row_btn_<?=$item['id']?>"><a href="javascript:void(0);" onclick="editContentItem(<?=$item['id']?>)"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteContentItem(<?=$item['id']?>)"><i class="fa fa-trash"></i></a></td>
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
