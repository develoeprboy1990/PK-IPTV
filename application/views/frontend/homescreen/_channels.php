<div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>homescreen/updateChannels" class="form-horizontal">
              <div class="row"> 
                <div class="form-group">
                  <label for="available_channels" class="col-sm-2 control-label">Channels</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="available_channels" id="multiselect_left_channels" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($channels as $channel) { ?>
                                    <option value="<?=$channel['id']?>"><?=$channel['channel_name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_channels" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_channels" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_channels" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_channels" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_channels" class="form-control" name="channels[]" size="15" multiple="multiple">
                              <?php foreach ($selected_channels as $channel) { ?>
                                    <option value="<?=$channel['id']?>"><?=$channel['channel_name']?></option>
                                <?php }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_channels" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_channels" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
                    <button type="submit" class="btn btn-success ">Update Channels</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>