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
         <?php $val = $planinfo[0];?>
        <!--begin::Tap pane-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Welcome <?=$info['name']?></h3>
                </div>
                <!--end::Card title-->
            </div>

            <div class="card-body p-9">
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">  Name</label> 
                            <div class="col-lg-8">
                            <?=$info['name']?>                       
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Email</label> 
                            <div class="col-lg-8">
                            <?=$info['email']?>                       
                            </div>
                            <!--end::Col--></div>
                        <!--end::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Phone No:</label> 
                            <div class="col-lg-8">
                            <?=$info['mobile']?> </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Wallet Money   </label> 
                            <div class="col-lg-8">
                            <?=$info['wallet_money']?>  <?=$info['currency_type']?> </div> 
                            <!--end::Col--> </div>
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Plan Type</label> 
                            <div class="col-lg-8">
                            <?=($info['plan_type']==1)?'Master':'Activation/Renewal'?> Plans </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--end::Input group-->                        
                    </div>

        </div>
        <!--end::Tap pane-->
    </div>
    <!--end::Body-->
</div>