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
		<script src="<?= site_url(ASSETS); ?>/frontend/js/jquery.mask.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/app/js/dashboard.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/custom/crud/wizard/wizard.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/custom/crud/forms/widgets/bootstrap-select.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/jquery-te/jquery-te-1.4.0.min.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
		<!--end::Page Scripts -->

		</body>

		<!-- end::Body -->

		</html>