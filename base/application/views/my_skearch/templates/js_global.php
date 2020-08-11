<!--begin::Global Theme Bundle -->
<script src="<?= site_url(ASSETS); ?>/my_skearch/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="<?= site_url(ASSETS); ?>/my_skearch/demo/demo8/base/scripts.bundle.js" type="text/javascript"></script>

<script>
    // Ping the server every 10 seconds that the user is active
    setInterval(function() {
        ping();
    }, 10000);

    // Update user activity
    function ping() {
        $.ajax({
            url: "<?= base_url(); ?>myskearch/private_social/ping",
            method: "GET"
        })
    }

    // settings for toastr notifications
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "autoDismiss": true,
        "maxOpened": 1,
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "swing",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>


<!--end::Global Theme Bundle -->