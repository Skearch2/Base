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
      <div class="ads" id="media-box-a-sign" style="visibility:hidden">
        <p>Ad</p>
      </div>
      <div class="carousel-inner">
        <?php foreach ($media_box_a as $banner) : ?>
          <div class="carousel-item" data-imageid="<?= $banner['imageid'] ?>" data-interval="<?= $banner['duration'] ?>" data-ad-sign="<?= $banner['adsign'] ?>">
            <a href='<?= site_url("redirect/link/id/" . $banner['imageid']) ?>' target='_blank' title='<?= $banner['title'] ?>'>
              <img class="responsive" width="1000" height="110" src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" />
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
          <h3><?= ucfirst($umbrella_name); ?></h3>
        </div>
        <div class="middle-inner browse-inner border-box">
          <div class="row category_list_home accessorize-list">
            <?php foreach ($results as $results) : ?>
              <?php if (!$results->is_result_umbrella) : ?>
                <div class="col-sm-3 f-box">
                  <a href="<?= base_url('browse/') . strtolower($results->umbrella) ?>/<?= strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->title ?></a>
                </div>
              <?php else : ?>
                <div class="col-sm-3 f-box umbrella">
                  <a href="<?= base_url('browse/') . strtolower($results->title) ?>" class="btn btn-link" role="button"><?= $results->title ?></a>
                </div>
              <?php endif ?>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<!-- Media Box U -->
<section class="ad">
  <div class="container">
    <i id="speaker" class="fas fa-volume-mute" title="Unmute" onclick="toggleMute()"></i>
    <div id="myCarouselU" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="ads" id="media-box-u-sign" style="visibility:hidden">
        <p>Ad</p>
      </div>
      <div class="carousel-inner">
        <?php foreach ($media_box_u as $banner) : ?>
          <div class="carousel-item" data-imageid="<?= $banner['imageid'] ?>" data-interval="<?= $banner['duration'] ?>" data-ad-sign="<?= $banner['adsign'] ?>">
            <a href='<?= site_url("redirect/link/id/" . $banner['imageid']) ?>' target='_blank' title='<?= $banner['title'] ?>'>
              <?php $is_video = substr(strtolower($banner['image']), -3) == 'mp4' ? 1 : 0 ?>
              <?php if ($is_video) : ?>
                <video class="responsive" width="600" height="450" loop muted>
                  <source src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" type="video/mp4">
                  Unable to play video, incompatible browser.
                </video>
              <?php else : ?>
                <img class="responsive" width="600" height="450" src="<?= $banner['image'] ?>" alt="<?= $banner['description'] ?>" />
              <?php endif ?>
            </a>
          </div>
        <?php endforeach ?>
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
  // activate the carousel for media box A and U
  $('#myCarouselA').find('.carousel-item').first().addClass('active');
  $('#myCarouselU').find('.carousel-item').first().addClass('active');

  // update impressions on the banner in media box (for single media)
  if ($('#myCarouselA').find('.carousel-item').first().hasClass('active')) {
    imageid = $('#myCarouselA').find('.carousel-item').first().attr('data-imageid')
    $.get("<?= site_url("impression/image/id/"); ?>" + imageid, function() {});
  }

  if ($('#myCarouselU').find('.carousel-item').first().hasClass('active')) {
    imageid = $('#myCarouselU').find('.carousel-item').first().attr('data-imageid')
    $.get("<?= site_url("impression/image/id/"); ?>" + imageid, function() {});
  }

  // show ad sign on sponsered banner
  var isAd = $('#myCarouselA .carousel-item.active').data("ad-sign");
  if (isAd) {
    $('#media-box-a-sign').css('visibility', 'visible');
  } else {
    $('#media-box-a-sign').css('visibility', 'hidden');
  }

  var isAd = $('#myCarouselU .carousel-item.active').data("ad-sign");
  if (isAd) {
    $('#media-box-u-sign').css('visibility', 'visible');
  } else {
    $('#media-box-u-sign').css('visibility', 'hidden');
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

  $('#myCarouselU').on('slid.bs.carousel', function() {
    $(this).find('.carousel-item.active').each(function() {
      var isAd = $(this).data("ad-sign");
      if (isAd) {
        $('#media-box-u-sign').css('visibility', 'visible');
      } else {
        $('#media-box-u-sign').css('visibility', 'hidden');
      }
    });
  });

  // Video settings for carousel
  $('#myCarouselU').on('slid.bs.carousel', function() {
    $(this).find('.carousel-item.active video').each(function() {
      $('#speaker').show();
      this.play();
    });
  });
  $('#myCarouselU').on('slide.bs.carousel', function() {
    $(this).find('.carousel-item.active video').each(function() {
      $("#speaker").hide();
      this.pause();
      this.currentTime = 0;
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

<script src="<?= base_url(ASSETS); ?>/frontend/js/jquery.mb.YTPlayer.js"></script>
<script src="<?= base_url(ASSETS); ?>/frontend/js/apikey.js"></script>

<?php
// Close body and html elements.
$this->load->view('frontend/templates/closepage');
?>