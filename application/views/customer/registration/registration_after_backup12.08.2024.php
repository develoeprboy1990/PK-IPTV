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
				<div class="d-flex flex-column flex-center text-center p-10">
					<!--begin::Wrapper-->
					<div class="card card-flush w-lg-650px py-5">
						<div class="card-body py-15 py-lg-20">
							<!--begin::Logo-->
							<div class="mb-14">
								<a href="<?php echo BASE_URL;?>customer/customerlogin" class="">
									<img alt="Logo" src="<?php echo DEFAULT_ASSETS_CUSTOMER_NEW;?>media/auth/after_registration_2.png" class="h-150px">
								</a>
							</div>
							<!--end::Logo-->
							<!--begin::Title-->
							
							<!--end::Title-->
							<!--begin::Action-->
							<div class="fs-6 mb-8">
								<span class="fw-semibold text-gray-500">Thanks for signing up. We are happy to have you.</span>								
							</div>
							<h1 class="fw-bolder text-gray-900 mb-5">Please check your Email or SMS <br>to find Login details</h1>
							<!--end::Action-->
							<!--begin::Link-->
							<div class="mb-11">
								<a href="<?php echo BASE_URL;?>customer/customerlogin" class="btn btn-sm btn-primary">Login</a>
							</div>
							<!--end::Link-->
							
						</div>
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Two-factor-->
		</div>
<script>

</script>		