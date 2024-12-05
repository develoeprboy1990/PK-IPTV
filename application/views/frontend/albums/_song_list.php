<div class="box">
  <div class="box-header with-border">
      <h3 class="box-title">Songs</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div id="ajax_search_responce">
     
      <table id="songs" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Url</th>
          <th>Position</th>
          <th></th>
        </tr> 
      </thead>
      <tbody>
       <?php foreach($songs as $song){?> 
       <tr>
         <td><?=$song['id']?></td>
         <td><?=$song['name']?></td>
         <td><?=$song['url']?></td>
         <td><?=$song['position']?></td>
         <td><?php echo btn_edit(BASE_URL.'albums/editSong/'.$details->id.'/'.$song['id'].'/2');?> <?php echo btn_delete(BASE_URL.'albums/deleteSong/'.$details->id.'/'.$song['id'])?></td>
       </tr>
       <?php }?>
      </tbody>
    </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
                        