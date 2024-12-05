<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href=""/>
		<title>XPLAYER - Dealer IPTV Management System</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="https://imserver.threeiptv.com/theme/assets/media/logos/xplayer-fav.png" />


		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		
		

		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!-- DataTables old -->
  		<!-- <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->

		<!-- DataTables new -->
		<!-- <link rel="stylesheet" href="<?= DEFAULT_ASSETS ?>bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
		<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>css/datatables.bundle.css" rel="stylesheet" type="text/css" />
		
		<!-- <link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" /> -->
		
		
		


		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	
	<style>
		.breadcrumb {
	    display: flex;
	    align-items: center;
	    background-color: transparent;
	    padding: 0;
	    font-size: 15px;
	    margin: 0;
	    color: #515151;
		}
	</style>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
	<!--begin::Theme mode setup on page load-->
	<script>
	var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
	</script>
	
	<!--end::Theme mode setup on page load-->
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<div id="kt_app_header" class="app-header" style="background:#ddecf7;">
				<!--begin::Header container-->
				<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
					<!--begin::Sidebar mobile toggle-->
					<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
						<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
							<i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<!--end::Sidebar mobile toggle-->
					<!--begin::Mobile logo-->
					<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
						<a href="" class="d-lg-none">
							<img alt="Logo" src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/logos/default-small.svg" class="h-30px" />
						</a>
					</div>
					<!--end::Mobile logo-->
					<!--begin::Header wrapper-->
					<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1 " id="kt_app_header_wrapper">
						<!--begin::Menu wrapper-->
						<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
							<!--begin::Menu-->
							<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here menu-here-bg menu-lg-down-accordion me-0 me-lg-2" >
									<a href="<?php echo BASE_URL;?>resellers/walletpayment">
									<!--begin:Menu link-->
									<span class="menu-link" style="background:#000000;">
										<span class="menu-title" style="color: #fff;font-weight: bold; font-size:17px;">
										<i class="ki-duotone ki-dollar fs-2x text-success" >
											 <span class="path1"></span>
											 <span class="path2"></span>
											 <span class="path3"></span>
											</i> Wallet Money: <?php echo number_format($resellerInfodash['wallet_money'], 2, '.', '') . ' ' . $resellerInfodash['currency_type']; ?> <br>
										
										</span>
										<span class="menu-arrow d-lg-none"></span>
									</span>
									<!--end:Menu link-->
									</a>
									<!--begin:Menu sub-->
									
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->									
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Menu wrapper-->
						<!--begin::Navbar-->
						<div class="app-navbar flex-shrink-0">
							<!--begin::Search-->
							
							<!--end::Search-->
							<!--begin::Activities-->
							<div class="app-navbar-item ms-1 ms-md-3">
								<!--begin::Drawer toggle-->
								<div class="btn btn-icon btn-success btn-custom btn-active-light w-50px h-50px w-md-40px h-md-40px" id="kt_activities_toggle">
									<i class="ki-duotone ki-chart-simple fs-2x fs-lg-1 text-dark">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
									</i>
								</div>
								<!--end::Drawer toggle-->
							</div>
							<!--end::Activities-->
							<!--begin::Notifications-->
							
							<!--end::Notifications-->
							<!--begin::Chat-->
							<div class="app-navbar-item ms-1 ms-md-3" style="display:none;">
								<!--begin::Menu wrapper-->
								<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative" id="kt_drawer_chat_toggle">
									<i class="ki-duotone ki-message-text-2 fs-2 fs-lg-1">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
									</i>
									<span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
								</div>
								<!--end::Menu wrapper-->
							</div>
							<!--end::Chat-->
							<!--begin::My apps links-->
							<div class="app-navbar-item ms-1 ms-md-3">
								<!--begin::Menu wrapper-->
								<!--<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<i class="ki-duotone ki-element-11 fs-2 fs-lg-1">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
									</i>
								</div>-->
								
								<!--end::Menu wrapper-->
							</div>
							<!--end::My apps links-->
					
							<div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
								<!--begin::Menu wrapper-->
								<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<img src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/logo-profile.png" alt="user" />
								</div>
								<!--begin::User account menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3">
											<!--begin::Avatar-->
											<div class="symbol symbol-50px me-5">
												<img alt="Logo" src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/avatars/logo-profile.png" />
											</div>
											<!--end::Avatar-->
											<!--begin::Username-->
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5"> <?php echo $this->session->resellername; ?>
												<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Dealer</span></div>
												<a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $this->session->reselleremail;?></a>
											</div>
											<!--end::Username-->
										</div>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="<?php echo BASE_URL;?>resellers/profile" class="menu-link px-5">My Profile</a>
									</div>
								<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="<?php echo BASE_URL;?>resellers/logout" class="menu-link px-5">Sign Out</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::User account menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::User menu-->
							<!--begin::Header menu toggle-->
							<div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
								<div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
									<i class="ki-duotone ki-element-4 fs-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
							</div>
							<!--end::Header menu toggle-->
						</div>
						<!--end::Navbar-->
					</div>
					<!--end::Header wrapper-->
				</div>
				<!--end::Header container-->
			</div>
		
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Sidebar-->