<div class="content-wrapper">
  <section class="content-header">
    <h1><?=$page_title?></h1>
     <?php echo $breadcrumb; ?>
  </section>
  <section class="content">
      <div class="box box-primary">
        <div class="box-header"><h4><strong>Brand Name IMS and CMS</strong></h4> </div>
        <div class="box-body">
          <?php foreach($brands as $brand){?>
            <div class="row"> 
              <div class="form-group">
                <label for="dt-<?=$brand->id?>" class="col-sm-2 control-label"><?=$brand->name?></label>
                <div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
                  <input type="text" id="dt-<?=$brand->id?>" name="<?=$brand->slug?>" class="form-control" value="<?=$brand->value?>"/>
                  <span class="input-group-btn">
                    <button type="button" data-id='<?=$brand->id?>' class="btn large btn-success btn-flat w-sm waves-effect waves-light">Update</button>
                  </span>
                </div>
                <p id="message-<?=$brand->id?>" class="margin has-success"></p>
              </div>
            </div>
           <?php }?>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header"><h4><strong>AES Encrypt Key</strong></h4> </div>
        <div class="box-body">
          <?php foreach($aes_encrypt_key as $key){?>
            <div class="row"> 
              <div class="form-group">
                <label for="dt-<?=$key->id?>" class="col-sm-2 control-label"><?=$key->name?></label>
                <div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
                  <input type="text" id="dt-<?=$key->id?>" name="<?=$key->slug?>" class="form-control" value="<?=$key->value?>"/>
                  <span class="input-group-btn">
                    <button type="button" data-id='<?=$key->id?>' class="btn large btn-success btn-flat w-sm waves-effect waves-light">Update</button>
                  </span>
                </div>
                <p id="message-<?=$key->id?>" class="margin has-success"></p>
              </div>
            </div>
           <?php }?>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header"><h4><strong>API</strong></h4> </div>
        <div class="box-body">

          <?php foreach($apis as $api){?>
            <div class="row"> 
              <div class="form-group">
                <label for="dt-<?=$api->id?>" class="col-sm-2 control-label"><?=$api->name?></label>
                <div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
                  <input type="text" id="dt-<?=$api->id?>" name="<?=$api->slug?>" class="form-control" value="<?=$api->value?>"/>
                  <span class="input-group-btn">
                    <button type="button" data-id='<?=$api->id?>' class="btn large btn-success btn-flat w-sm waves-effect waves-light">Update</button>
                  </span>
                </div>
                <p id="message-<?=$api->id?>" class="margin has-success"></p>
              </div>
            </div>
           <?php }?>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header"> <h4><strong>Electronic Programme Guide (EPG)</strong></h4> </div>
        <div class="box-body">
          <?php foreach($epgs as $epg){?>
            <div class="row"> 
              <div class="form-group">
                <label for="<?=$epg->id?>" class="col-sm-2 control-label"><?=$epg->name?></label>
                <div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
                  <input type="text" id="dt-<?=$epg->id?>" name="<?=$epg->slug?>" class="form-control" value="<?=$epg->value?>" required/>
                  <span class="input-group-btn">
                    <button type="button" data-id='<?=$epg->id?>' class="btn large btn-success btn-flat w-sm waves-effect waves-light">Update</button>
                  </span>
                </div>
                <p id="message-<?=$epg->id?>" class="margin has-success"></p>
              </div>
            </div>
          <?php }?>
        </div>
      </div>

      <div class="box box-primary">
        <div class="box-header"> <h4><strong>Customer Credentials</strong></h4> </div>
        <div class="box-body">
          <?php foreach($customers as $customer){?>
            <div class="row"> 
              <div class="form-group">
                <label for="<?=$customer->id?>" class="col-sm-2 control-label"><?=$customer->name?></label>
                <div class="input-group input-group-sm col-sm-4" style="padding-left: 20px;padding-right: 20px;">
                  <input type="text" id="dt-<?=$customer->id?>" name="<?=$customer->slug?>" class="form-control" value="<?=$customer->value?>" required/>
                  <span class="input-group-btn">
                    <button type="button" data-id='<?=$customer->id?>' class="btn large btn-success btn-flat w-sm waves-effect waves-light">Update</button>
                  </span>
                </div>
                <p id="message-<?=$customer->id?>" class="margin has-success"></p>
              </div>
            </div>
          <?php }?>
        </div>
      </div>
  </section>
</div>
  