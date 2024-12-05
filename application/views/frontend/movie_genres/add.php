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
            <form method="post" action="<?= BASE_URL ?>movie_genres/add">
               <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="order_no">Display Order</label>
                  <input type="number" id="order_no" name="order_no" class="form-control" min="0"/>
                  <span class="text-danger"><?= form_error('order_no'); ?></span>
                </div>
              </div>
              <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="name">Genre Name</label>
                  <input type="text" id="name" name="name" class="form-control"/>
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
                            <option value="<?=$store['id']?>"><?=$store['name']?></option>
                      <?php }?>
                  </select>
                </div>
              </div>

              <div class="row"> 
                <div class="form-group col-md-2"></div>
                <div class="form-group col-md-6">
                  <label for="sub-store">Movie Sub Stores</label>
                  <select id="sub-store" name="sub_store" class="form-control">
                  </select>
                </div>
              </div>-->

              <div class="row">
                <div class="form-group col-md-6 text-center">
                  <button type="submit" class="btn btn-success ">Add Genre</button>
                </div>
              </div>

            </form>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->