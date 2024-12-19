<div class="box box-primary">
    <div class="box-header"><h4>Resellers Renewal Keys</h4></div>
    <!--<div class="box-header">
      <span class="pull-right"><span class="export-icon">Export to: </span>
        <a href="<?=site_url('keys/subscriptionExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
        <a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
      </span> 
    </div>-->
    <div class="box-body">
      <div id="ajax_search_responce" class="table-responsive">
        <table id="apps" class="table table-bordered table-striped">
          <thead>
            <tr>
			   <th>Reseller's Name</th>
              <th>Keycode</th>
              <th>Product</th>
              <th>Price</th>
			  <th>Plan Lenght</th>
              <th>Key Type</th>
			  <th>Status</th>
              <th>Used</th>
              <th>Action</th>
            </tr> 
          </thead>
         
          <tbody>
            <?php foreach($subscription_renewal_keys_resellers as $key){?>
             <tr>
                <td><?php echo $key['name'];?></td>
				<td><?=$key['keycode']?></td>
                <td><?=$key['product_name']?></td>
                <td><?=$key['monthly_price']?> / <?=($key['month_day']=='days') ? "Day" : "Month"?></td>
				<td><?=$key['length_months'].' '.$key['month_day']?></td>
				<td><?=$key['key_type']?></td>
                <td><?=($key['active']==1) ? "Active" : "Inactive"?></td>
                <td><?=($key['used']==1) ? "<a href='".site_url('customers/details/'.$key['user_id'])."'>Details</a>" : "Not Used"?></td>
                <td><?php echo btn_delete(BASE_URL.'keys/deleteRenewalKey/'.$key['id'])?></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
</div>