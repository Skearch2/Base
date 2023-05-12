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
    <i id="speaker" class="fas fa-volume-mute" title="Unmute" onclick="toggleMute()"></i>
    <div id="myCarouselA" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="ads" id="media-box-a-sign" style="visibility:hidden">
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
          <h3><?= ucfirst($umbrella_name); ?></h3>
        </div>
        <div class="middle-inner browse-inner border-box">
          <div class="row category_list_home accessorize-list">
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
        <?php foreach ($banner_u_ads as $ad) : ?>
          <div class="carousel-item" data-adid="<?= $ad->id ?>" data-interval="<?= $ad->duration ?>" data-ad-sign="<?= $ad->has_sign ?>">
            <?php if (empty($ad->url)) : ?>
              <a href='javascript:void(0)' title='<?= $ad->title ?>'>
              <?php else : ?>
                <a href='<?= site_url("redirect/ad/id/" . $ad->id) ?>' target='_blank' title='<?= $ad->title ?>'>
                <?php endif ?>
                <?php $is_video = substr(strtolower($ad->media), -3) == 'mp4' ? 1 : 0 ?>
                <?php if ($is_video) : ?>
                  <video class="responsive" width="600" height="450" loop muted>
                    <source src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" type="video/mp4">
                    Unable to play video, incompatible browser.
                  </video>
                <?php else : ?>
                  <img class="responsive" width="600" height="450" src="<?= site_url("base/media/$ad->media") ?>" alt="<?= $ad->title ?>" />
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
    adId = $('#myCarouselA').find('.carousel-item').first().attr('data-adid')
    $.get("<?= site_url("update/impression/ad/id/") ?>" + adId, function() {});
  }

  if ($('#myCarouselU').find('.carousel-item').first().hasClass('active')) {
    adId = $('#myCarouselU').find('.carousel-item').first().attr('data-adid')
    $.get("<?= site_url("update/impression/ad/id/") ?>" + adId, function() {});
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

<?php
// Close body and html elements.
$this->load->view('frontend/templates/closepage');
?>