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
      
          <div class="box">

            <div class="box-header">
              <h3 class="box-title">Search Result With Filters</h3>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title"><?php echo anchor('publish_vod_classic_ims/updateAll', '<i class="fa fa-plus"></i> Publish All Items', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <div id="ajax_search_responce">
                <?php if($responce = $this->session->flashdata('success')){ ?>
                    <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                <?php } ?>
                <table id="publishes" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Update Yes/No</th>
                    <th>Last Publish Date</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                  </tr>  
                </thead>
                <tbody>
                  <?php foreach($modules as $module){?>
                    <tr>
                      <td><?=$module['module_name']?></td>
                      <td><?=ucfirst($module['should_update'])?></td>
                      <td><?=$module['last_update']?></td>
                      <td>
                        <a href="<?=site_url('publish_vod_classic_ims/create/'. $module['id'])?>" style="text-decoration: underline;">Publish To Cloud</a>
                      </td>
                      <td>
                        <a href="#" style="text-decoration: underline;">Edit</a>
                      </td>
                    </tr>
                  <?php }?>
                 
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->