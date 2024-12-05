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
              <div id="ajax_search_responce">
                <table id="tags" class="table table-bordered table-striped">
                <thead>
                  <tr >
                    <th>#</th>
                    <th>Name</th> 
                    <th></th>                    
                  </tr> 
                </thead>

                <tbody>
                  <?php foreach($tags as $tag){?> 
                  <tr id="row-<?=$tag['id']?>">
                    <td id="column-id-<?=$tag['id']?>"><a href="javascript:void(0);" onclick="editItem(<?=$tag['id']?>)"><?=$tag['id']?></a></td>
                    <td id="column-name-<?=$tag['id']?>"><?=$tag['name']?></td>
                    <td id="btn-<?=$tag['id']?>">
                      <a href="javascript:void(0);" onclick="editItem(<?=$tag['id']?>)"><i class="fa fa-edit"></i></a> 
                      <a href="javascript:void(0);" onclick="deleteItem('<?=$tag['id']?>')"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-header with-border">
                <h3 class="box-title"><a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat" onclick="addItem('1')"><i class="fa fa-plus"></i> Add a Tag</a></h3>
            </div>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->