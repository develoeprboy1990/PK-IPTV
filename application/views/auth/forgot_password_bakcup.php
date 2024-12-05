<!DOCTYPE html>
<html lang="en">
  <!--begin::Head-->
  <head><base href="../../../"/>
    <title>Metronic - the world's #1 selling Bootstrap Admin Theme Ecosystem for HTML, Vue, React, Angular & Laravel by Keenthemes</title>
    <meta charset="utf-8" />
    <meta name="description" content="IPTV Management System" />
    <meta name="keywords" content="IPTV Management System" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="IPTV Management System" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="<?=DEFAULT_ASSETS_NEW?>assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?=DEFAULT_ASSETS_NEW?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?=DEFAULT_ASSETS_NEW?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body id="kt_body" class="app-blank app-blank">
    <!--begin::Theme mode setup on page load-->
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
      <!--begin::Authentication - Password reset -->
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Logo-->
        <a href="../../demo1/dist/index.html" class="d-block d-lg-none mx-auto py-20">
          <img alt="Logo" src="<?=DEFAULT_ASSETS_NEW?>assets/media/logos/default.svg" class="theme-light-show h-25px" />
          <img alt="Logo" src="<?=DEFAULT_ASSETS_NEW?>assets/media/logos/default-dark.svg" class="theme-dark-show h-25px" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
          <!--begin::Wrapper-->
          <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
            <!--begin::Header-->
            <div class="d-flex flex-stack py-2">
              <!--begin::Back link-->
              <div class="me-2">
                <a href="<?=site_url('login')?>" class="btn btn-icon bg-light rounded-circle">
                  <!--begin::Svg Icon | path: icons/duotune/arrows/arr002.svg-->
                  <span class="svg-icon svg-icon-2 svg-icon-gray-800">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M9.60001 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13H9.60001V11Z" fill="currentColor" />
                      <path opacity="0.3" d="M9.6 20V4L2.3 11.3C1.9 11.7 1.9 12.3 2.3 12.7L9.6 20Z" fill="currentColor" />
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </a>
              </div>
              <!--end::Back link-->
              <!--begin::Sign Up link-->
              <div class="m-0">
                <span class="text-gray-400 fw-bold fs-5 me-2" data-kt-translate="password-reset-head-desc">Already a member ?</span>
                <a href="<?=site_url('login')?>" class="link-primary fw-bold fs-5" data-kt-translate="password-reset-head-link">Sign In</a>
              </div>
              <!--end::Sign Up link=-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-20">
              <!--begin::Form-->
              <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="../../demo1/dist/authentication/layouts/fancy/new-password.html" action="<?=site_url('forgot_password')?>" method="POST">
                <!--begin::Heading-->
                <div class="text-start mb-10">
                  <!--begin::Title-->
                  <h1 class="text-dark mb-3 fs-3x" data-kt-translate="password-reset-title">Forgot Password ?</h1>
                  <!--end::Title-->
                  <!--begin::Text-->
                  <div class="text-gray-400 fw-semibold fs-6" data-kt-translate="password-reset-desc">Enter your email to reset your password.</div>
                  <!--end::Link-->
                </div>

               <!--  <?php if($message){ ?>
                      <div class="alert alert-danger" role="alert" style="text-align:center"><?php //echo $message;?></div>
                <?php } ?> -->

                <?php if($this->session->flashdata('success')){?>
                      <div class="alert alert-success" role="alert" style="text-align:center"><?php echo $this->session->flashdata('success');?></div>
                <?php }?>

                <?php if($this->session->flashdata('error')){?>
                      <div class="alert alert-danger" role="alert" style="text-align:center"><?php echo $this->session->flashdata('error');?></div>
                <?php }?>

                <!--begin::Heading-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                  <?php echo form_input($identity);?>
                 <!--  <input class="form-control form-control-solid" type="email" placeholder="Email" name="email" autocomplete="off" data-kt-translate="password-reset-input-email" /> -->
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="d-flex flex-stack">
                  <!--begin::Link-->
                  <div class="m-0">
                    <button id="kt_password_reset_submit" class="btn btn-primary me-2" data-kt-translate="password-reset-submit">
                      <!--begin::Indicator label-->
                      <span class="indicator-label">Submit</span>
                      <!--end::Indicator label-->
                      <!--begin::Indicator progress-->
                      <span class="indicator-progress">Please wait...
                      <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                      <!--end::Indicator progress-->
                    </button>
                    <a href="<?=site_url('login')?>" class="btn btn-lg btn-light-primary fw-bold" data-kt-translate="password-reset-cancel">Cancel</a>
                  </div>
                  <!--end::Link-->
                </div>
                <!--end::Actions-->
              </form>
              <!--end::Form-->
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="m-0">
            </div>
            <!--end::Footer-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Aside-->
        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" style="background-image: url(<?=DEFAULT_ASSETS_NEW?>assets/media/auth/bg11.png)"></div>
        <!--begin::Body-->
      </div>
      <!--end::Authentication - Password reset-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>var hostUrl = "<?=DEFAULT_ASSETS_NEW?>assets/";</script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="<?=DEFAULT_ASSETS_NEW?>assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?=DEFAULT_ASSETS_NEW?>assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?=DEFAULT_ASSETS_NEW?>assets/js/custom/authentication/reset-password/reset-password.js"></script>
    <script src="<?=DEFAULT_ASSETS_NEW?>assets/js/custom/authentication/sign-in/i18n.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
  </body>
  <!--end::Body-->
</html>