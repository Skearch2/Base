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

<!-- Media Box VA -->
<section class="ad">
    <div class="container">
        <div id="mediabox-va" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="ads" id="media-box-va-sign" style="visibility:hidden">
                <p>Ad</p>
            </div>
            <div class="carousel-inner">
                <?php foreach ($banner_va_ads as $ad) : ?>
                    <div class="carousel-item" data-adid="<?= $ad->id ?>" data-interval="<?= $ad->duration ?>" data-ad-sign="<?= $ad->has_sign ?>">
                        <a href='<?= site_url("redirect/ad/id/" . $ad->id) ?>' target='_blank' title='<?= $ad->title ?>'>
                            <img class="responsive" width="1000" height="110" src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" />
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>

<!-- Display All Umbrellas and its fields -->
<section class="field-main">
    <div class="container">
        <div class="row">
            <div class="main-box">
                <div class="box">
                    <h3>Browse all Fields</h3>
                    <?php if (!empty($this->uri->segment(2))) : ?>
                        <div class="right-btn ml-auto"> <a href="<?= BASE_URL ?>browse" id="sort-btn">A - Z</a>
                        </div>
                    <?php else : ?>
                        <div class="right-btn ml-auto"> <a href="<?= BASE_URL ?>browse/desc" id="sort-btn">Z - A</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="middle-inner browse-inner">
                    <div class="row category_list_home accessorize-list" id="GFG_UP">
                        <?php foreach ($umbrellas as $umbrella => $fields) : ?>
                            <div class="col-sm-3 f-box">
                                <a href="<?= BASE_URL ?>browse/<?= $umbrella ?>" title="<?= $umbrella ?>"><?= $umbrella ?><i class="fa fa-angle-down"></i>
                                </a>
                                <div class="acz-sublist">
                                    <ul>
                                        <?php foreach ($fields as $field) : ?>
                                            <li> <a href="<?= BASE_URL ?>browse/<?= $umbrella ?>/<?= $field->title ?>" title="<?= $field->title ?>"><?= $field->title ?></a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
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
    // activate the carousel for media box VA
    $('#mediabox-va').find('.carousel-item').first().addClass('active');

    // update impressions on the banner in media box (for single media)
    if ($('#mediabox-va').find('.carousel-item').first().hasClass('active')) {
        adId = $('#mediabox-va').find('.carousel-item').first().attr('data-adid')
        $.get("<?= site_url("update/impression/ad/id/") ?>" + adId, function() {});
    }

    // show ad sign on sponsered banner
    var isAd = $('.carousel-item.active').data("ad-sign");
    if (isAd) {
        $('#media-box-va-sign').css('visibility', 'visible');
    } else {
        $('#media-box-va-sign').css('visibility', 'hidden');
    }

    $('#mediabox-va').on('slid.bs.carousel', function() {
        $(this).find('.carousel-item.active').each(function() {
            var isAd = $(this).data("ad-sign");
            if (isAd) {
                $('#media-box-va-sign').css('visibility', 'visible');
            } else {
                $('#media-box-va-sign').css('visibility', 'hidden');
            }
        });
    });
</script>

<?php

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>