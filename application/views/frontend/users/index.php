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
                            <?php if($responce = $this->session->flashdata('message')){ ?>
                              <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
                            <?php } ?>
							 <div class="box">
                                                             <?php if($is_allow->allow_create) {?> 
								<div class="box-header with-border">
									<h3 class="box-title"><?php echo anchor('users/create', '<i class="fa fa-plus"></i> '. lang('users_create_user'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
								</div>
                                                             <?php } ?>
								<div class="box-body table-responsive">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th><?php echo lang('users_firstname');?></th>
												<th><?php echo lang('users_lastname');?></th>
												<th><?php echo lang('users_email');?></th>
												<th>Role</th>
												<th><?php echo lang('users_status');?></th>
												<th><?php echo lang('users_action');?></th>
											</tr>
										</thead>
										<tbody>
				<?php foreach ($users as $user):?>
					<?php $role = $this->db->get_where('groups', array('id' => $user->role))->row(); ?>
					
					<?php if($role->type!=1){ ?>
					<tr>
						<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
						<td><?php echo anchor('groups/edit/'.$role->id, '<span class="label label-default">'.htmlspecialchars($role->name, ENT_QUOTES, 'UTF-8').'</span>');?></td>
						<td><?php echo ($user->active) ? anchor('users/deactivate/'.$user->id, '<span class="label label-success">'.lang('users_active').'</span>') : anchor('users/activate/'. $user->id, '<span class="label label-default">'.lang('users_inactive').'</span>'); ?></td>
						<td>
			            <?php if($is_allow->allow_edit) {?>   <a href="users/edit/<?php echo $user->id;?>"><i class="glyphicon glyphicon-edit text-primary"></i></a> <?php } ?>
			            <?php if($is_allow->allow_view) {?>     &nbsp;&nbsp;&nbsp;<a href="users/profile/<?php echo $user->id;?>"><i class="glyphicon glyphicon-eye-open text-success"></i></a> <?php } ?>
			            <?php if($is_allow->allow_delete) {?>   &nbsp;&nbsp;&nbsp;<a href="users/delete/<?php echo $user->id;?>" onclick="return confirm('Are you sure you want to delete this user?');"><i class="glyphicon glyphicon-trash text-danger"></i></a> <?php } ?>
						</td>
					</tr>
					<?php }?>
				<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			 </div>
		</div>
	</section>
</div>
