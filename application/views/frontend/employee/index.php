 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <?php  if(!empty($this->session->flashdata('emp_msg'))) : ?>
          <div class="row">
            <div class="form-group col-md-2"></div>
            <div class="col-md-6   text-center p-10">
              <div class="alert alert-success"><?= $this->session->flashdata('emp_msg'); ?></div>
            </div>
          </div>
        <?php endif; ?>

        <?php  if(!empty($this->session->flashdata('delete_success'))) : ?>
          <div class="row">
            <div class="form-group col-md-2"></div>
            <div class="col-md-6   text-center p-10">
              <div class="alert alert-success"><?= $this->session->flashdata('delete_success'); ?></div>
            </div>
          </div>
        <?php endif; ?>

        <?php  if(!empty($this->session->flashdata('delete_error'))) : ?>
          <div class="row">
            <div class="form-group col-md-2"></div>
            <div class="col-md-6   text-center p-10">
              <div class="alert alert-danger"><?= $this->session->flashdata('delete_error'); ?></div>
            </div>
          </div>
        <?php endif; ?>

      
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search Result With Filters</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="ajax_search_responce" class="table-responsive">
                <table id="employee" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Create Date</th>
                  </tr> 
                </thead>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->