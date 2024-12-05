<div class="card mb-5 mb-xl-8" id="kt_timeline_widget_2_card">
    <!--begin::Header-->
    <?php if($this->session->flashdata('message_set')){ ?>
        <!--<div class="fv-row mb-8">-->
        <div class="col-lg-8 fv-row">
        <?php if($this->session->flashdata('error')){ ?>
            <div class="alert alert-danger" role="alert" style="text-align:left;">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success" role="alert" style="text-align:left;">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
        </div>
    <?php } ?>
    <div class="card-header position-relative py-0 border-bottom-2">
       <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3">Profile</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Tap pane-->
        <div class="card mb-5 mb-xl-10">
    <div class="card-header border-0">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
    </div>
    <div class="card-body border-top p-9">
        <!-- Full Name -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Full Name</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $fname . ' ' . $lname; ?></span>
            </div>
        </div>

        <!-- Email -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Email</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $email; ?></span>
            </div>
        </div>

        <!-- Mobile -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Mobile</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $c_code . ' ' . $mobile; ?></span>
            </div>
        </div>

        <!-- Country -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Country</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $billing_country; ?></span>
            </div>
        </div>

        <!-- State -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">State</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $billing_state; ?></span>
            </div>
        </div>

        <!-- City -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">City</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $billing_city; ?></span>
            </div>
        </div>

        <!-- Street -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Street</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $billing_street; ?></span>
            </div>
        </div>

        <!-- Zip -->
        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Zip</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6"><?php echo $billing_zip; ?></span>
            </div>
        </div>
    </div>
</div>
        <div class="card mb-5 mb-xl-10"></div>
        <!--end::Tap pane-->
    </div>
    <!--end::Body-->
</div>