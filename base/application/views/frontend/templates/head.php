<!--
	File:     ~/application/views/templates/head.php
	Author:   Iftikhar Ejaz - i.ejaz@skearch.net

	Defines global head element for every page.
	Defines global metadata, CSS, and JavaScript links
	Uses $data in view call to set page title.

-->

<head>
    <!-- Metadata -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139872847-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-139872847-1');
    </script>


    <!--
	* 	Link to:
	* 		**Stylesheets**
	* 		
    * 		Bootstrap
    *       Theme
    *	 	Font Awesome
    *       Bootstrap Toggle
    *       jQuery UI
    *       Toastr
	-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href='<?= base_url(ASSETS) ?>/frontend/css/<?= $this->session->userdata('settings')->theme ?>.css' rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!--
	* 	Link to:
    *		** JavaScript **
    * 		jQuery
    *       Bootstrap
    * 		Popper
	* 		Bootstrap Toggle
	*       jQuery UI
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!--
	* 	Link to:
	* 		** Icons **
	* 		Skearch icon file (page)
	* 		Skearch icon file (shortcut)
	-->
    <link rel='icon' href='<?= base_url(ASSETS); ?>/frontend/images/favicon.png' type='image/png' />
    <link rel='shortcut icon' href='<?= base_url(ASSETS); ?>/frontend/images/favicon.png' type='image/png' />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&display=swap" rel="stylesheet">

    <!-- Page title -->
    <title><?= $title; ?></title>

    <script type="text/javascript">
        function submit_me() {
            document.google_search_form.submit();
        }
    </script>

    <!-- Search -->
    <script type="text/javascript">
        function ajaxSearch(keyword) {
            if (keyword.length > 0) {
                $.ajax({
                    url: '<?= site_url(); ?>search?search_keyword=' + keyword,
                    type: 'GET',
                    async: false,
                    success: function(data) {
                        urlObj = JSON.parse(data);
                        if (urlObj.type == 'external') {
                            var is_safari = navigator.userAgent.indexOf("Safari") > -1;
                            if (is_safari) {
                                // open url on current page
                                window.location.replace(urlObj.url);
                            } else {
                                // open url on new page
                                window.open(urlObj.url);
                            }
                        } else if (urlObj.type == 'internal')
                            window.location.replace(urlObj.url);
                    },
                    error: function(data) {
                        alert("Something went wrong. Can't Search");
                    }

                });
            }
        }
    </script>

    <script>
        function changeTheme() {
            $.ajax({
                url: '<?= base_url('theme/change'); ?>',
                type: 'GET',
                success: function(data, status) {
                    location.reload(true);
                },
                error: function(xhr, status, error) {
                    alert("Unable to change the theme.");
                }

            });
        }
    </script>

    <!-- Update media impressions shown on media box -->
    <script type="text/javascript">
        $(function() {
            $('.carousel').on('slide.bs.carousel', function(event) {
                imageid = $(event.relatedTarget).attr('data-imageid');
                $.get("<?= site_url("impression/image/id/"); ?>" + imageid, function() {});
            })
        });
    </script>

</head>