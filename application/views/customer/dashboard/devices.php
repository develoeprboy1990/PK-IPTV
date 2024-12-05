<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                  <div class="box-header">
                    Devices Attached to your Account
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="ajax_search_responce">
                      <table id="devices" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Model Name</th>
                          <th>Model Type</th>
                        </tr> 
                      </thead>
                      
                      <tbody>
                        <?php foreach($devices as $device){?>
                          <tr>
                            <td><?=$device->model_name?></td>
                            <td><?=$device->model_type?></td>
                          </tr>
                        <?php }?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
             </div>
        </div>
    </section>
</div>
