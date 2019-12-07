<?php

// Set DocType and declare HTML protocol
$this->load->view('templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('templates/head');

// Start body element
$this->load->view('templates/startbody');

?>

<div class="top-inner">
	<div class="logo-result">
         <a href="<?=site_url();?>"><img src="<?=site_url(ASSETS);?>/style/images/logo-result.png" alt="" /></a>
    </div>
	<div class="top-inner-right-result">
	    <div class="search-box-top">
        <form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
                        <input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
	                    <div class="relative">
		                    <button class="search-btn" border="0" onclick="searchBtn()" type="submit">
	                    </div>
                    </form>
		</div>
        <div class="result-btn-div">
            <a class="btn-cat" href="<?=site_url();?>browse" style="float: left;">&nbsp;</a>
        </div>
    </div>
    <div id="main" role="main">
        <section class="slider">
            <div class="flexslider" style="background: none repeat scroll 0 0 #fff;border: -px solid #97afb1;border-radius: 6px;">
              <div id="myCarouselA" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                  <?php $media_box_a_index = 0; ?>
                  <?php foreach($media_box_a as $banner) : ?>
										<div class="<?php echo ($media_box_a_index == 0 ?  "carousel-item active" : "carousel-item"); ?>" id="bannerA" data-imageid="<?= $banner['imageid']; ?>" data-interval="<?= $banner['duration']; ?>">
											<a href='<?= site_url("redirect/link/id/".$banner['imageid']); ?>'  target='_blank' title='<?= $banner['title']; ?>'>
												<img src="<?= $banner['image']; ?>" alt="<?= $banner['description']; ?>" />
											</a>
										</div>
                    <?php $media_box_a_index++; ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
        </section>
    </div>
</div>
  <div class='result-btn-area-blue'>
    <div class='related'>
        <?=ucfirst($umbrella_name);?>
    </div>
    <ul>
     	<?php $count = 0;?>
        <?php foreach ($fields as $index => $field): ?>
        <?php $count++;?>
            <?php if ($index == 10) break; ?>
            <?php $ft = $field->title;?>
            <li class='category_list_home'>
                <?=anchor("browse/" . strtolower($umbrella_name) . "/" . strtolower($ft), "<span class='nobgimage'>" . ucfirst($ft) . "</span>", array('title' => $ft, 'rel' => 'noindex,nofollow'));?>
            </li>
        <?php endforeach;?>
    </ul>
</div>
<div class="banner-container-bottom" style="text-align:center;">
  <section>
		<div id="myCarouselU" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner">
        <?php $media_box_u_index = 0; ?>
        <?php foreach($media_box_u as $banner) : ?>
					<div class="<?php echo ($media_box_u_index == 0 ?  "carousel-item active" : "carousel-item"); ?>" data-imageid="<?= $banner['imageid']; ?>" data-interval="<?= $banner['duration']; ?>">
              <?php if ( strcasecmp($banner['mediaurl'], '#') == 0 ) : ?>
								  <a href='<?= site_url("redirect/link/id/".$banner['imageid']); ?>'  target='_blank' title='<?= $banner['title']; ?>'>
  							 		<img src="<?= $banner['image']; ?>" alt="<?= $banner['description']; ?>" />
								  </a>
  						 <?php else : ?>
                 <iframe id="ytplayer" width="600" height="300" src="https://www.youtube.com/embed/<?= $banner['mediaurl']; ?>?rel=0&modestbranding=1&autohide=1&mute=0&showinfo=0&controls=0&autoplay=1" frameborder="0" allow="autoplay; encrypted-media;"></iframe>
								 <!-- <div id="P1" class="player"
								 		 data-property="{videoURL:'<?= $banner['mediaurl']; ?>',containment:'self',autoPlay:true,loop:true,useOnMobile:true,showControls:false,optimizeDisplay:false}">
								 </div> -->
            	<?php endif; ?>
					</div>
          <?php $media_box_u_index++; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</div>

<script>
	$(function(){
		$("#P1").YTPlayer();
	});

</script>

<script src="<?=base_url();?>assets/js/jquery.mb.YTPlayer.js"></script>
<script src="<?=base_url();?>assets/js/apikey.js"></script>

<?php

// Load default footer.
$this->load->view('templates/footer');

// Close body and html elements.
$this->load->view('templates/closepage');

?>
