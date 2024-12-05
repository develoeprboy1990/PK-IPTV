 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=$pagetitle ?></h1>
       <?php echo $breadcrumb; ?>
    </section>

    <!-- Main content -->
     <section class="content">
        <div class="box box-primary">
          <div class="box-body">
            <form method="post" action="<?= BASE_URL ?>albums/create" enctype="multipart/form-data" class="form-horizontal">

              <div class="row"> 
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-4">
                   <input type="text" id="name" name="name" class="form-control" value="" placeholder="Name"/>
                   <span class="text-danger"><?= form_error('name'); ?></span>
                  </div>
                </div> 
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="cover" class="col-sm-2 control-label">Cover (215 X 215)</label>
                  <div class="col-sm-4">
                   <input type="file" id="cover" name="cover"/>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-4">
                   <input type="text" id="description" name="description" class="form-control" value="" placeholder="Description"/>
                   <span class="text-danger"><?= form_error('description'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="category_id" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-2">
                   <select id="category_id" name="category_id" class="form-control">
                      <?php foreach($categories as $category){ ?>
                        <option value="<?=$category['id']?>"><?=$category['name']?></option>
                     <?php } ?>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="artist" class="col-sm-2 control-label">Artist</label>
                  <div class="col-sm-4">
                   <input type="text" id="artist" name="artist" class="form-control"  value="" placeholder="Artist"/>
                   <span class="text-danger"><?= form_error('artist'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="price" class="col-sm-2 control-label">Price</label>
                  <div class="col-sm-4">
                   <input type="text" id="price" name="price" class="form-control"  value="" placeholder="Price"/>
                   <span class="text-danger"><?= form_error('price'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="position" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-2">
                   <input type="text" id="position" name="position" class="form-control"  value="" placeholder="Position"/>
                   <span class="text-danger"><?= form_error('position'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="date_start" class="col-sm-2 control-label">Start Date</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="date_start" name="date_start">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="date_end" class="col-sm-2 control-label">End Date</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="date_end" name="date_end">
                    </div>
                  </div>
                </div>
              </div>
       
              <div class="row"> 
                <div class="form-group">
                  <label for="show_on_home" class="col-sm-2 control-label">Show on Home</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="show_on_home" class="onoffswitch-checkbox" id="show_on_home" value="1">
                      <label class="onoffswitch-label" for="show_on_home">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_payperview" class="col-sm-2 control-label">Is Payperview ?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="is_payperview" class="onoffswitch-checkbox" id="is_payperview" value="1">
                      <label class="onoffswitch-label" for="is_payperview">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="rule_payperview" class="col-sm-2 control-label">Rule Payperview</label>
                  <div class="col-sm-4">
                   <input type="text" id="rule_payperview" name="rule_payperview" class="form-control"  value="" placeholder="Rule Payperview"/>
                   <span class="text-danger"><?= form_error('rule_payperview'); ?></span>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="is_kids_friendly" class="col-sm-2 control-label">Is Kids Friendly ?</label>
                  <div class="col-sm-4">
                    <div class="onoffswitch">
                      <input type="checkbox" name="is_kids_friendly" class="onoffswitch-checkbox" id="is_kids_friendly" value="1">
                      <label class="onoffswitch-label" for="is_kids_friendly">
                          <span class="onoffswitch-inner"></span>
                          <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group">
                  <label for="tokenize" class="col-sm-2 control-label">Token</label>
                  <div class="col-sm-2">
                   <select id="tokenize" name="tokenize" class="form-control">
                      <?php foreach($tokens as $token){ ?>
                        <option value="<?=$token->id?>"><?=$token->name?></option>
                     <?php } ?>
                   </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-success ">Add <?=$title?></button>
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


 