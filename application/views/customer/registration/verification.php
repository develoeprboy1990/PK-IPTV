<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/bg10-dark.jpeg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Two-factor -->
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
								<form class="form w-100 mb-13" novalidate="novalidate">
									<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
									<!--begin::Icon-->
									<!--<div class="text-center mb-10">
										<img alt="Logo" class="mh-125px" src="assets/media/svg/misc/smartphone-2.svg" />
									</div>-->
									<!--end::Icon-->
									<!--begin::Heading-->
									<div class="text-center mb-10">
										<!--begin::Title-->
										<!--<h1 class="text-dark mb-3">Two-Factor Verification</h1>-->
										<h1 class="text-dark fw-bolder mb-3">IPTV</h1>
										<!--end::Title-->
										<!--begin::Sub-title-->
										<div class="text-muted fw-semibold fs-5 mb-5">Verification Code sent to Mobile and Email</div>
										<!--end::Sub-title-->
										<!--begin::Mobile no-->
										<!--<div class="fw-bold text-dark fs-3">******7859</div>-->
										<!--end::Mobile no-->
									</div>
									<!--end::Heading-->
									<!--begin::Section-->
									<div class="mb-10">
										<!--begin::Label-->
										<div class="fw-bold text-start text-dark fs-6 mb-1 ms-1">Type your 6 digit security code
											&nbsp;&nbsp;&nbsp;&nbsp;<span id="countdown_auth" style="text-align:center;text-align:right;font-size: 15px;font-weight: bold;color: red;"></span>
										</div>
									
										<!--end::Label-->
										<!--begin::Input group-->
										<div class="d-flex flex-wrap flex-stack">
											<input type="text" name="code_1" id="code_1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" onKeyUp="inputfocus('1','2')" onClick="this.select();" onpaste="onafterpaste(myFunction,this)" />
											<input type="text" name="code_2" id="code_2" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" onKeyUp="inputfocus('2','3')" onClick="this.select();" />
											<input type="text" name="code_3" id="code_3" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" onKeyUp="inputfocus('3','4')" onClick="this.select();" />
											<input type="text" name="code_4" id="code_4" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" onKeyUp="inputfocus('4','5')" onClick="this.select();" />
											<input type="text" name="code_5" id="code_5" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" onKeyUp="inputfocus('5','6')" onClick="this.select();" />
											<input type="text" name="code_6" id="code_6" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2" value="" onClick="this.select();" />
										</div>
										<!--begin::Input group-->
									</div>
									<!--end::Section-->
									<!--begin::Submit-->
									
									<div id="msgalert" style="text-align:center;"></div>
									<div class="d-flex flex-center">
										<button type="button" id="kt_sing_in_two_factor_submit" class="btn btn-lg btn-primary fw-bold">
											<span class="indicator-label" id="submitbtn">Submit</span>
											<span class="indicator-progress" id="waittext">Please wait...
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										</button>
										
									</div>
									
									<!--end::Submit-->
								</form>
								<!--end::Form-->
								<!--begin::Notice-->
								
								<!--end::Notice-->
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
			<!--end::Authentication - Two-factor-->
		</div>
<script>

</script>		