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
       <!--begin::Nav-->
       <span class="nav-text fw-semibold fs-4 mt-4">Active Plan</span>
       
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Table container-->
        <div class="row">
            <div class="col-lg-3" style="margin-top: 10px; ">
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
            <!--begin::Input-->
            <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
            <!--end::Input-->
            <!--begin::Label-->
            <span class="d-flex">
            <!--begin::Icon-->
            <i class="ki-duotone ki-verify fs-1 text-primary">
            <span class="path1"></span>
            <span class="path2"></span>
            </i>
            <!--end::Icon-->
            <!--begin::Info-->
            <span class="ms-4">
            <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">  Active Product</span>
            <span class="fw-semibold fs-4 text-muted"><?=$productName?> </span> 
            </span>
            <!--end::Info-->
            </span>
            <!--end::Label-->
            </label> 
        </div>

            <div class="col-lg-3" style="margin-top: 10px; ">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                <!--begin::Input-->
                <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                <!--end::Input-->
                <!--begin::Label-->
                <span class="d-flex">
                <!--begin::Icon-->
                <i class="ki-duotone ki-verify fs-1 text-primary">
                <span class="path1"></span>
                <span class="path2"></span>
                </i>
                <!--end::Icon-->
                <!--begin::Info-->
                <span class="ms-4">
                <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">  Active Plan</span>
                <span class="fw-semibold fs-4 text-muted"><?=$ActivePlanName?> </span> 
                </span>
                <!--end::Info-->
                </span>
                <!--end::Label-->
                </label> 
            </div>
        


            <div class="col-lg-3" style="margin-top: 10px; ">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                <!--begin::Input-->
                <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                <!--end::Input-->
                <!--begin::Label-->
                <span class="d-flex">
                <!--begin::Icon-->
                <i class="fa fa-calendar  fa-5x" aria-hidden="true"> 

                </i>
                <!--end::Icon-->
                <!--begin::Info-->
                <span class="ms-4">
                <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Plan Activate</span>
                <span class="fw-semibold fs-4 text-muted"> <?php echo date("j F, Y, g:i a", strtotime($vcodelife));?>

                </span>
                </span>
                <!--end::Info-->
                </span>
                <!--end::Label-->
                </label> 
            </div>

            <div class="col-lg-3" style="margin-top: 10px; ">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 mb-6 active">
                <!--begin::Input-->
                <input class="btn-check" type="radio" checked="checked" name="offer_type" value="1">
                <!--end::Input-->
                <!--begin::Label-->
                <span class="d-flex">
                <!--begin::Icon-->
                <i class="fa fa-calendar  fa-5x" aria-hidden="true"> 

                </i>
                <!--end::Icon-->
                <!--begin::Info-->
                <span class="ms-4">
                <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Plan Expire</span>
                <span class="fw-semibold fs-4 text-muted"> <?php echo date("j F, Y, g:i a", strtotime($expire));?>

                </span>
                </span>
                <!--end::Info-->
                </span>
                <!--end::Label-->
                </label> 
            </div>
        </div>
        <div class="table-responsive">
            <!--begin::Table-->
            <h2>Recharge History</h2>
            <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                            <th class="ps-0 w-50px">S.No</th> 
                            <th class=" min-w-100px">Activation Key</th>
                            <th class=" min-w-100px">Product Name</th>
                            <th class=" min-w-100px">Plan Name</th>
                            <th class="min-w-100px">Plan Duration</th> 
                            <th class="min-w-100px">Recharge</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                    <?php
                    $i=1;
                  foreach($info as $info){?>
                   
                        <tr>                                     
                            <td class="ps-0">
                                 <?=$i?>
                            </td>
                            <td>                                         
                                    <?php if($info['sebscription_trpe']=='Active'){?>
                                        <a   style="color:#009ef7;" class="btn btn-light-success btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"   data-bs-original-title="Actvation Key" title="Actvation Key" data-kt-initialized="1"><?=$info['activation_code'];?></a>

                                    <?php } else{ ?>  <a   style="color:#009ef7;" class="btn btn-light btn-sm card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"   data-bs-original-title="Recharge Key" title="Recharge Key" data-kt-initialized="1"><?=$info['activation_code'];?></a> <?php  }?>  
                            </td>

                            <td>
                                <span class="text-gray-800 fw-bold d-block fs-6 ps-0"> <?=$info['productName']?></span>
                            </td>
                            <td>
                                <span class="text-gray-800 fw-bold d-block fs-6 ps-0"> <?=$info['group_name']?></span>
                            </td>
                            <td>
                                  <?=$info['subscription_renewal_keys']?>  <?=$info['subscription_days_or_month']?> 
                                  
                            </td>
                             
                            <td class="  pe-0">
                                 
                                 <?php echo date("j F, Y, g:i a", strtotime($info['created_at']));?> 
                            </td>
                            

                        </tr>
                         <?php   $i++;
                           }

                          ?>
                    </tbody>
                    <!--end::Table body-->
                </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>