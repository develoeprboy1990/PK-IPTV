<div class="box box-primary">
    <div class="box-header"><h4>Master Keys</h4></div>
    <div class="box-header">
      
    </div>
    <div class="box-body">
      <div id="ajax_search_responce" class="table-responsive">
        <table id="apps" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Keycode</th>
              <th>Product</th>
              <th>Price</th>
			  <th>Plan Lenght</th>
              <th>Activation Price</th>
			  <th>Total Price</th>
			  <th>Status</th>
              <th>Used</th>
              <th>Action</th>
            </tr> 
          </thead>
          
          <tbody>
            <?php foreach($master_keys as $key){?>
             <tr>
                <td><?=$key['keycode']?></td>
                <td><?=$key['product_name']?></td>
                <td><?=$key['monthly_price']?> / <?=($key['month_day']=='days') ? "Day" : "Month"?></td>
				<td><?=$key['length_months'].' '.$key['month_day']?></td>
				<td><?php echo $key['activation_price']; ?></td>
                <td><?php echo ($key['monthly_price']*$key['length_months']) + $key['activation_price']; ?></td>
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