<style>
.main-logo{
	width:60px;
}
</style>
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<!--begin::Logo-->
	<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
		<!--begin::Logo image-->
		<a href="<?php echo BASE_URL;?>resellers">
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
					<a class="menu-link <?php if($active_menu == 'default'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers">
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

				 <?php /* <div data-kt-menu-trigger="click" class="menu-item <?php if($active_tab == 'dashboard'){ echo 'here show '; }?>menu-accordion">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-element-11 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>
						</span>
						<span class="menu-title">Dashboards  </span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'default'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Default</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->											
						
					</div>
					<!--end:Menu sub-->
					
					
						
				</div>  <?php */ ?>
				<!--end:Menu item-->
				
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item <?php if($active_tab == 'subscription_code'){ echo 'here show '; }?>menu-accordion">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							
							<i class="ki-duotone ki-tablet-ok fs-2x text-white">
							 <span class="path1"></span>
							 <span class="path2"></span>
							 <span class="path3"></span>
							</i>
						</span>
						<span class="menu-title">Subscription Panel</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
					<!--begin:Menu item-->
						<div class="menu-item">
							
							<a class="menu-link <?php if($active_menu == 'resellerplan'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/resellerplan">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Plans</span>
							</a>
							
						</div>
						<?php if($this->session->plan_type ==1){?>
					  <?php //if($resellerInfodash['reseller_masterkey'] == '1'){ ?>
						<!--begin:Menu item-->											
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'masterkeys'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/masterkeys">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Master Keys</span>												
							
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						<?php // }
						 }else{?>
						
						<!--begin:Menu item-->											
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'subscriptionkeys'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/subscriptionkeys">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Renew key</span>
								
								
							
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						
							<!--begin:Menu item-->											
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'activationkeys'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/activationkeys">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Activation Keys</span>
								
								
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						
						<?php } ?>
					
						
					
					<?php if($resellerInfodash['can_create_walletcode'] == '1'){ ?>
						<!--begin:Menu item-->											
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'walletmoney'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/walletmoney">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Create Wallet Code</span>
								
								
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						
					<?php } ?>	
					</div>
					<!--end:Menu sub-->
					
					
						
				</div>
				<!--end:Menu item-->
				
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item <?php if($active_tab == 'account'){ echo 'here show '; }?>menu-accordion">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-dollar  fs-2x text-white">
								 <span class="path1"></span>
								 <span class="path2"></span>
								 <span class="path3"></span>
								</i>
						</span>
						<span class="menu-title">Payment Panel</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						
						<!--begin:Menu item-->											
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'walletpayment'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/walletpayment">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Wallet Ledger</span>
								
								
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						
						<!--begin:Menu item-->											
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'rechargewallet'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/rechargewallet">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Recharge Wallet</span>
								
								
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						
					</div>
					<!--end:Menu sub-->
					
					
						
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
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php if($active_tab == 'customers'){ echo 'here show ';} ?>" >
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-people fs-2x text-white">
							 <span class="path1"></span>
							 <span class="path2"></span>
							 <span class="path3"></span>
							 <span class="path4"></span>
							 <span class="path5"></span>
							</i>
						</span>
						<span class="menu-title">Customers</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">											
						<!--begin:Menu item-->
						
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'customerslist'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/customerslist">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Customers List</span>
								
								
							</a>
							
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						
						<!--begin:Menu item-->
						
						
						<div class="menu-item" style="display:none;">
							
							<a class="menu-link <?php if($active_menu == 'rechargewallettab'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/rechargewallet">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Add Wallet Money</span>
							</a>
							
						</div>
						
						
						<!--end:Menu item-->
						<!--begin:Menu item-->
						
						
						<div class="menu-item" style="display:none;">
							
							<a class="menu-link <?php if($active_menu == 'changeplans'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/changeplans">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Change Plans</span>
							</a>
							
						</div>
						
						
						<!--end:Menu item-->
						
						
						
					</div>
					<!--end:Menu sub-->
					
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">											
						<!--begin:Menu item-->
						
						<!-- <div class="menu-item">
							 
							<a class="menu-link <?php //if($active_menu == 'rechargecustomer'){ echo 'active'; } ?>" href="<?php //echo BASE_URL;?>resellers/rechargecustomer">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Recharge Customer</span> 
								
							</a>
							
							 
						</div> -->

						<!-- <div class="menu-item">
							 
							<a class="menu-link <?php //if($active_menu == 'upgradeonecustomer'){ echo 'active'; } ?>" href="<?php //echo BASE_URL;?>resellers/upgradeonecustomer">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Recharge Customer</span> 
								
							</a>
							
							 
						</div> -->
						<!--end:Menu item-->
						
						<!--begin:Menu item-->
						
						
						<div class="menu-item" style="display:none;">
							
							<a class="menu-link <?php if($active_menu == 'rechargewallettab'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/rechargewallet">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Add Wallet Money</span>
							</a>
							
						</div>
						
						
						<!--end:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link <?php if($active_menu == 'editcustomermsg'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/editcustomermsg">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">welcome message</span>
							</a>
						
							<!--end:Menu link-->
						</div>
						<!--begin:Menu item-->
						
						
						<div class="menu-item" style="display:none;">
							
							<a class="menu-link <?php if($active_menu == 'changeplans'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>customer/changeplans">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Change Plans</span>
							</a>
							
						</div>
						
						
						<!--end:Menu item-->
						
						
						
					</div>
					<!--end:Menu sub-->
					
					
				</div>
				<!--end:Menu item-->
				
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link <?php if($active_menu == 'profile'){ echo 'active'; } ?>" href="<?php echo BASE_URL;?>resellers/profile">
					<span class="menu-icon">
					<i class="ki-duotone ki-user-tick fs-2x text-white">
						 <span class="path1"></span>
						 <span class="path2"></span>
						 <span class="path3"></span>
						</i>
				</span>
				<span class="menu-title">Profile  </span>
					</a>
					<!--end:Menu link-->
				</div>
			</div>
			<!--end::Menu-->
		</div>
		<!--end::Menu wrapper-->
	</div>
	<!--end::sidebar menu-->
	<!--begin::Footer-->
	
	<!--end::Footer-->
</div>