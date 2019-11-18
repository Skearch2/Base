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
              <div id="myCarouselVA" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                  <?php $media_box_va_index = 0; ?>
                  <?php foreach($media_box_va as $banner) : ?>
										<div class="<?php echo ($media_box_va_index == 0 ?  "carousel-item active" : "carousel-item"); ?>" data-imageid="<?= $banner['imageid']; ?>" data-interval="<?= $banner['duration']; ?>">
											<a href='<?= site_url("redirect/link/id/".$banner['imageid']); ?>'  target='_blank' title='<?= $banner['title']; ?>'>
												<img src="<?= $banner['image']; ?>" alt="<?= $banner['description']; ?>" />
											</a>
										</div>
                    <?php $media_box_va_index++; ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
        </section>
    </div>
</div>
        <!-- Display All Umbrellas and its fields -->

<div class='midd-browse-field'>
    <div class='browse-fields'>
        <div class='browse-fields-inn'>
            <div class="thead"><h3>Browse All Fields</h3>

                <div class='right-btn'>
                    <?php
                    $order = $this->uri->segment(2);
                    if(!isset($order))
                        echo anchor('browse/desc', 'Z - A', array('title' => "Display fields in descending order."));
                    else
                        echo anchor('browse', 'A - Z', array('title' => "Display fields in ascending order."));
                    ?>
                </div>
            </div>

            <div class='middle-inner browse-inner'>
                <div class='result-btn-area-all'>

                    <ul class='category_list_home accessorize-list'>
                        <!--	Get user top level categories from 'skearch_categories' -->

                        <?php foreach ($umbrellas as $umbrella => $subcategories): ?>
                            <?php $t = $umbrella;?>
                            <li>
                                <?php echo anchor("browse/" . $t, ucfirst($t) . "<i class='fa fa-angle-down'></i>", array('title' => ucfirst($t))); ?>
                                    <div class='acz-sublist'>

                                    <ul>
                                    <?php foreach ($subcategories as $subcategory): ?>
                                        <?php $ct = $subcategory->title;?>
                                        <li>
                                            <?php echo anchor("browse/" . strtolower($t) . "/" . strtolower($ct), $ct, array('title' => $ct)); ?>
                                        </li>
                                    <?php endforeach;?>
                                    </ul>
                                </div>
                            </li>
                        <?php endforeach;?>

                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
</div>

<?php

// Load default footer.
$this->load->view('templates/footer');

// Close body and html elements.
$this->load->view('templates/closepage');

?>
