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
		<?php isset($_extra_scripts) ? $this->load->view($_extra_scripts) : ''; ?>
	</body>
	<!--end::Body-->
</html>