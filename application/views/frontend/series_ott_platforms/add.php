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
        <form method="post" action="<?= BASE_URL ?>series_ott_platforms/add">
          <div class="row"> 
            <div class="form-group col-md-2"></div>
            <div class="form-group col-md-6">
              <label for="name">Series OTT Platform Name</label>
              <input type="text" id="name" name="name" class="form-control"/>
              <span class="text-danger"><?= form_error('name'); ?></span>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6 text-center">
              <button type="submit" class="btn btn-success">Add Series OTT Platform</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->