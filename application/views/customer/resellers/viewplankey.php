<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                                            
<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

            <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            
    

<!--begin::Page title-->
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
    <!--begin::Title-->
    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
       Key Detail
            </h1>
    <!--end::Title-->

            
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                                    <a href="<?=base_url();?>resellers" class="text-muted text-hover-primary">
                                Home                            </a>
                                            </li>
                                <!--end::Item-->
                                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                                        
                            <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                    <a href="javascript:history.go(-1)" class="text-muted text-hover-primary">      Account     </a>                                       </li>
                                <!--end::Item-->
                                        
                    </ul>
        <!--end::Breadcrumb-->
    </div>
<!--end::Page title-->
 
<!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
<!--end::Toolbar-->       
<!--begin::Content-->
<div id="kt_app_content" class="app-content  flex-column-fluid ">
    
           
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container  container-xxl ">
            
<!--begin::Navbar--> 
<!--end::Navbar-->
<?php $val = $planinfo[0];?>
<!--begin::details View-->
<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
          
             
            <div  class="dropzone dz-clickable  rounded min-w-125px py-3 px-4 me-7 mb-3 ">
															<div class="fs-6 text-gray-800 fw-bold card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="copy Code"  onclick="copyInvoiceNumber('<?php echo $val['keycode'];?>' )" >  <h3 class="fw-bold m-0">  <?=$planinfo[0]['keycode']?> <i class="fa fa-copy" ></i> </h3></div>
															 
														</div>
        </div>
           </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Plan Name</label> 
            <div class="col-lg-8">
            <?=$planinfo[0]['group_name']?>                       
            </div>
            <!--end::Col-->
        </div>


        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Key Code</label> 
            <div class="col-lg-8">
            <?=$planinfo[0]['keycode']?>                       
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
 
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Retail Price</label> 
            <div class="col-lg-8">
            <?php echo ($val['monthly_price']*$val['length_months']+$val['activation_price']).' '.$resellerInfo['currency_type'];?>                 
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Dealer Price</label> 
            <div class="col-lg-8">
            <?php echo $val['dealer_price'];?> <?=$resellerInfo['currency_type'];?>                       
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Subscription</label> 
            <div class="col-lg-8">
            <?php echo $val['length_months'].$val['month_day'];?>                   
            </div>
            <!--end::Col-->
        </div>




        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Key Status</label> 
            <div class="col-lg-8">
            <?php echo ($val['used'] == '0') ? '<span class="badge py-3 px-4 fs-7 badge-light-primary">Unused (available)</span>' : '<span style=" cursor:pointer;   "  title="'.$val['title'].' '.$val['first_name'].' '.$val['la_name'].'" class="badge py-3 px-4 fs-7 badge-light-danger">Used (allocated )</span>';?>                        
            </div>
            <!--end::Col-->
        </div>




        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Creation Time</label> 
            <div class="col-lg-8">
            <?php echo date("F j, Y, g:i a", strtotime($val['date_created']));?>                       
            </div>
            <!--end::Col-->
        </div>



 
<div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Key Status</label> 
            <div class="col-lg-8">
            <?php  if($val['disabled'] == '1'){?>       
                <span class="badge badge-danger" style="padding: 6px;">Inactive</span>
            
            <?php }else{ ?>  
                <span class="badge badge-success" style="padding: 6px;">Active</span>
            <?php } ?>
            </div>
            <!--end::Col-->
        </div>


 

        <!--end::Input group-->

         
        <!--end::Input group-->

        <?php  if($val['used'] != '0'){?>
      
<!--begin::Notice-->
<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">
            <!--begin::Icon-->
        <i class="ki-duotone ki-information fs-2tx text-warning me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>        <!--end::Icon-->
    
    <!--begin::Wrapper-->
    <div class="d-flex flex-stack flex-grow-1 ">
                    <!--begin::Content-->
            <div class=" fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">This plan key   has been allotted to the customer!</h4>
                
                                    <div class="fs-6 text-gray-700 ">Your payment was declined. To start using tools, please  .</div>
                            </div>
            <!--end::Content-->
        
            </div>
    <!--end::Wrapper-->  
</div>
<br>

<div class="row mb-7">
<label class="col-lg-8 fw-semibold text-muted">   </label> 
<div class="col-lg-4">
 
												<a href="<?php echo site_url('resellers/editcustomer/').$val['user_id']; ?>" class="btn btn-sm btn-light btn-active-primary card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to Update Customer Detail !">
												<i class="ki-duotone ki-plus fs-2"></i>Edit Customer</a>
											</div>
                                            </div>  

<div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Customer Name</label> 
            <div class="col-lg-8">
            <?php echo $val['title'].'  '.$val['first_name'].' '.$val['last_name'] ?></span>                       
            </div>
            <!--end::Col-->
        </div>


 
<div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Phone .</label> 
            <div class="col-lg-8">
            <?php echo $val['phone']?></span>                       
            </div>
            <!--end::Col-->
        </div>



        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Phone .</label> 
            <div class="col-lg-8">
            <?php echo $val['phone']?></span>                       
            </div>
            <!--end::Col-->
        </div>




   <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Email .</label> 
            <div class="col-lg-8">
            <?php echo $val['email']?></span>                       
            </div>
            <!--end::Col-->
        </div>

        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Activation code .</label> 
            <div class="col-lg-8">
            <?php echo $val['activation_code']?></span>                       
            </div>
            <!--end::Col-->
        </div>


        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-semibold text-muted">Subscription Expire .</label> 
            <div class="col-lg-8">
            <?php echo $val['subscription_expire']?></span>                       
            </div>
            <!--end::Col-->
        </div>

        

<?php } ?>
 
    </div>
    <!--end::Card body-->     
</div>
<script>
      function copyInvoiceNumber(invoiceNumber) {
          navigator.clipboard.writeText(invoiceNumber).then(() => {
              alert(`Key Code ${invoiceNumber} copied  !`);
          }).catch(err => {
              alert('Failed to copy Key Code: ', err);
          });
      }
  </script>