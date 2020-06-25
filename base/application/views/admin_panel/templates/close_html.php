		<!--begin::Global Theme Bundle -->
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/demo/demo12/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
		<!--end::Page Vendors -->
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

		<!--begin::Page Scripts -->
		<script>
			// settings for toastr notifications
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": true,
				"progressBar": false,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut",
			};

			// timeout for bootstrap alert - remove after 5 seconds
			// $(function() {
			// 	setTimeout(function() {
			// 		if ($(".alert").is(":visible")) {
			// 			$(".alert").fadeOut("slow");
			// 		}
			// 	}, 5000)
			// });
		</script>

		<script src="<?= site_url(ASSETS); ?>/admin_panel/vendors/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/admin_panel/app/js/dashboard.js" type="text/javascript"></script>
		<script src="<?= site_url(ASSETS); ?>/plugins/easyautocomplete/jquery.easy-autocomplete.min.js"></script>


		<!--end::Page Scripts -->

		</body>

		<!-- end::Body -->

		</html>