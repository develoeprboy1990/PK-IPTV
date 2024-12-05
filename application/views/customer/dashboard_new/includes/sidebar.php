<style>
.main-logo{
	width:60px;
}
</style>
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<!--begin::Logo-->
	<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
		<!--begin::Logo image-->
		<a href="<?php echo BASE_URL;?>customer">
			<img alt="Logo" src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/logos/logo-general.png" width="120" class="main-logo" />
		</a>
		
		<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
			<i class="ki-duotone ki-double-left fs-2 rotate-180">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Sidebar toggle-->
	</div>
	<!--end::Logo-->
	<!--begin::sidebar menu-->
	<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
		<!--begin::Menu wrapper-->
		<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
			<!--begin::Menu-->
			<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

				<!--begin:Menu item-->

				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link <?php if($active_tab == 'default'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/profile">
						<span class="menu-icon">
							<i class="ki-duotone ki-element-11 fs-2x text-white">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>
						</span>
						<span class="menu-title">Dashboards  </span>
					</a>
					<!--end:Menu link-->
				</div>
				
				
				<!--end:Menu item-->

				<!--begin:Menu item-->
				<!--<div class="menu-item pt-5">
					
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7">Pages</span>
					</div>
					
				</div>-->
				<!--end:Menu item-->
				
				<!--begin:Menu item-->
				 <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php if($active_tab == 'usersubscription'){ echo 'here show ';} ?>">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-tablet-ok fs-2x text-white">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</span>
						<span class="menu-title">Subscription</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">	

						<div class="menu-item">

							<a class="menu-link <?php if($active_menu == 'currentActivePlan'){ echo 'active'; } ?>" href="<?php echo BASE_URL . 'customer/currentActivePlan/' . $this->session->user_id; ?>">
							    <span class="menu-bullet">
							        <span class="bullet bullet-dot"></span>
							    </span>
							    <span class="menu-title">Active Plan</span>
							</a>
							
						</div> 


						<div class="menu-item">

							<a class="menu-link <?php if($active_menu == 'changeplans'){ echo 'active'; } ?>" href="<?php echo BASE_URL . 'customer/upgradeplans'; ?>">
							    <span class="menu-bullet">
							        <span class="bullet bullet-dot"></span>
							    </span>
							    <span class="menu-title">Change Plan</span>
							</a>
							
						</div>


						<?php if($this->session->product_activation_key_id > 0){ }else{?>
						<div class="menu-item">
							<a class="menu-link <?php if($active_menu == 'activatecode'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/activatecode">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Activation Code</span>
								<?php 
									/*if($this->session->product_activation_key_id > 0){ 
										echo '<span class="menu-title">Subscription Code</span>';
									} else {
										echo '<span class="menu-title">Activation Code</span>';
									}*/
								?>
								
							</a>
						</div>
						<?php } ?>
						
						
						<!-- <div class="menu-item">
							
							<a class="menu-link <?php if($active_menu == 'rechargewallettab'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/rechargewallet">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Add Wallet Money</span>
							</a>
							
						</div> -->
						
						
						<?php
							if(($product->customer_can_change_plan == '1') && (count($group_product) > 0)){
						?>
						<!-- <div class="menu-item">
							
							<a class="menu-link <?php if($active_menu == 'changeplans'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/changeplans">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Change Plans</span>
							</a>
							
						</div> -->
						
						<?php } ?>
						
						
						
					</div>
				</div> 
				
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php if($active_tab == 'userfrofile'){ echo 'here show ';} ?>">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-user-tick fs-2x text-white">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</span>
						<span class="menu-title">User Profile</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'setting'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/setting">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Settings</span>
							</a>
						
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						<!--begin:Menu item-->
						<div class="menu-item" >
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'cpassword'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/changepassword">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Change Password</span>
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->									
						
						<div class="menu-item">
						    <a class="menu-link <?php if($active_menu == 'cemail'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/changeemail">
						        <span class="menu-bullet">
						            <span class="bullet bullet-dot"></span>
						        </span>
						        <span class="menu-title">Change Email</span>
						    </a>
						</div>				
						
					</div>
					<!--end:Menu sub-->
				</div>
				<!--end:Menu item-->
			</div>
			<!--end::Menu-->
		</div>
		<!--end::Menu wrapper-->
	</div>
	<!--end::sidebar menu-->
	<!--begin::Footer-->
	
	<!--end::Footer-->
</div>