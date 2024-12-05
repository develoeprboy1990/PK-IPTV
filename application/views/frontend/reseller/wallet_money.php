<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(13);  // channel module id
//print_r($is_allow);
if(!isset($is_allow))
{
   redirect('unauthorize', 'refresh');
}
?>  
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
						<h3 class="box-title">Search Result With Filters</h3>
					</div>
	                <?php if($is_allow->allow_create) {?> 
	                	<div class="box-header with-border">
	                        <h3 class="box-title"><?php echo anchor('reseller/addwallet', '<i class="fa fa-plus"></i> Add Money', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
	                    </div>
	                <?php } ?>
					<div id="myPopup" class="popup">
						<div class="popup-content">
							<h2 style="color:green; margin-top:0;">Payment Status Change</h2>
							<p>Write Message here:</p>
							<span><input type="hidden" id="wallet_id" value="" /></span>
							<div><input type="checkbox" name="payment_status" id="payment_status" value="paid" /> Payment Full</div>
							<div><textarea id="user_message" style="width:100%;min-height: 100px;"></textarea></div>
							<div style="width:40%; min-width:90px; float:left;">
							<button class="btn btn-block btn-primary btn-flat" onclick="changepaymentstatus()">Change Payment</button>
							</div>
							<div style="width:30%; min-width:50px; float:right;">
							<button id="closePopup" class="btn btn-block btn-primary btn-flat">Close</button>
							</div>
						</div>
					</div>
					<div id="messag_popup" class="popup">
							<div class="popup-content">
								<h2 style="color:green; margin-top:0;">Write Message</h2>
								<p>Write Message here:</p>
								<span><input type="hidden" id="wallet_editid" value="" /></span>
								<div><textarea id="user_editmessage" style="width:100%;min-height: 100px;"></textarea></div>
								<div style="width:40%; margin-top:10px; min-width:90px; float:left;">
								<button class="btn btn-block btn-primary btn-flat" onclick="update_message()">Write Message</button>
								</div>
								<div style="width:30%; min-width:50px; margin-top:10px; float:right;">
								<button id="closePopupMessage" class="btn btn-block btn-primary btn-flat">Close</button>
								</div>
							</div>
						</div>				
					<div id="messagHistory" class="popup" >
							<div class="popup-content" style="width:50%;">
								<span id="closePopupMessageHistory" style="float: right;color: red;font-size: 25px;font-weight: bold;cursor: pointer;margin-top: -25px;
	margin-right: -15px;">X</span>	
								<h2 style="color:green; margin-top:0;">Message History</h2>
								<div id="msg_list"></div>																		
							</div>
							
						</div>
	          		<!-- /.box-header -->
	              	<div class="box-body">
	                <div id="ajax_search_responce">
	                  <?php if($responce = $this->session->flashdata('success')){ ?>
	                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
	                  <?php } ?>
					  <div id="payment_status_msg" style="text-align: center;font-size: 15px;font-weight: bold;"></div>
	                  <table id="reseller_walletmoney" class="table table-bordered table-striped">
	                  <thead>
	                    <tr>
	                      <th>SL.No</th>                                      
	                      <th><a title="Reseller Name" style="cursor: pointer;">Reseller Name</a></th>
	                      <th><a title="Amount" style="cursor: pointer;">Amount Paid</a></th>	
						  <th>Created</th>
						  <th><a title="Message" style="cursor: pointer;">Message</a></th>									  
	                      <th>Message History</th>
						  <th><a title="Payment" style="cursor: pointer;">Payment Status</a></th>
						  <th></th>
	                    </tr> 
	                  </thead>
	                  
	                  <tbody>
	                    <?php 
						$sl_count = 1;
	                    
						foreach($payment_rows as $val){
						?>
	                      <tr>
						  	<td><?php echo $sl_count;?></td>
	                       	<td><?php echo $val['reseller_name'];?></td>
	                        <td><?php echo $val['price'].' '.$val['currency']; ?></td>                                       
	                        <td><?php echo date("F j, Y, g:i a", strtotime($val['create_time']));?></td>
							<!--<td id="msgset_<?php //echo $val['id'];?>">-->
							<td>
								<?php //echo $val['message'];?>
								<a href="#" onclick="write_message('<?php echo $val['id'];?>'); return false;" class="btn btn-block btn-primary btn-flat">Write Message</a>
							</td>
							<!--<td id="msgset_<?php //echo $val['id'];?>">-->
							<td>
								<?php //echo $val['message'];?>
								<a href="#" onclick="message_history('<?php echo $val['id'];?>'); return false;" class="btn btn-block btn-primary btn-flat">Message History</a>
							</td>
	                        <!--<td id="payment_status<?php echo $val['id'];?>"><?=($val['payment_status']=='paid') ? "Paid" : "Not Paid" ?></td>-->
							
							<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 										
	                        <td>
								<!--<select id="payment_status_<?php echo $val['id'];?>" name="payment_status_<?php echo $val['id'];?>" class="form-control" style="max-width:100px;" onchange="change_payment_status('<?php echo $val['id'];?>');"> 
									<option value="paid" <?php if($val['payment_status']=='paid'){ echo 'selected="selected"';} ?> >Paid</option> 
									<option value="notpaid" <?php if($val['payment_status']=='notpaid'){ echo 'selected="selected"';} ?>>Not Paid</option>
								</select>-->	
								<?php
									if($val['payment_status']=='paid'){
										echo 'Paid';
									} else{
										//echo 'Non Paid';
								?>
										<a href="#" onclick="change_payment_status('<?php echo $val['id'];?>'); return false;">Make Payment</a>
								<?php
									}
								?>	
																	
							</td>
							<td>
							<?php echo btn_delete(BASE_URL.'reseller/walletdelete/'.$val['id'])?>
							</td>
							<?php } ?>
	                      </tr>
	                    <?php 
							$sl_count++;
						}
						
						?>
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
<style>
        .popup {
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            display: none;
        }
        .popup-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888888;
            width: 30%;
            font-weight: bolder;
			border: 10px solid #ccc;
    		border-radius: 10px;
			padding-bottom: 50px;
        }
        .popup-content button {
            display: block;
            margin: 0 auto;
        }
        .show {
            display: block;
        }
        h1 {
            color: green;
        }
    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function(){
    $('#closePopupMessage').click(function(){

        alert("hello");
      $("#messag_popup").hide();
    });
  /*  
    myButton.addEventListener("click", function () {
        myPopup.classList.add("show");
    });
    closePopup.addEventListener("click", function () {
        myPopup.classList.remove("show");
    });
    window.addEventListener("click", function (event) {
        if (event.target == myPopup) {
            myPopup.classList.remove("show");
        }
    });
	*/
</script>	