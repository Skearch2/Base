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

<script type="text/javascript">
    // var t;

    // var start = $('#myCarouselB').find('.active').attr('data-interval');
    // t = setTimeout("$('#myCarouselB').carousel({interval: 1000});", start - 1000);

    // $('#myCarouselB').on('slid.bs.carousel', function() {
    //     clearTimeout(t);
    //     var duration = $(this).find('.active').attr('data-interval');

    //     $('#myCarouselB').carousel('pause');
    //     t = setTimeout("$('#myCarouselB').carousel();", duration - 1000);
    // })
</script>

<script>
    $(document).ready(function() {
        $.fn.showResults = function(value) {
            $.ajaxSetup({
                cache: false
            });
            var uri = "<?= site_url('browse/get_field_results/' . $field_id . '/'); ?>" + value;
            $.getJSON(uri, function(response) {
                $(".result-listing").html("");
                var items = [];
                $.each(response, function(key, val) {
                    items.push("\
						<li>\
							<div>" + (++key) + ". <a href='" + (val.www) + "' title='" + (val.title) + "' target='_blank'>" + (val.title) + "</a></div>\
							<p>" + (val.description_short) + "</br>\
							    <span><a href='" + (val.www) + "' title='" + (val.title) + "' target='_blank'>" + (val.display_url) + "</a>\</span>\
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

        $.fn.showResults("priority");

    });
</script>

<!-- Media Box A -->
<section class="ad">
    <div class="container">
        <div id="myCarouselA" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <?php $media_box_a_index = 0; ?>
                <?php foreach ($media_box_a as $banner) : ?>
                    <div class="<?= ($media_box_a_index == 0 ?  "carousel-item active" : "carousel-item") ?>" data-imageid="<?= $banner['imageid'] ?>" data-interval="<?= $banner['duration'] ?>">
                        <a href='<?= site_url("redirect/link/id/" . $banner['imageid']) ?>' target='_blank' title='<?= $banner['title'] ?>'>
                            <img class="responsive" src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" />
                        </a>
                    </div>
                    <?php $media_box_a_index++; ?>
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
                <div class="middle-inner browse-inner border-box field">
                    <div class="row category_list_home accessorize-list">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-3 f-box">
                                    <a href="<?= base_url() ?>browse/<?= $umbrella_name ?>" title="<?= $umbrella_name ?>"><?= $umbrella_name ?></a>
                                </div>
                                <?php foreach ($results as $results) : ?>
                                    <?php if ($results->is_result_umbrella != 1) : ?>
                                        <div class="col-sm-3 f-box">
                                            <a href="<?= base_url('browse/') . strtolower($results->umbrella) ?>/<?= strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->title ?></a>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-3 f-box">
                                            <a href="<?= base_url('browse/') . strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->title ?></a>
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
                <div id="myCarouselB" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php $media_box_b_index = 0; ?>
                        <?php foreach ($media_box_b as $banner) : ?>
                            <div class="<?= ($media_box_b_index == 0 ?  "carousel-item active" : "carousel-item") ?>" data-imageid="<?= $banner['imageid'] ?>" data-interval="<?= $banner['duration'] ?>">
                                <a href='<?= site_url("redirect/link/id/" . $banner['imageid']) ?>' target='_blank' title='<?= $banner['title'] ?>'>
                                    <img class="responsive" src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" />
                                </a>
                            </div>
                            <?php $media_box_b_index++; ?>
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

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>