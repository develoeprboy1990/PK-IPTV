<div class="box box-primary">
          <div class="box-body">
            <?php if($responce = $this->session->flashdata('success')){ ?>
              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
            <?php } ?>

            <form method="post" action="<?= BASE_URL ?>channels/updatePackageGroup/<?php echo $channel_detail->id?>/2" class="form-horizontal">
              <div class="row"> 
                <input type="hidden" name="total_channel_group" id="multiselect_right_number"> 
                <div class="form-group">
                  <label for="channel_group" class="col-sm-2 control-label">Channel Group</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="from" id="multiselect_left" class="form-control" size="15" multiple="multiple">
                                    <?php foreach ($groups_channel as $group) { ?>

                                      
                                          <option value="<?=$group['id']?>"><?=$group['name']?></option>
                                       

                                    <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right" class="form-control" name="channel_group[]" size="15" multiple="multiple">
                                  <?php foreach ($groups_channel as $group) { ?>
                                       <?php if(in_array($group['id'], $channel_groups_ids)) { ?>
                                          <option value="<?=$group['id']?>"><?=$group['name']?></option>
                                        <?php } ?>
                                    <?php }?>
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
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <input type="hidden" name="total_package" id="multiselect_right_package_number"> 
                <div class="form-group">
                  <label for="channel_group" class="col-sm-2 control-label">Packages</label>
                  <div class="col-sm-10">
                    <div class="panel panel-default" style="background-color:#fff; width: 800px;">
                      <div class="panel-body" >
                         <div class="row">
                           <div class="col-sm-5">
                               <select name="package_from" id="multiselect_left_package" class="form-control" size="15" multiple="multiple">
                                  <?php foreach ($packages as $pkt) { ?>
                                    <option value="<?=$pkt['id']?>"><?=$pkt['name']?></option>
                                  <?php }?>
                               </select>
                           </div>

                          <div class="col-sm-2">
                             <button type="button" id="btn_rightAll_package" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                             <button type="button" id="btn_rightSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                             <button type="button" id="btn_leftSelected_package" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                             <button type="button" id="btn_leftAll_package" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                          </div>

                          <div class="col-sm-5">
                            <select id="multiselect_right_package" class="form-control" name="packages[]" size="15" multiple="multiple">
                                  <?php foreach ($packages as $pkt) { 
                                      if(in_array($pkt['id'],$channel_packages)){
                                    ?>
                                    <option value="<?=$pkt['id']?>"><?=$pkt['name']?></option>
                                  <?php }
                                  }?>
                            </select>
                            <div class="row">
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_up_package" class="btn btn-block"><i class="glyphicon glyphicon-arrow-up"></i></button>
                              </div>
                              <div class="col-xs-6">
                                <button type="button" id="multiselect_move_down_package" class="btn btn-block col-sm-6"><i class="glyphicon glyphicon-arrow-down"></i></button>
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
                  <label for="" class="col-sm-2 control-label"></label>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-success ">Update Channel</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>