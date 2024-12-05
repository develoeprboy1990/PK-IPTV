<!-- Content Wrapper. Contains page content -->
<!-- views/[DEFAULT_THEME]/customers/edit_device.php -->
<div class="content-wrapper">
  <section class="content-header">
    <h1><?=$page_title ?></h1>
    <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?>
  </section>

  <section class="content">
    <div class="box box-primary">
      <div class="box-body">
        <?php if(isset($device) && is_array($device)): ?><!-- updateDevice -->
          <form method="post" action="<?= BASE_URL ?>customers/updateDevice/<?=$customer_id?>" class="form-horizontal">
            <input type="hidden" name="uuid" value="<?= $device['uuid'] ?>">
            
            <?php foreach($device as $key => $value): ?>
              <div class="row"> 
                <div class="form-group">
                  <label for="<?=$key?>" class="col-sm-2 control-label"><?=ucfirst($key)?></label>
                  <div class="col-sm-4">
                    <input type="text" id="<?=$key?>" name="<?=$key?>" class="form-control" value="<?=$value?>" <?=$key=='uuid'?'readonly':''?>/>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>

            <div class="row"> 
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                  <button type="submit" class="btn btn-success">Update Device</button>
                </div>
              </div>
            </div>
          </form>
        <?php else: ?>
          <p>No device data available.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>
<!-- /.content-wrapper -->