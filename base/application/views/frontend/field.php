<?php

// Set DocType and declare HTML protocol
$this->load->view('frontend/templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('frontend/templates/head');

// Start body element
$this->load->view('frontend/templates/startbody');

// Load appropriate header (logged in, admin options, etc.)
$this->load->view('frontend/templates/header');

?>

<script>
</script>

<!-- Media Box A -->
<section class="ad">
    <div class="container">
        <div id="myCarouselA" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="ads" id="media-box-a-sign">
                <p>Ad</p>
            </div>
            <div class="carousel-inner">
                <?php foreach ($banner_a_ads as $ad) : ?>
                    <div class="carousel-item" data-adid="<?= $ad->id ?>" data-interval="<?= $ad->duration ?>" data-ad-sign="<?= $ad->has_sign ?>">
                        <?php if (empty($ad->url)) : ?>
                            <a href='javascript:void(0)' title='<?= $ad->title ?>'>
                            <?php else : ?>
                                <a href='<?= site_url("redirect/ad/id/" . $ad->id) ?>' target='_blank' title='<?= $ad->title ?>'>
                                <?php endif ?>
                                <?php $is_video = substr(strtolower($ad->media), -3) == 'mp4' ? 1 : 0 ?>
                                <?php if ($is_video) : ?>
                                    <video class="responsive" width="1000" height="110" loop muted>
                                        <source src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" type="video/mp4">
                                        Unable to play video, incompatible browser.
                                    </video>
                                <?php else : ?>
                                    <img class="responsive" width="1000" height="110" src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" />
                                <?php endif ?>
                                </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>


<section class="field-main">
    <div class="container">
        <div class="row">
            <div class="main-box no-border">
                <div class="box inline-box">
                    <h3>Related Fields</h3>
                </div>
                <div class="middle-inner browse-inner border-box">
                    <div class="row category_list_home accessorize-list">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-3 f-box umbrella">
                                    <a href="<?= base_url() ?>browse/<?= $umbrella_name ?>" title="<?= $umbrella_name ?>"><?= $umbrella_name ?></a>
                                </div>
                                <?php foreach ($results as $results) : ?>
                                    <?php if (!$results->is_result_umbrella) : ?>
                                        <div class="col-sm-3 f-box">
                                            <a href="<?= base_url('browse/') . strtolower($results->umbrella) ?>/<?= strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->home_display ?></a>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-3 f-box umbrella">
                                            <a href="<?= base_url('browse/') . strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->home_display ?></a>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
                <h1><?= ucwords($field_name) ?></h1>
            </div>
        </div>
    </div>
</section>

<section class="list-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-9">
                <div class="skearch-result-blue">
                    <div class="rhead">
                        <div class="row">
                            <div class="col-md-6 skearch-result-hd-blue">
                                <a title="Display results in priority order" style="cursor: pointer" id="priority_logo">
                                    <img src="<?= base_url(ASSETS) ?>/frontend/images/logo-result.png" width="100"></a>
                            </div>
                            <div class="col-md-6 result-btn-right-blue">
                                <a id="button_order" value="asc" title="Display results in ascending order" class="btn-a2z">A-Z</a>
                                <a id="button_shuffle" title="Display results in shuffling order" class="btn-shuffle">Shuffle</a>
                            </div>
                        </div>
                    </div>
                    <div class="result-listing-blue">
                        <div id="container_vertical">
                            <!-- Result listing goes here through ajax query -->
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4 col-sm-3">
                <i id="speaker" class="fas fa-volume-mute" title="Unmute" onclick="toggleMute()"></i>
                <div id="myCarouselB" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="ads" id="media-box-b-sign">
                        <p>Ad</p>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($banner_b_ads as $ad) : ?>
                            <div class="carousel-item" data-adid="<?= $ad->id ?>" data-interval="<?= $ad->duration ?>" data-ad-sign="<?= $ad->has_sign ?>">
                                <?php if (empty($ad->url)) : ?>
                                    <a href='javascript:void(0)' title='<?= $ad->title ?>'>
                                    <?php else : ?>
                                        <a href='<?= site_url("redirect/ad/id/" . $ad->id) ?>' target='_blank' title='<?= $ad->title ?>'>
                                        <?php endif ?>
                                        <?php $is_video = substr(strtolower($ad->media), -3) == 'mp4' ? 1 : 0 ?>
                                        <?php if ($is_video) : ?>
                                            <video class="responsive" width="300" height="600" loop muted>
                                                <source src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" type="video/mp4">
                                                Unable to play video, incompatible browser.
                                            </video>
                                        <?php else : ?>
                                            <img class="responsive" width="300" height="600" src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" />
                                        <?php endif ?>
                                        </a>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Load default footer.
$this->load->view('frontend/templates/footer');
?>

<!-- Page Scripts -->
<script>
    $(document).ready(function() {
        $.fn.showResults = function(order) {
            $.ajaxSetup({
                cache: false
            });
            var uri = "<?= site_url('get_results/field/id/' . $field_id . '/order/'); ?>" + order;
            $.getJSON(uri, function(response) {
                $(".result-listing").html("");
                var items = [];
                var site_url = "<?= site_url('redirect/link/id/') ?>"
                $.each(response, function(key, val) {
                    items.push("\
						<li>\
							<div>" + (val.priority) + ". <a href='" +
                        site_url + (val.id) + "' title='" + (val.title) + "' target='_blank'>" + (val.title) + "</a></div>\
							<p>" + (val.description_short) + "</br>\
							    <span><a href='" +
                        site_url + (val.id) + "' title='" + (val.title) + "' target='_blank'>" + (val.display_url) + "</a>\</span>\
                            </p>\
						</li>\
						");
                });
                $("<ul/>", {
                    "class": "result-listing",
                    "tabindex": 0,
                    "id": "GFG_UP",
                    html: items.join("")
                }).appendTo("#container_vertical");
            });
        }

        $("#button_shuffle").click(function() {
            $.fn.showResults("random");
        });

        $("#priority_logo").click(function() {
            $.fn.showResults("priority");
        });

        $("#button_order").click(function() {
            var order = $(this).attr('value');
            if (order === 'asc') {
                $("#button_order").removeClass('btn-a2z').addClass('btn-z2a');
                $("#button_order").attr('value', 'desc');
                $("#button_order").html("Z-A")
                $("#button_order").prop('title', 'Display results in descending order');
            } else if (order === 'desc') {
                $("#button_order").removeClass('btn-z2a').addClass('btn-a2z');
                $("#button_order").attr('value', 'asc');
                $("#button_order").html("A-Z");
                $("#button_order").prop('title', 'Display results in ascending order');
            }
            $.fn.showResults(order);
        });

        $.fn.showResults("auto");

        // activate the carousel for media box A and B
        $('#myCarouselA').find('.carousel-item').first().addClass('active');
        $('#myCarouselB').find('.carousel-item').first().addClass('active');

        // update impressions on the banner in media box (for single media)
        if ($('#myCarouselA').find('.carousel-item').first().hasClass('active')) {
            adId = $('#myCarouselA').find('.carousel-item').first().attr('data-adid')
            $.get("<?= site_url("update/impression/ad/id/") ?>" + adId, function() {});
        }

        if ($('#myCarouselB').find('.carousel-item').first().hasClass('active')) {
            adId = $('#myCarouselB').find('.carousel-item').first().attr('data-adid')
            $.get("<?= site_url("update/impression/ad/id/") ?>" + adId, function() {});
        }

        // show ad sign on sponsered banner
        var isAd = $('#myCarouselA .carousel-item.active').data("ad-sign");
        if (isAd) {
            $('#media-box-a-sign').css('visibility', 'visible');
        } else {
            $('#media-box-a-sign').css('visibility', 'hidden');
        }

        var isAd = $('#myCarouselB .carousel-item.active').data("ad-sign");
        if (isAd) {
            $('#media-box-b-sign').css('visibility', 'visible');
        } else {
            $('#media-box-b-sign').css('visibility', 'hidden');
        }

        $('#myCarouselA').on('slid.bs.carousel', function() {
            $(this).find('.carousel-item.active').each(function() {
                var isAd = $(this).data("ad-sign");
                if (isAd) {
                    $('#media-box-a-sign').css('visibility', 'visible');
                } else {
                    $('#media-box-a-sign').css('visibility', 'hidden');
                }
            });
        });

        $('#myCarouselB').on('slid.bs.carousel', function() {
            $(this).find('.carousel-item.active').each(function() {
                var isAd = $(this).data("ad-sign");
                if (isAd) {
                    $('#media-box-b-sign').css('visibility', 'visible');
                } else {
                    $('#media-box-b-sign').css('visibility', 'hidden');
                }
            });
        });

        // Video settings for carousel
        $('#myCarouselA').find('.carousel-item').first().find('video').each(function() {
            $('#speaker').show();
            this.play();
        });
        $('#myCarouselA').on('slid.bs.carousel', function() {
            $(this).find('.carousel-item.active video').each(function() {
                $('#speaker').show();
                this.play();
            });
        });
        $('#myCarouselA').on('slide.bs.carousel', function() {
            $(this).find('.carousel-item.active video').each(function() {
                $("#speaker").hide();
                this.pause();
                this.currentTime = 0;
            });
        });


        $('#myCarouselB').on('slid.bs.carousel', function() {
            $(this).find('.carousel-item.active video').each(function() {
                $('#speaker').show();
                this.play();
            });
        });
        $('#myCarouselB').on('slide.bs.carousel', function() {
            $(this).find('.carousel-item.active video').each(function() {
                $("#speaker").hide();
                this.pause();
                this.currentTime = 0;
            });
        });

    });


    // Mute or unmute html video
    function toggleMute() {
        var muted = $("video").prop("muted");
        if (muted) {
            $('video').prop('muted', false);
            $('#speaker').attr('class', 'fa fa-volume-up').prop('title', 'Mute');
        } else {
            $('video').prop('muted', true);
            $('#speaker').attr('class', 'fas fa-volume-mute').prop('title', 'Unmute');
        }
    }
</script>

<?php
// Close body and html elements.
$this->load->view('frontend/templates/closepage');
?>