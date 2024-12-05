 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>movie_genres/edit/<?= $details->id; ?>">
              <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="order_no">Display Order</label>
                  <input type="number" id="order_no" name="order_no" value="<?= $details->order_no; ?>" class="form-control" min="0"/>
                  <span class="text-danger"><?= form_error('order_no'); ?></span>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="name">Name</label>
                  <input type="text" id="name" name="name" value="<?= $details->name; ?>" class="form-control"/>
                  <span class="text-danger"><?= form_error('name'); ?></span>
                </div>
              </div>

              <!--<div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="parent-store">Movie Stores</label>
                  <select id="parent-store" name="parent_store" class="form-control">
                      <option value="">Select a Store</option>
                      <?php foreach($stores as $store){?>
                            <option value="<?=$store['id']?>" <?=($store['id']==$parent_store_id) ? "selected": ""?> ><?=$store['name']?></option>
                      <?php }?>
                  </select>
                </div>
              </div>-->

              <!--<div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="sub-store">Movie Sub Stores </label>
                  <select id="sub-store" name="sub_store" class="form-control">
                      <?php if(count($sub_stores)>0) {?>
                          <option value="">Select a Store</option>
                            <?php  foreach($sub_stores as $store){?>
                              <option value="<?=$store['id']?>" <?=($store['id']==$sub_store_id) ? "selected": ""?> ><?=$store['name']?></option>
                            <?php }?>
                      <?php }else{?>
                          <option value="">No Sub Store Available</option>
                      <?php }?>
                  </select>
                </div>
              </div>-->
				<!--<div class="row">
				<div class="col-sm-2"></div>
												
											   <div class="col-sm-3"><label for="sub-store">Genres</label>
												   <select name="genre_group" id="multiselect_left" class="form-control" size="15" multiple="multiple">
													<?php foreach($genres_all as $genre){?>
														   <?php if(!in_array($genre->id,$genres_select)){?>
													  			<option value="<?=$genre->id?>"><?=$genre->name?></option>
													  		<?php } ?>
													<?php } ?>
												   </select>
											   </div>
				
											  <div class="col-sm-2"><label for="sub-store"></label>
												 <button type="button" id="btn_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
												 <button type="button" id="btn_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
												 <button type="button" id="btn_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
												 <button type="button" id="btn_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
											  </div>
				
											  <div class="col-sm-3"><label for="sub-store"></label>
												<select id="multiselect_right" class="form-control" name="genres[]" size="15" multiple="multiple">
													<?php foreach($genres_all as $genre){?>
													  <?php if(in_array($genre->id,$genres_select)){?>
													  <option value="<?=$genre->id?>"><?=$genre->name?></option>
													  <?php }?>
													<?php } ?>
												</select>
												<div class="row">
												  <div class="col-xs-6">
													<button type="button" id="multiselect_move_up" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
												  </div>
												  <div class="col-xs-6">
													<button type="button" id="multiselect_move_down" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
												  </div>
												</div>
											  </div>
											</div>-->
              <div class="row">
                <div class="form-group col-md-6 text-center">
                  <button type="submit" class="btn btn-success ">Edit Genre</button>
                </div>
              </div>

            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->