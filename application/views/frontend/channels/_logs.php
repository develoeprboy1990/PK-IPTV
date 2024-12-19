<div class="box">
     

      <!-- /.box-header -->
      <div class="box-body">
        <div id="ajax_search_responce" class="table-responsive">
          <?php if($responce = $this->session->flashdata('success')){ ?>
              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
          <?php } ?>
          <table id="logs" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Customer ID</th>
              <th>Action</th>
              <th>IP</th>
              <th>Date</th>
              <th>Delete</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php foreach($logs as $log){?>
             <tr>
                <td><?=$log['username']?></td>
                <td><?=$log['action']?></td>
                <td><?=$log['client_ip']?></td>
                <td><?=date('Y-m-d H:i:s',$log['timestamp'])?></td>
                <td><?php echo btn_delete(BASE_URL.'logs/delete/'.$log['id'])?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
        </div>
      </div>
      <!-- /.box-body -->
</div>