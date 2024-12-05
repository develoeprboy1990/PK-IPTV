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
						<a href="#" class="opacity-75-hover text-primary me-1">the blogger</a>introduces a person they’ve interviewed
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
								<form class="form w-100" novalidate="novalidate" onSubmit="return false;">
									<!--begin::Heading-->
									<div class="text-center mb-11">
										<!--begin::Title-->
										<h1 class="text-dark fw-bolder mb-3">IPTV</h1>
										<!--end::Title-->
										<!--begin::Subtitle-->
										<div class="text-gray-500 fw-semibold fs-6">Forgot Password</div>
										<!--end::Subtitle=-->
									</div>
									<!--begin::Heading-->
									
									<!--begin::Input group=-->
									<div class="fv-row mb-4">
										<label class="fs-6 fw-semibold form-label mt-0"><span class="required">Email</span></label>
										<!--begin::Email-->
										<input type="text" placeholder="Email" name="email" id="email" autocomplete="off" class="form-control bg-transparent" />
										<!--end::Email-->
										<span id="msgalert"></span>
									</div>
									
									<!--end::Input group=-->
									
									<!--begin::Input group=-->
									<div class="fv-row mb-4">
										<label class="fs-6 fw-semibold form-label mt-0"><span class="required">Send in Email</span></label>
										<!--begin::Email-->
										<input type="checkbox" name="send_email" id="send_email">
										
										<!--end::Email-->
										<label class="fs-6 fw-semibold form-label mt-0" style="    margin-left: 30px;"><span class="required">Send In SMS</span></label>
										<!--begin::Email-->
										<input type="checkbox" name="send_sms" id="send_sms">
									</div>
									
									<!--end::Input group=-->
									
									
									<!--begin::Wrapper-->
									<!--<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-4">
										<div></div>
									
										<a href="<?php echo BASE_URL;?>customer/customerlogin" class="link-primary">Sign in ?</a>
										
									</div>-->
									<!--end::Wrapper-->
									<!--begin::Submit button-->
									<div id="msgalert_success" style="text-align:center;"></div>
									<div class="d-grid mb-10">
										<button type="submit" class="btn btn-primary" style="padding:0;height: 40px;" >
											<!--begin::Indicator label-->
											<span class="indicator-label"  id="forget_password" style="    padding: 10px 46%;">Send</span>
											<!--end::Indicator label-->
											<!--begin::Indicator progress-->
											<span class="indicator-progress" id="waittext">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											<!--end::Indicator progress-->
										</button>
									</div>
									<!--end::Submit button-->
									<!--begin::Sign up-->
									<div class="text-gray-500 text-center fw-semibold fs-6">
									<a href="<?php echo BASE_URL;?>customer/customerlogin" class="link-primary">Sign in ?</a>
									Not a Member yet?
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