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
                        <h3 class="box-title">Edit Role</h3>
                    </div>
                    <div class="box-body">
                        <?php echo $message;?>
                        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-edit_group')); ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('groups_name', 'group_name', array('class' => ' control-label')); ?></label>
                                <?php echo form_input($group_name);?>
                              </div>
                            </div>  

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo lang('groups_description', 'description', array('class' => 'control-label')); ?></label>
                                    <?php echo form_input($group_description); ?>
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
                                            <?php foreach ($query->result() as $row) { 
                                              $query_role = $this->db->get_where('group_role_permissions', array('group_id' =>  $group->id,'role_id' => $row->id));
                                              $data_row = $query_role->row();
                                              ?>
                                            <tr class="main-row">
				                               <!-- form_checkbox('permissions[users][view]','true',TRUE) -->
                                                <td><input type="checkbox" class="chkrow" data-id="<?=$row->id?>" <?php if(isset($data_row->role_id)  && $data_row->role_id == $row->id) { echo 'checked'; } ?> id="module_<?php echo $row->id;?>" name="modules[]" value="<?php echo $row->id;?>"> &nbsp;<strong><?php echo $row->name;?></strong> </td>
                                                <td style="text-align:center"><input type="checkbox" class="chkcol view" <?php if(isset($data_row->allow_view)  && $data_row->allow_view == 1) { echo 'checked=""'; }  ?>    name="view_<?php echo $row->id;?>" value="1"></td>
        										<td style="text-align:center"><input type="checkbox" class="chkcol" <?php if(isset($data_row->allow_create)  && $data_row->allow_create == 1) { echo 'checked=""'; } ?> name="create_<?php echo $row->id;?>" value="1" ></td>
        										<td style="text-align:center"><input type="checkbox" class="chkcol" <?php if(isset($data_row->allow_edit)  && $data_row->allow_edit == 1) { echo 'checked=""'; } ?> name="edit_<?php echo $row->id;?>" value="1" ></td>
        										<td style="text-align:center"><input type="checkbox" class="chkcol" <?php if(isset($data_row->allow_delete)  && $data_row->allow_delete == 1) { echo 'checked=""'; } ?> name="delete_<?php echo $row->id;?>"  value="1" ></td>
        									</tr>

                                            <?php 
                                                $this->db->where('parent_id',$row->id);
                                                $query = $this->db->get('modules');
                                                
                                                foreach ($query->result() as $module) { 
                                                    $module_role = $this->db->get_where('group_role_permissions', array('group_id' =>  $group->id,'role_id' => $module->id));
                                                    $module_row = $module_role->row();
                                            ?>
                                                    <tr class="main-row">
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="chkrow child-<?=$row->id?>" <?php if(isset($module_row->role_id)  && $module_row->role_id == $module->id) { echo 'checked'; } ?> id="module_<?php echo $row->id;?>" name="modules[]" value="<?php echo $module->id;?>"> &nbsp;<?php echo $module->name;?> </td>
                                                        <td style="text-align:center"><input type="checkbox" class="chkcol view child-<?=$row->id?>" <?php if(isset($module_row->allow_view)  && $module_row->allow_view == 1) { echo 'checked=""'; }  ?>    name="view_<?php echo $module->id;?>" value="1"></td>
                                                        <td style="text-align:center"><input type="checkbox" class="chkcol child-<?=$row->id?>" <?php if(isset($module_row->allow_create)  && $module_row->allow_create == 1) { echo 'checked=""'; } ?> name="create_<?php echo $module->id;?>" value="1" ></td>
                                                        <td style="text-align:center"><input type="checkbox" class="chkcol child-<?=$row->id?>" <?php if(isset($module_row->allow_edit)  && $module_row->allow_edit == 1) { echo 'checked=""'; } ?> name="edit_<?php echo $module->id;?>" value="1" ></td>
                                                        <td style="text-align:center"><input type="checkbox" class="chkcol child-<?=$row->id?>" <?php if(isset($module_row->allow_delete)  && $module_row->allow_delete == 1) { echo 'checked=""'; } ?> name="delete_<?php echo $module->id;?>"  value="1" ></td>
                                                    </tr>
                                                <?php }?>

                                    <?php    } ?>
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

