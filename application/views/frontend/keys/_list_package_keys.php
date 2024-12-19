<div class="box box-primary">
    <div class="box-header"><h4>Channel Package Keys</h4></div>
    <div class="box-header">
      <span class="pull-right"><span class="export-icon">Export to: </span> 
        <a href="<?=site_url('keys/packageExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
        <a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
      </span> 
    </div>
    <div class="box-body">
      <div id="ajax_search_responce" class="table-responsive">
        <table id="package-keys" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Keycode</th>
              <th>Package</th>
              <th>Price</th>
              <th>Status</th>
              <th>Used</th>
              <th>Delete</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php foreach($package_keys as $key){?>
             <tr>
                <td><?=$key['keycode']?></td>
                <td><?=$key['package_name']?></td>
                <td><?=$key['monthly_price']?></td>
                <td><?=($key['active']==1) ? "Active" : "Inactive"?></td>
                <td><?=($key['used']==1) ? "Used" : "Not Used"?></td>
                <td><?php echo btn_delete(BASE_URL.'keys/deletePackageKey/'.$key['id'])?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
</div>