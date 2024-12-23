<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/bg10-dark.jpeg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
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
								<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="<?php echo BASE_URL;?>customer/login" method="post">
									<!--begin::Heading-->
									<div class="text-center mb-11">
										<!--begin::Title-->
										<h1 class="text-dark fw-bolder mb-3">IPTV</h1>
										<!--end::Title-->
										<!--begin::Subtitle-->
										<div class="text-gray-500 fw-semibold fs-6">Sign In</div>
										<!--end::Subtitle=-->
									</div>
									<!--begin::Heading-->
									
									<!--begin::Input group=-->
									<?php if($this->session->flashdata('message_set')){ ?>
									<div class="fv-row mb-8">
										<div class="alert alert-danger" role="alert" style="text-align:left;">
										<?php echo $this->session->flashdata('message_set'); ?>
										</div>
									</div>
									<?php } ?>
									<?php if($this->session->flashdata('message_sussess')){ ?>
									<div class="fv-row mb-8">
										<div class="alert alert-success" role="alert" style="text-align:left;">
										<?php echo $this->session->flashdata('success'); ?>
										</div>
									</div>
									<?php } ?>
									<div class="fv-row mb-8">
										<label class="fs-6 fw-semibold form-label mt-0"><span class="required">Email</span></label>
										<!--begin::Email-->
										<input type="text" placeholder="Email" name="identity" autocomplete="off" class="form-control bg-transparent" value="<?php echo $identity; ?>" />
										<!--end::Email-->
									</div>
									<!--end::Input group=-->
									<div class="fv-row mb-3">
										<label class="fs-6 fw-semibold form-label mt-0"><span class="required">Password</span></label>
										<!--begin::Password-->
										<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" value="<?php echo $password; ?>" />
										<!--end::Password-->
									</div>
									<!--end::Input group=-->
									<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
										<div><!--<input type="checkbox" name="remember">Remember--></div>
										<!--begin::Link-->
										<a href="<?php echo BASE_URL;?>customer/customerforgetpass" class="link-primary">Forgot Password ?</a>
										<!--end::Link-->
									</div>
									<!--end::Wrapper-->
									<!--begin::Submit button-->
									<div class="d-grid mb-10">
										<!--<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
											
											<span class="indicator-label">Sign In</span>
											
											<span class="indicator-progress">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										
										</button>-->
										<input type="submit" name="kt_sign_in_submit" class="btn btn-primary" >
									</div>
									<!--end::Submit button-->
									<!--begin::Sign up-->
									<div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
									<a href="<?php echo BASE_URL;?>customer/register" class="link-primary">Sign up</a></div>
									<!--end::Sign up-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Footer-->
							
							<!--end::Footer-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>