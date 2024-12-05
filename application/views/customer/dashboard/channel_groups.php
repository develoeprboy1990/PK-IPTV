 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$page_title ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content --> 
     <section class="content">
        <div class="box box-primary">
          <div class="box-header">
          <?php if($responce = $this->session->flashdata('success')){ ?>
            <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
          <?php } ?>
          </div>
          <div class="box-header">
            Add or Remove Channel Groups from your account
          </div>
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>customer/channelGroups" class="form-horizontal">
              <div class="row"> 
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
                                    <?php if(in_array($group['id'],$get_selected_groups)){?>
                                      <option value="<?=$group['id']?>"><?=$group['name']?></option>
                                    <?php }?>
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
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-md-6">
                    <button type="submit" class="btn btn-success ">Add Channel Group</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 