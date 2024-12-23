<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>IPTV Management System</title>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="https://imserver.threeiptv.com/theme/assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/bg10-dark.jpeg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-up -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/agency.png" alt="" />
						<img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/agency-dark.png" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Fast, Efficient and Productive</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="text-gray-600 fs-base text-center fw-semibold">In this kind of post,
						<a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they�ve interviewed
						<br />and provides some background information about
						<a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a>and their
						<br />work following this is a transcript of the interview.</div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->
								<form class="form w-100" action="<?php echo BASE_URL;?>customer/register" method="post">
									<!--begin::Heading-->
									<div class="text-center mb-11">
										<!--begin::Title-->
										<h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
										<!--end::Title-->
										<!--begin::Subtitle-->
										<div class="text-gray-500 fw-semibold fs-6">Get unlimited access & earn money</div>
										<!--end::Subtitle=-->
									</div>
									<?php if($message == 'error'){ ?>
									<div class="alert alert-danger" role="alert" style="text-align:left;">
									<?php echo validation_errors(); ?>									
									</div>
									<?php } ?>
									<!--begin::Heading-->
									<div class="fv-row mb-2">
										<label class="fs-6 fw-semibold form-label mt-3"><span class="required">Name</span></label>
										<!--begin::Name-->
										<input type="text" placeholder="Name" name="name" autocomplete="off" class="form-control bg-transparent" value="<?php echo $name;?>" />
										<!--end::name-->
									</div>
									<div class="fv-row mb-2">
										<label class="fs-6 fw-semibold form-label mt-3"><span class="required">Email</span></label>
										<!--begin::Email-->
										<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" value="<?php echo $email;?>" />
										<!--end::Email-->
									</div>
									<div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
															
															<!--begin::Col-->
															<div class="col">
																<!--begin::Input group-->
																<div class="fv-row mb-1">
																	<!--begin::Label-->
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Country Code</span>
																	</label>
																	<!--end::Label-->
																	<div class="w-100">
																		<!--begin::Select2-->
																		<select id="kt_ecommerce_select2_country" class="form-select form-select-solid" name="c_code" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select a country">
																			<option value="">Select</option>
																			<?php
																				foreach(COUNTRY_MOBILE_CODE as $key=>$val){
																					if($key == $c_code){
																						echo '<option value="'.$key.'" selected>'.$val.'</option>';
																					} else {
																						echo '<option value="'.$key.'">'.$val.'</option>';
																					}
																					
																				}
																			?>
																		</select>
																		<!--end::Select2-->
																	</div>
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
															<!--begin::Col-->
															<div class="col">
																<!--begin::Input group-->
																<div class="fv-row mb-1">
																	<!--begin::Label-->
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span>Mobile</span>																		
																	</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input type="text" class="form-control form-control-solid" name="mobile" value="<?php echo $mobile;?>" />
																	<!--end::Input-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end::Col-->
									</div>
									
									<!--begin::Input group-->
									<div class="fv-row mb-2" data-kt-password-meter="true">
										<label class="fs-6 fw-semibold form-label mt-3"><span class="required">Password</span></label>
										<!--begin::Wrapper-->
										<div class="mb-1">
											<!--begin::Input wrapper-->
											<div class="position-relative mb-3">
												<input class="form-control bg-transparent" type="password" placeholder="Password" name="passwordv" autocomplete="off" value="<?php echo $passwordv;?>" />
												<!--<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
													<i class="ki-duotone ki-eye-slash fs-2"></i>
													<i class="ki-duotone ki-eye fs-2 d-none"></i>
												</span>-->
											</div>
											<!--end::Input wrapper-->
											<!--begin::Meter-->
											<!--<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
												<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
												<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
												<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
												<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
											</div>-->
											<!--end::Meter-->
										</div>
										<!--end::Wrapper-->
										<!--begin::Hint-->
										<div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
										<!--end::Hint-->
									</div>
									<!--end::Input group=-->
									<!--end::Input group=-->
									
									<!--end::Input group=-->
									<!--begin::Accept-->
									<div class="fv-row mb-8">
										<label class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" name="toc" value="1" <?php if($toc == '1'){ echo 'checked';} ?> />
											<span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
											<a href="#" class="ms-1 link-primary">Terms</a></span>
										</label>
									</div>
									<!--end::Accept-->
									<!--begin::Submit button-->
									<div class="d-grid mb-10">
										<!--<button type="submit" id="kt_sign_up_submit" class="btn btn-primary">											
											<span class="indicator-label">Sign up</span>											
											<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>											
										</button>-->
										<input type="submit" name="kt_sign_up_submit" class="btn btn-primary" >
									</div>
									<!--end::Submit button-->
									<!--begin::Sign up-->
									<div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
									<a href="../../demo1/dist/authentication/layouts/overlay/sign-in.html" class="link-primary fw-semibold">Sign in</a></div>
									<!--end::Sign up-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Footer-->
							<div class="w-lg-500px d-flex flex-stack">
								<!--begin::Languages-->
								<div class="me-10">
									
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
										
										
									</div>
									<!--end::Menu-->
								</div>
								
							</div>
							<!--end::Footer-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-up-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>js/custom/authentication/sign-up/general.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>