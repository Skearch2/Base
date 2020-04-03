		<!--begin::Global Theme Bundle -->
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script>
			$(document).ready(function() {
				$('#phone').mask('(000) 000-0000');
			});
		</script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/frontend/js/jquery.mask.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/app/js/dashbsoard.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
		<!--end::Page Scripts -->

		</body>

		<!-- end::Body -->

		</html>