<div class="content-wrapper">
    <section class="content-header">
        <?php echo $page_title; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                 
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div id="ajax_search_responce">
                      <?php if($responce = $this->session->flashdata('success')){ ?>
                          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                      <?php } ?>
                      <table id="analytics" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Customer ID</th>
                          <th>Client Name</th>
                          <th>Client Product</th>
                          <th>Country</th>
                          <th>Device Type</th>
                          <th>Device Model</th>
                        </tr> 
                      </thead>
                      
                      <tbody>
                        <?php foreach($analytics as $analytic){?>
                         <tr data="<?=$analytic['id']?>" style="cursor:pointer;">
                            <td><?=$analytic['date']?></td>
                            <td><?=$analytic['user_id']?></td>
                            <td><?=$analytic['client_name']?></td>
                            <td><?=$analytic['client_product']?></td>
                            <td><?=$analytic['location_country']?></td>
                            <td><?=$analytic['device_type']?></td>
                            <td><?=$analytic['device_model']?></td>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Analytics Report</h4>
            </div>
            
            <div class="modal-body">
              <strong>services.</strong>        
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div> 
</div>
