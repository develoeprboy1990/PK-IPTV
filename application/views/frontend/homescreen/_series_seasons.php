<?php
//echo '<pre>';
 //print_r($series_list);
// print_r($series_seasons);
?>
<div class="box box-primary">
          <div class="box-body">
            
            <form method="post" action="<?= BASE_URL ?>homescreen/updateSeriesSeasons" class="form-horizontal">
              <div class="row"> 
                <div class="form-group">
                  <label for="available_series" class="col-sm-2 control-label">Series Seasons</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_series" id="multiselect_left_series" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($series_seasons as $season) { ?>
                                    <option value="<?=$season['id']?>"><?php echo $season['name'].'('.$series_list['series_'.$season['series_id']].')'; ?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_series" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_series" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_series" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_series" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_series" class="form-control" name="series_seasons[]" size="15" multiple="multiple">
                                  <?php foreach ($selected_series_seasons as $season) { ?>
                                    <option value="<?=$season['id']?>"><?php echo $season['name'].'('.$series_list['series_'.$season['series_id']].')'?></option>
                                  <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_series" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_series" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Update Series Seasons</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>