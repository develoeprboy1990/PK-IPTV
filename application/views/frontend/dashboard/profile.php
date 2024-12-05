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
						<div class="col-md-6">
							 <div class="box">
								<div class="box-header with-border">
									<h3 class="box-title">Profile Details</h3>
								</div>
								  <?php if($responce = $this->session->flashdata('success')){ ?>
	                                  <div class="alert alert-warning" role="alert" style="text-align:center"><?php echo $responce;?></div>
	                              <?php } ?>
								<div class="box-body">
									<table class="table table-striped table-hover">
										<tbody>
<?php foreach ($user_info as $user):?>
											
											<tr>
												<th><?php echo lang('users_firstname'); ?></th>
												<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_lastname'); ?></th>
												<td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_username'); ?></th>
												<td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_email'); ?></th>
												<td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_created_on'); ?></th>
												<td><?php echo date('d-m-Y', $user->created_on); ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_last_login'); ?></th>
												<td><?php echo ( ! empty($user->last_login)) ? date('d-m-Y', $user->last_login) : NULL; ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_status'); ?></th>
												<td><?php echo ($user->active) ? '<span class="label label-success">'.lang('users_active').'</span>' : '<span class="label label-default">'.lang('users_inactive').'</span>'; ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_company'); ?></th>
												<td><?php echo htmlspecialchars($user->company, ENT_QUOTES, 'UTF-8'); ?></td>
											</tr>
											<tr>
												<th><?php echo lang('users_phone'); ?></th>
												<td><?php echo $user->phone; ?></td>
											</tr>
											<tr>
												<th>Role</th>
												<td>

													<?php // Disabled temporary !!! ?>
													<?php //echo '<span class="label" style="background:'.$group->bgcolor.'">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>'; ?>
													<?php echo '<span class="label label-default">'.htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8').'</span>'; ?>

												</td>
											</tr>
											<?php endforeach;?>							
											<tr>
												<th colspan="2"><a href="<?=base_url()?>profile-edit/" type="button" class="btn btn-primary">Update Profile</a></th>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						 </div>

						
					</div>
				</section>
			</div>
