<div class="box box-primary">
    <div class="box-header"><h4>Renewal Keys</h4></div>
    <div class="box-header">
      <span class="pull-right"><span class="export-icon">Export to: </span>
        <a href="<?=site_url('keys/subscriptionExportExcel')?>"><i class="fa fa-file-excel-o export-icon excel"></i></a>
        <a href="#"><i class="fa fa-file-pdf-o export-icon pdf"></i></a>
      </span> 
    </div>
    <div class="box-body">
      <div id="ajax_search_responce">
        <table id="apps" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Product</th>
              <th>Price</th>
              <th>Status</th>
			  <!-- <th>Product Group</th>-->
              <!--<th>Device allow</th>-->
			  <th>Subscription Time</th>
			  <?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
              <th>Action</th>
			  <?php } ?>
            </tr> 
          </thead>
          
          <tbody>
            <?php 
			//print_r(PRODUCTGROUP);
			foreach($customerpanel_m as $key){
			?>
             <tr>
                <td><?php echo $key['name']; ?></td>
                <td><?php echo $key['product_name']; ?></td>
                <td><?php echo $key['monthly_price']; ?></td>
                <td><?php echo ($key['active']==1) ? "Active" : "Inactive"; ?></td>
                <!--<td><?php //echo PRODUCTGROUP[$key['product_group']]; ?></td>-->
				<!--<td><?php //echo $gui_setting_array['id_'.$key['gui_setting_id']]; ?></td>-->
				<td><?php echo $key['length_months'].' '.$key['month_day']; ?></td>
				
				<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 
                <td>
					<?php if($is_allow->allow_delete) {?> 
						<?php echo btn_delete(BASE_URL.'customerpanel/deleteplan/'.$key['id'])?> &nbsp; 
					<?php } 
						if($is_allow->allow_edit) {
					?> 
						<a href="<?php echo BASE_URL; ?>customerpanel/editplan/<?php echo $key['id'];?>"><i class="glyphicon glyphicon-edit text-primary"></i></a>
					<?php } ?>
				</td>
				<?php } ?>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
</div>