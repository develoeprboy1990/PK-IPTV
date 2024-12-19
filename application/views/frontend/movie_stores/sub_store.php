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
                <h3 class="box-title"><?php echo anchor('movie_stores/add/'.$id, '<i class="fa fa-plus"></i> Add a Sub Store', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                <h3 class="box-title pull-right"><?php echo anchor('movie_stores', '<i class="fa fa-arrow-left"></i> Go To Main Store', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
            </div>
            <div class="box-header with-border">
              Main Store : <strong><?php echo $main_store_info->name?></strong>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="ajax_search_responce" class="table-responsive">
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
                <?php foreach($stores as $store){?>
                <tr>
                    <th><a href="<?=site_url('movie_stores/edit/'.$store['id'])?>"><?=$store['id']?></a></th>
                    <th><?=$store['name']?></th>
                    <th><?=$store['position']?></th>
                    <th><?=$store['language_name']?></th>
                    <th><?=$this->movies_m->count_movies_by_store($store['id'])?></th> <!-- Add this line -->
                    <th><?php echo ($store['active']==0) ? "Inactive" : "Active";?></th>
                    <th><?php echo btn_edit(BASE_URL.'movie_stores/edit/'.$store['id'])?></th>
                    <th><?php echo btn_delete(BASE_URL.'movie_stores/delete/'.$store['id'])?></th>
                  </tr> 
                <?php } ?>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function(){
        $('#stores').dataTable({
            processing: true,
            serverSide: true,
            ajax: "<?=BASE_URL?>movie_stores/get_substore/4",
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "position" },
                { data: "language_name" },
                { data: "total_movies" }, // Add this line
                { data: "active" },
                { data: "edit" },
                { data: "delete" }
            ]
        });
    });
  </script>`