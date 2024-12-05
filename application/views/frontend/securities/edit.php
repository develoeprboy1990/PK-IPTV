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
          <div class="box-header"><h4><strong>Securities</strong></h4> </div>
          <div class="box-body">

            <?php foreach($securities as $security){?>
              <div class="row"> 
                <div class="form-group">
                  <label for="dt-<?=$security->id?>" class="col-sm-2 control-label"><?=$security->name?></label>
                  <div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
                    <input type="text" id="dt-<?=$security->id?>" name="<?=$security->slug?>" class="form-control" value="<?=$security->value?>"/>
                    <span class="input-group-btn">
                      <button type="button" data-id='<?=$security->id?>' class="btn large btn-success btn-flat w-sm waves-effect waves-light">Update</button>
                    </span>
                  </div>
                  <p id="message-<?=$security->id?>" class="margin has-success"></p>
                </div>
              </div>
             <? }?>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->