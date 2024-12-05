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
                <h3 class="box-title"><?php echo anchor('series_stores/add/'.$id, '<i class="fa fa-plus"></i> Add a Sub Store', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                <h3 class="box-title pull-right"><?php echo anchor('series_stores', '<i class="fa fa-arrow-left"></i> Go To Main Store', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
            </div>
            <div class="box-header with-border">
              Main Store : <strong><?php echo $main_store_info->name?></strong>
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
                    <th>Active</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr> 
                </thead>
                <?php foreach($stores as $store){?>
                <tr>
                    <th><?=$store['id']?></th>
                    <th><?=$store['name']?></th>
                    <th><?=$store['position']?></th>
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
                { data: "active" },
                { data: "edit" },
                { data: "delete" }
            ]
        });
    });
  </script>`