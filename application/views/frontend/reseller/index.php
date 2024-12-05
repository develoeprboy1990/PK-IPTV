<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$is_allow = $this->ion_auth->checkPermission(13);  // channel module id
//print_r($is_allow);
if(!isset($is_allow))
{
    
   redirect('unauthorize', 'refresh');
}
?>  
      <style>
        .custom-list {
            list-style-type: none; /* Removes bullet points */
            padding: 0;           /* Removes default padding */
            margin: 0;            /* Removes default margin */
        }

        .custom-list li {
            float: left;          /* Floats the list items to the left */
            margin-right: 10px;   /* Adds some space between the items */
        }
      </style>
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
                              <div class="col-sm-9"> <h3 class="box-title">Search Result With Filters</h3> </div>
                                <div class="col-sm-3">
                              <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?=base_url().'dashboard'?>">Home</a></li>
                                <li class="breadcrumb-item active">  Reseller </li>
                              </ol>
                                      </div>
                              </div>

                              <?php if($is_allow->allow_create) {?> 
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('reseller/create', '<i class="fa fa-plus"></i> Add a Reseller', array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                              <?php } ?>

                              <!-- /.box-header -->
                              <div class="box-body">
                                <div id="ajax_search_responce">
                                  <?php if($responce = $this->session->flashdata('success')){ ?>
                                      <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                                  <?php } ?>
                                  <table id="customers" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                    <th>S.No</th>
                                      <th>User ID</th>                                      
                                      <th>Name</th>
                                      <th>Email</th>
									  <?php if($is_allow->allow_edit) {?> 
									  <th><a  title="Super Admin can Check" style="cursor: pointer;"> Password</a></th>
									  <?php } ?>
                                      <th>mobile</th>
									  <th>  <a  title="Wallet Money" style="cursor: pointer;">Wallet Money</a></th>
									  <th>Currency</th>
                    <th><a  title="2 type Plan" data-toggle="tooltip" data-placement="top" style="cursor: pointer;">Plan Type</a></th>
                                      <th>Status</th>
									 <?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 		
                                      <th>Action</th>
									  <?php } ?>
									 
                                    </tr> 
                                  </thead>
                                  
                                  <tbody>
                                    <?php $i=1;
                                     foreach($recellers as $receller){?>
                                      <tr>
                                      <td><?=$i?></td>
                                        <td><?=$receller['id']?></td>
                                        <td><?=$receller['name']?></td>                                       
                                        <td><?=$receller['email']?></td>
										<?php if($is_allow->allow_edit) {?> 
										<td><?=base64_decode($receller['password'])?></td>
										<?php } ?>
                                        <td><?=$receller['mobile']?></td>
										<td><?=$receller['wallet_money']?></td>
										<td><?=$receller['currency_type']?></td>
                    <td><?php if($receller['plan_type']==2){ echo 'Activation/Renewal'; }
                      if($receller['plan_type']==1){ echo 'Digital PLan'; }?>
                    </td>
                                        <td><?=($receller['status']==1) ? "Active" : "Disabled" ?></td>
										<?php if($is_allow->allow_edit || $is_allow->allow_delete) {?> 										
                                        <td>
                                       
                         <ul class="custom-list">
        <li><button title="Edit"><?php echo btn_edit(BASE_URL.'reseller/details/'.$receller['id']);?></button></li>
       <!-- <li><?php echo btn_delete(BASE_URL.'reseller/resellerdelete/'.$receller['id'])?></li> -->
        <li>	<a href="<?php echo BASE_URL; ?>reseller/resellersdetails/<?php echo $receller['id'];?>" style="margin-left:5px;" title="View Plan" > <button >Plans</button></a></li>
        <li><form  target="_blank" novalidate="novalidate" id="kt_sign_in_form" action="<?php echo BASE_URL;?>resellers/login" method="post" class="login-form">
                         <input type="hidden"  name="identity"  value="<?=$receller['email']?>"  >
                         <input type="hidden"   name="password"   value="<?=base64_decode($receller['password'])?>"   >
                         <button type="submit"  name="sign_in_submit"   title="Reseller Login"><i class="fa fa-sign-in" title="reseller login"></i></button>
                         </form></li>
    </ul>
                      </td>
										<?php $i++; } ?>
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
