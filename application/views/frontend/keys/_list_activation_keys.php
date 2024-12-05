<div class="box box-primary">
    <div class="box-header"><h4>Activation Keys </h4></div>
    <!--<div class="box-header">
      <span class="pull-right"><span class="export-icon">Export to: </span>
        <a href="<?=site_url('keys/activationExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
        <a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
      </span> 
    </div>-->
    <div class="box-body">
      <div id="ajax_search_responce">
        <table id="activation-keys" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Keycode</th>
              <th>Product</th>
			  <th>Price</th>
			  <th>Length Month</th>
			  <th>Activation price</th>
              <th>Total Price</th>			  
              <th>Status</th>
              <th>Used</th>
              <th>Delete</th>  
            </tr> 
          </thead>          
          <tbody>
            <?php foreach($activation_keys as $key){?>
             <tr>
                <td><?=$key['keycode']?></td>
                <td><?=$key['product_name']?></td>
				<td><?=$key['monthly_price'].'/'.substr($key['month_day'], 0, -1);?></td>
				<td><?=$key['length_months'].' '.$key['month_day']?></td>
				<td><?=$key['activation_price']?></td>
                <td><?php echo $key['monthly_price']* $key['length_months'] +  $key['activation_price']; ?></td>
                <td><?=($key['active']==1) ? "Active" : "Inactive"?></td>
                <td><?=($key['used']==1) ? "<a href='".site_url('customers/details/'.$key['user_id'])."'>Details</a>" : "Not Used"?></td>
                <td><?php echo btn_delete(BASE_URL.'keys/deleteActivationKey/'.$key['id'])?></td> 
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
</div>