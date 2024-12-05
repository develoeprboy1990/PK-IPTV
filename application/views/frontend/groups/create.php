<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Create Role</h3>
                                </div>
                                <div class="box-body">
                                    <?php echo $message;?>

                                    <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_group')); ?>
                                       <div class="col-md-12">
                                            <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('groups_name', 'group_name', array('class' => ' control-label')); ?></label>
                                            <input type="text" name="group_name" value="" id="group_name" class="form-control" required="">
                                          </div>
                                        </div>  
                                       
                                    <div class="col-md-12">
                                            <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo lang('groups_description', 'description', array('class' => 'control-label')); ?></label>
                                            <?php echo form_input($description); ?>
                                          </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <h4>Manage Modules Permission</h4>

                                                <?php   
                                                    $this->db->where('parent_id','0');
                                                    $this->db->order_by('sort_order','asc');
                                                    $query = $this->db->get('modules');?>
                                            <table class="table table-hover table-bordered table-striped">
                								<thead>
                									<tr>
                                                        <th >Module Name</th>
                										<th style="text-align:center">View</th>
                										<th style="text-align:center">Create</th>
                										<th style="text-align:center">Edit</th>
                										<th style="text-align:center"> Delete</th>
                									</tr>
                								</thead>
								<tbody>
                                    <?php foreach ($query->result() as $row) { ?>
                                    <tr class="main-row">
										<!-- form_checkbox('permissions[users][view]','true',TRUE) -->
										<td><input type="checkbox" class="chkrow child-<?=$row->id?>" data-id="<?=$row->id?>" id="module_<?php echo $row->id;?>" name="modules[]" value="<?php echo $row->id;?>">&nbsp;<strong><?php echo $row->name;?></strong></td>
										<td style="text-align:center"><input type="checkbox" class="chkcol view" name="view_<?php echo $row->id;?>" value="1"></td>
										<td style="text-align:center"><input type="checkbox" class="chkcol" name="create_<?php echo $row->id;?>" value="1" ></td>
										<td style="text-align:center"><input type="checkbox" class="chkcol" name="edit_<?php echo $row->id;?>" value="1" ></td>
										<td style="text-align:center"><input type="checkbox" class="chkcol" name="delete_<?php echo $row->id;?>"  value="1" ></td>
									</tr>
                                    <?php 
                                        $this->db->where('parent_id',$row->id);
                                        $query = $this->db->get('modules');
                                        
                                        foreach ($query->result() as $module) { 
                                    ?>
									        <tr class="main-row child-row">
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="chkrow child-<?=$row->id?>"  id="module_<?php echo $row->id;?>" name="modules[]" value="<?php echo $module->id;?>"> &nbsp;<?php echo $module->name;?> </td>
                                                <td style="text-align:center"><input type="checkbox" class="chkcol view child-<?=$row->id?>"   name="view_<?php echo $module->id;?>" value="1"></td>
                                                <td style="text-align:center"><input type="checkbox" class="chkcol child-<?=$row->id?>" name="create_<?php echo $module->id;?>" value="1" ></td>
                                                <td style="text-align:center"><input type="checkbox" class="chkcol child-<?=$row->id?>" name="edit_<?php echo $module->id;?>" value="1" ></td>
                                                <td style="text-align:center"><input type="checkbox" class="chkcol child-<?=$row->id?>" name="delete_<?php echo $module->id;?>"  value="1" ></td>
                                            </tr>
                                                <?php }?>
                                    <?php   } ?>
								</tbody>
							</table>
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <div class="col-sm-12" style="text-align:center">
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php echo anchor('admin/groups', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>
