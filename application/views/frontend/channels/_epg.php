<div class="box">
  <!-- /.box-header -->
  <div class="box-body">
    <div id="ajax_search_responce">
      <?php if($responce = $this->session->flashdata('success')){ ?>
          <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
      <?php } ?>
      <table id="epgs" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Start</th>
            <th>End</th>
            <th>Delete</th>
          </tr> 
        </thead>
        <tbody>
          <?php foreach($epgs as $epg){?>
             <tr>
              <td><?=$epg['id']?></td>
              <td><?=$epg['name']?></td>
              <td><?=$epg['t_start']?></td>
              <td><?=$epg['t_end']?></td>
              <td><?php echo btn_delete(BASE_URL.'channels/delete_epg/'.$epg['id'])?></td>
            </tr> 
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>