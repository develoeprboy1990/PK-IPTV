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
                                    <h3 class="box-title"><?php echo lang('users_edit_user'); ?></h3>
                                </div>
                                <div class="box-body">
                                   
                                    
                                    <?php echo form_open(uri_string(), array('class' => 'form-horizontal', 'id' => 'form-edit_user')); ?>
                                        <div class="form-group">
                                            <?php echo lang('users_firstname', 'first_name', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($first_name);?>
                                                <span class="text-danger"><?= form_error('first_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_lastname', 'last_name', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($last_name);?>
                                                <span class="text-danger"><?= form_error('last_name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_company', 'company', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($company);?>
                                                <span class="text-danger"><?= form_error('company'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_email', 'email', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($email);?>
                                                <span class="text-danger"><?= form_error('email'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_phone', 'phone', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($phone);?>
                                                <span class="text-danger"><?= form_error('phone'); ?></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?php echo lang('users_password', 'password', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($password);?>
<!--                                                <div class="progress" style="margin:0">
                                                    <div class="pwstrength_viewport_progress"></div>
                                                </div>-->
                                                <span class="text-danger"><?= form_error('password'); ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_password_confirm', 'password_confirm', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-4">
                                                <?php echo form_input($password_confirm);?>
                                                <span class="text-danger"><?= form_error('password_confirm'); ?></span>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">User Role</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="user_role" required="">
                                                    <option value="">Select user role</option>
                                                    <?php foreach ($groups as $group):?>
                                                        <?php if($group['type']!=1){?>
                                                            <option value="<?php echo $group['id'];?>" <?php if($user->role == $group['id']) echo 'selected="selected"'; ?>><?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                        <?php }?>
                                                    <?php endforeach?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-4"> 
                                                <?php echo form_hidden('id', $user->id);?>
                                                <?php echo form_hidden($csrf); ?>
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php //echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                                    <?php echo anchor('admin/users', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
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
