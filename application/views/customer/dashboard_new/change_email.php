<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Change Email</h3>
        </div>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">   
        <form class="form" method="post" action="<?php echo site_url('customer/changeemail'); ?>">
            <div class="card-body border-top p-9">
                <?php if($message == 'error'): ?>
                    <div class="alert alert-danger" role="alert" style="text-align:left;">
                        <?php echo validation_errors(); ?>
                        <?php echo isset($message_content) ? $message_content : ''; ?>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('message_set')): ?>
                    <div class="alert alert-success" role="alert" style="text-align:left;">
                        <?php echo $this->session->flashdata('message_set'); ?>
                    </div>
                <?php endif; ?>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Current Email</label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="current_email" class="form-control form-control-lg form-control-solid" value="<?php echo set_value('current_email', $user_info->email); ?>" required />
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">New Email</label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="new_email" class="form-control form-control-lg form-control-solid" value="<?php echo set_value('new_email'); ?>" required />
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm New Email</label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="confirm_email" class="form-control form-control-lg form-control-solid" value="<?php echo set_value('confirm_email'); ?>" required />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <input type="submit" name="save_change" value="Save Changes" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>