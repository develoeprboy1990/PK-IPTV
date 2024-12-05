 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= BASE_URL ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title ?></li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
          <div class="row">
              <!-- general form elements -->
            <div class="box box-primary">
              <form method="post" action="<?= BASE_URL ?>user/edit/<?= $user_details->id; ?>">
                <div class="box-body">

                  <div class="row"> 
                    <div class="form-group col-md-2"></div>
                    <div class="form-group col-md-6">
                      <label>Select Employee</label>
                      <select id="user_employee_id" name="user_employee_id" class="form-control">
                        <option value=""> -- Select Position -- </option>
                        <?php foreach($all_employees as $emp): ?>
                          <?php if($user_details->user_employee_id == $emp['id']): ?>
                            <option value="<?= $user_details->id; ?>" selected><?= ucwords($user_details->user_employee_id_emp_name); ?></option>
                          <?php else: ?> 
                            <option value="<?= $user_details->id; ?>"><?= ucwords($emp['emp_name']); ?></option>
                          <?php endif;?>
                        <?php endforeach ?>
                      </select>
                      <span class="text-danger"><?= form_error('user_employee_id'); ?></span>
                    </div>
                  </div>

                  <div class="row"> 
                    <div class="form-group col-md-2"></div>
                    <div class="form-group col-md-6">
                      <label>Select Group</label>
                      <select id="user_group_id" name="user_group_id" class="form-control">
                        <option value=""> -- Select Position -- </option>
                        <?php foreach($all_groups as $grp): ?>
                          <?php if($user_details->user_group_id == $grp['id']): ?>
                            <option value="<?= $user_details->id; ?>" selected><?= ucwords($user_details->user_group_id_group_name); ?></option>
                          <?php else: ?> 
                            <option value="<?= $user_details->id; ?>"><?= ucwords($emp['group_name']); ?></option>
                          <?php endif;?>
                        <?php endforeach ?>
                      </select>
                      <span class="text-danger"><?= form_error('user_group_id'); ?></span>
                    </div>
                  </div>

                  <div class="row"> 
                    <div class="form-group col-md-2"></div>
                    <div class="form-group col-md-6">
                      <label for="user_name">Username </label>
                      <input type="text" id="user_name" value="<?= ucwords($user_details->user_name); ?>" name="user_name" class="form-control"  />
                      <span class="text-danger"><?= form_error('user_name'); ?></span>
                    </div>
                  </div>

                  <div class="row"> 
                    <div class="form-group col-md-2"></div>
                    <div class="form-group col-md-6">
                      <label for="user_password">Password </label>
                      <input type="password" id="user_password" value="<?= ucwords($user_details->user_password); ?>" name="user_password" class="form-control" />
                      <span class="text-danger"><?= form_error('user_password'); ?></span>
                    </div>
                  </div>


                  <div class="row">
                    <div class="form-group col-md-6 text-center">
                      <button type="submit" class="btn btn-success ">Add User</button>
                    </div>
                  </div>
                
                </div>                

              </form>
            </div>
            </div>
            
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->