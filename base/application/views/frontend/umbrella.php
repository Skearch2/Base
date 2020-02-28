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
          <h3><?= ucfirst($umbrella_name); ?></h3>
        </div>
        <div class="middle-inner browse-inner border-box">
          <div class="row category_list_home accessorize-list">
            <?php $count = 0 ?>
            <?php foreach ($fields as $index => $field) : ?>
              <?php $count++ ?>
              <?php if ($index == 10) break ?>
              <div class="col-sm-4 f-box">
                <a href="<?= BASE_URL ?>browse/<?= $umbrella_name ?>/<?= $field->title ?>" title="<?= $field->title ?>"><?= $field->title ?></a>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- Media Box U -->
<section class="ad">
  <div class="container">
    <div id="myCarouselU" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner">
        <?php $media_box_u_index = 0; ?>
        <?php foreach ($media_box_u as $banner) : ?>
          <div class="<?= ($media_box_u_index == 0 ?  "carousel-item active" : "carousel-item") ?>" data-imageid="<?= $banner['imageid'] ?>" data-interval="<?= $banner['duration'] ?>">
            <?php if (strcasecmp($banner['mediaurl'], '#') == 0) : ?>
              <a href='<?= site_url("redirect/link/id/" . $banner['imageid']) ?>' target='_blank' title='<?= $banner['title'] ?>'>
                <img class="responsive" src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" />
              </a>
            <?php else : ?>
              <iframe id="ytplayer" width="600" height="300" src="https://www.youtube.com/embed/<?= $banner['mediaurl']; ?>?rel=0&modestbranding=1&autohide=1&mute=0&showinfo=0&controls=0&autoplay=1" frameborder="0" allow="autoplay; encrypted-media;"></iframe>
              <!-- <div id="P1" class="player"
								 		 data-property="{videoURL:'<?= $banner['mediaurl']; ?>',containment:'self',autoPlay:true,loop:true,useOnMobile:true,showControls:false,optimizeDisplay:false}">
							 </div> -->
            <?php endif ?>
          </div>
          <?php $media_box_u_index++; ?>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</section>

<script>
  // $(function() {
  //   $("#P1").YTPlayer();
  // });
</script>

<script src="<?= base_url(ASSETS); ?>/frontend/js/jquery.mb.YTPlayer.js"></script>
<script src="<?= base_url(ASSETS); ?>/frontend/js/apikey.js"></script>

<?php

// Load default footer.
$this->load->view('frontend/templates/footer');

// Close body and html elements.
$this->load->view('frontend/templates/closepage');

?>