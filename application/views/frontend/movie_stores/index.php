 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <?php  if(!empty($this->session->flashdata('success'))) : ?>
          <div class="row">
            <div class="form-group col-md-2"></div>
            <div class="col-md-6   text-center p-10">
              <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            </div>
          </div>
        <?php endif; ?>
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search Result With Filters</h3>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title"><?php echo anchor('movie_stores/add', '<i class="fa fa-plus"></i> Add a Store', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="ajax_search_responce">
                <table id="stores" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Language</th>
                    <th>Total Movies</th> <!-- Add this line -->
                    <th>Active</th>
                    <th>Edit</th>
                    <th>Delete</th>
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