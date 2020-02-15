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
            <div class="carousel-inner">
                <?php $media_box_va_index = 0; ?>
                <?php foreach ($media_box_va as $banner) : ?>
                    <div class="<?= ($media_box_va_index == 0 ?  "carousel-item active" : "carousel-item") ?>" data-imageid="<?= $banner['imageid'] ?>" data-interval="<?= $banner['duration'] ?>">
                        <a href='<?= site_url("redirect/link/id/" . $banner['imageid']) ?>' target='_blank' title='<?= $banner['title'] ?>'>
                            <img class="responsive" src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" />
                        </a>
                    </div>
                    <?php $media_box_va_index++; ?>
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
                    <h3>Browse All Fields</h3>
                    <?php if (!empty($this->uri->segment(2))) : ?>
                        <div class="right-btn pull-right"> <a href="<?= BASE_URL ?>browse" id="sort-btn">A - Z</a>
                        </div>
                    <?php else : ?>
                        <div class="right-btn pull-right"> <a href="<?= BASE_URL ?>browse/desc" id="sort-btn">Z - A</a>
                        </div>
                    <?php endif ?>
                </div>
                <div class="middle-inner browse-inner">
                    <div class="row category_list_home accessorize-list" id="GFG_UP">
                        <?php foreach ($umbrellas as $umbrella => $fields) : ?>
                            <div class="col-sm-4 f-box">
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

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>