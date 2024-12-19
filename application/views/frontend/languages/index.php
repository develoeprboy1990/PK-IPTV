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
            <!-- /.box-header -->
            <div class="box-body">
              <div id="ajax_search_responce" class="table-responsive">
                <table id="languages" class="table table-bordered table-striped">
                <thead>
                  <tr >
                    <th>#</th>
                    <th>Name</th> 
                    <th></th>                    
                  </tr> 
                </thead>

                <tbody>
                  <?php foreach($languages as $language){?> 
                  <tr id="row-<?=$language['id']?>">
                    <td id="column-id-<?=$language['id']?>"><?=$language['id']?></td>
                    <td id="column-name-<?=$language['id']?>"><?=$language['name']?></td>
                    <td id="btn-<?=$language['id']?>"><a href="javascript:void(0);" onclick="editItem(<?=$language['id']?>)"><i class="fa fa-edit"></i></a> <a href="javascript:void(0);" onclick="deleteItem('<?=$language['id']?>')"><i class="fa fa-trash"></i></a></td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-header with-border">
                <h3 class="box-title"><a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat" onclick="addItem('1')"><i class="fa fa-plus"></i> Add a Language</a></h3>
            </div>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->