<?php

// Set DocType and declare HTML protocol
$this->load->view('templates/starthtml');

// Load default head (metadata & linking).
$this->load->view('templates/head');

// Start body element
$this->load->view('templates/startbody');

?>

<script type="text/javascript">
	var t;

	var start = $('#myCarouselB').find('.active').attr('data-interval');
	t = setTimeout("$('#myCarouselB').carousel({interval: 1000});", start-1000);

	$('#myCarouselB').on('slid.bs.carousel', function () {
			 clearTimeout(t);
			 var duration = $(this).find('.active').attr('data-interval');

			 $('#myCarouselB').carousel('pause');
			 t = setTimeout("$('#myCarouselB').carousel();", duration-1000);
	})
</script>

<script>
	$(document).ready(function(){
	    $.fn.showResults = function(value) {
			  $.ajaxSetup({ cache: false });
			  var uri = "<?=site_url('browse/get_field_results/' . $field_id . '/');?>" + value;
	        $.getJSON( uri, function( response ) {
				$(".result-listing").html("");
				var items = [];
				$.each( response, function( key, val ) {
						items.push("\
						<li>\
							<div>"+(++key)+". <a href='"+(val.www)+"' title='"+(val.title)+"' target='_blank'>"+(val.title)+"</a></div>\
							<p>"+(val.description_short)+"</br>\
							<span><a href='"+(val.www)+"' title='"+(val.title)+"' target='_blank'>"+(val.display_url)+"</a>\</span>\
              </p>\
						</li>\
						");
				});
				$( "<ul/>", {
					"class": "result-listing",
	            "tabindex": 0,
					html: items.join( "" )
				}).appendTo( "#container_vertical" );
			});
	   }

        $("#button_shuffle").click(function(){
            $.fn.showResults("random");
        });

        $("#priority_logo").click(function(){
            $.fn.showResults("priority");
        });

        $("#button_order").click(function(){
            var order = $(this).attr('value');
            if (order === 'asc') {
                $("#button_order").removeClass('btn-a2z').addClass('btn-z2a');
                $("#button_order").attr('value','desc');
                $("#button_order").html("Z-A")
                $("#button_order").prop('title', 'Display results in descending order');
            }
            else if (order === 'desc') {
                $("#button_order").removeClass('btn-z2a').addClass('btn-a2z');
                $("#button_order").attr('value','asc');
                $("#button_order").html("A-Z");
                $("#button_order").prop('title', 'Display results in ascending order');
            }
            $.fn.showResults(order);
        });

        $.fn.showResults("priority");

	});
</script>

<div class="top-inner">
	<div class="logo-result">
         <a href="<?=site_url();?>"><img src="<?=site_url(ASSETS);?>/style/images/logo-result.png" alt="" /></a>
    </div>
	<div class="top-inner-right-result">
	    <div class="search-box-top">
        <form action="javascript:void(0)" onsubmit="ajaxSearch(document.getElementById('ajaxsearch').value)">
                        <input id="ajaxsearch" type="text" size="64" class="google-input" placeholder="Enter Keywords...">
	                    <div class="relative">
		                    <button class="search-btn" border="0" onclick="searchBtn()" type="submit"/>
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
							<div id="myCarouselA" class="carousel slide carousel-fade">
                <div class="carousel-inner">
                  <?php $media_box_a_index = 0; ?>
                  <?php foreach($media_box_a as $banner) : ?>
										<div class="<?php echo ($media_box_a_index == 0 ?  "carousel-item active" : "carousel-item"); ?>" data-imageid="<?= $banner['imageid']; ?>" data-interval="<?= $banner['duration']; ?>">
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
                    <div class='middle-inner'>
												<div class='feed-info-hd-blue'> <?=ucwords($field_name);?></div>
                    <div class='result-btn-area-blue-field singlerows'>
                        <div class='related'>Related Fields</div>
                        <!--  Need to be inside related field block always on the upper right corner -->
                       <div class="rel-links">
                        <ul class='related_fields'>

                            <!-- Loop through subcategories and get all related fields -->

                            <?php
                            if(!$suggest_fields) echo "<li>Suggestions not set</li>";
                            else {
                                foreach ($suggest_fields as $field):?>
                                    <?php
                                        if (!strcasecmp($field->suggest_field_title, $field_name)) {
                                            continue;
                                        }

                                        $ft = $field->suggest_field_title;
                                        ?>
                                    <li class='category_list_home'>
                                    <?php echo anchor("browse/" . strtolower($umbrella_name) . "/" . strtolower($ft), "<span>" . ucfirst($ft) . "</span>", array('title' => $ft, 'rel' => 'noindex,nofollow'));?>
                                    </li>

                            <?php endforeach; }?>

                        </ul>
						<div class="um-link">
									<?php echo anchor("browse/" . strtolower($umbrella_name) . "/", "<span>" . ucfirst($umbrella_name) . "</span>", array('title' => $umbrella_name, 'rel' => 'noindex,nofollow'));?>
									</div>
									</div>

                    </div>

                    <div class='midd-result-con singlerows'>
					<div class="row mp0">

                        <aside class='midd-result-left col-md-8'>
                        <div class='skearch-result-blue'>
                            <div class="rhead">
																<div class="row">
			                            <div class='col-md-6 skearch-result-hd-blue'>
			                                <a title = "Display results in priority order" style="cursor: pointer" id="priority_logo"><img src='<?=site_url(ASSETS);?>/style/images/logo-result.png' width="100"></a>
			                            </div>
																	<div class='col-md-6 result-btn-right-blue'>
			                                <a id= 'button_order' value='asc' title='Display results in ascending order' class='btn-a2z'>A-Z</a>
																			<a id='button_shuffle' title='Display results in shuffling order' class='btn-shuffle'>Shuffle</a>
					                        </div>
																</div>
													</div>
                            <div class='result-listing-blue'>
                                <div id='container_vertical'>
                                </div>
                            </div>
                        </div>
						 </aside>
						  <aside class="result-right col-md-4">
                            <div id="feature-right-banner">
                                <div style="text-align:center;" id="feature_side_slideshow" class="horiz-scroll-right banner-container-right">
                                    <section class="slider_right">
                                        <div class="flexslider_right">
																					<div id="myCarouselB" class="carousel slide carousel-fade">
														                <div class="carousel-inner">
														                  <?php $media_box_b_index = 0; ?>
														                  <?php foreach($media_box_b as $banner) : ?>
																								<div class="<?php echo ($media_box_b_index == 0 ?  "carousel-item active" : "carousel-item"); ?>" data-imageid="<?= $banner['imageid']; ?>" data-interval="<?= $banner['duration']; ?>">
																									<a href='<?= site_url("redirect/link/id/".$banner['imageid']); ?>'  target='_blank' title='<?= $banner['title']; ?>'>
																										<img src="<?= $banner['image']; ?>" alt="<?= $banner['description']; ?>" />
																									</a>
																								</div>
														                    <?php $media_box_b_index++; ?>
														                  <?php endforeach; ?>
														                </div>
														              </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </aside>
						</div>
                        </div>


                </div>
<?php

// Load default footer.
$this->load->view('templates/footer');

// Close body and html elements.
$this->load->view('templates/closepage');

?>
