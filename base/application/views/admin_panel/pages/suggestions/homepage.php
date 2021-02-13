<?php

// Set DocType and declare HTML protocol
$this->load->view('admin_panel/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('admin_panel/templates/head');

// Start body element
$this->load->view('admin_panel/templates/start_body');

// Start page section
$this->load->view('admin_panel/templates/start_page');

// Load header
$this->load->view('admin_panel/templates/header');

// Start page body
$this->load->view('admin_panel/templates/start_pagebody');

// Load sidemenu
$this->load->view('admin_panel/templates/sidemenu');

// Start inner body in a page body
$this->load->view('admin_panel/templates/start_innerbody');

// Load subheader in inner body
$this->load->view('admin_panel/templates/subheader');

?>

<link rel="stylesheet" href="/resources/demos/style.css">

<style>
  #featuredList,
  #homepageList {
    border: 1px solid #eee;
    width: 160px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
    max-height: 600px;
    overflow: auto
  }

  #featuredList li,
  #homepageList li {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1em;
    width: 130px;
  }
</style>

<div class="m-content">
  <div class="m-portlet__body">
    <?php if ($this->session->flashdata('success') === 1) : ?>
      <div class="m-form__content">
        <div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
          <div class="m-alert__icon">
            <i class="la la-check-circle"></i>
          </div>
          <div class="m-alert__text">
            The Field suggestion(s) has been updated.
          </div>
          <div class="m-alert__close">
            <button type="button" class="close" data-close="alert" aria-label="Close">
            </button>
          </div>
        </div>
      </div>
    <?php elseif ($this->session->flashdata('success') === 0) : ?>
      <div class="m-form__content">
        <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
          <div class="m-alert__icon">
            <i class="la la-times-circle"></i>
          </div>
          <div class="m-alert__text">
            Unable to update Field suggestion(s).
          </div>
          <div class="m-alert__close">
            <button type="button" class="close" data-close="alert" aria-label="Close">
            </button>
          </div>
        </div>
      </div>
    <?php elseif (validation_errors()) : ?>
      <div class="m-form__content">
        <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
          <div class="m-alert__icon">
            <i class="la la-warning"></i>
          </div>
          <div class="m-alert__text">
            <?= validation_errors() ?>
          </div>
          <div class="m-alert__close">
            <button type="button" class="close" data-close="alert" aria-label="Close">
            </button>
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
  <div class="row">
    <div class="col-xl-3">
      <div class="m-portlet m-portlet--full-height ">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                Featured Results
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet__body">
          <div class="m-widget4">
            <div class="m-widget4__item">
              <div class="m-widget4__info">
                <ul id="featuredList">
                  <?php $index = 0; ?>
                  <?php foreach ($featured_results as $f_result) : ?>
                    <?php $flag = true; // check to see if the featured result is already in the homepage result                           
                    ?>
                    <?php foreach ($homepage_results as $h_result) : ?>
                      <?php if ($f_result->id == $h_result->result_id && $f_result->is_umbrella == $h_result->is_result_umbrella) $flag = false; ?>
                    <?php endforeach ?>
                    <?php if ($flag) : ?>
                      <li ondblclick="moveToHomepageList($(this))" class="<?= ($f_result->is_umbrella) ? 'btn btn-outline-brand m-btn m-btn--air m-btn--custom' : 'btn btn-secondary m-btn m-btn--air m-btn--custom' ?>" title="Double-click to move"><?= $f_result->title ?>
                        <input type="hidden" name=item[<?= $index ?>][result_id] value="<?= $f_result->id ?>">
                        <input type="hidden" name=item[<?= $index ?>][is_result_umbrella] value="<?= $f_result->is_umbrella ?>">
                      </li>
                      <?php $index++; ?>
                    <?php endif ?>
                  <?php endforeach ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4">
      <div class="m-portlet m-portlet--full-height ">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                Homepage Suggestions
              </h3>
            </div>
          </div>
          <div class="m-portlet__head-tools">
            <input onclick="addBlank(index);" class="btn btn-brand m-btn m-btn--air" type="button" value="Add Blank Tab">
          </div>
        </div>
        <form class="m-form" role="form" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="m-portlet__body">
            <div class="m-widget4">
              <div class="m-widget4__item">
                <div class="m-widget4__info">
                  <ul id="homepageList">
                    <?php foreach ($homepage_results as $h_result) : ?>
                      <?php if ($h_result->result_id == 0) : ?>
                        <li class='btn btn-metal m-btn m-btn--air m-btn--custom' ondblclick='$(this).remove();' title='Double-click to remove'>
                        <?php else : ?>
                        <li class="<?= ($h_result->is_result_umbrella) ? 'btn btn-outline-brand m-btn m-btn--air m-btn--custom' : 'btn btn-secondary m-btn m-btn--air m-btn--custom' ?>" ondblclick='moveToFeaturedList($(this))' title='Double-click to move'><?= $h_result->title ?>
                        <?php endif ?>
                        <input type="hidden" name=item[<?= $index ?>][result_id] value='<?= $h_result->result_id ?>'>
                        <input type="hidden" name=item[<?= $index ?>][is_result_umbrella] value='<?= $h_result->is_result_umbrella ?>'>
                        </li>
                        <?php $index++; ?>
                      <?php endforeach ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
              <div class="row">
                <div class="col-2">
                </div>
                <div class="col-7">
                  <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php

// End page body
$this->load->view('admin_panel/templates/end_pagebody');

// Load footer
$this->load->view('admin_panel/templates/footer');

// End page section
$this->load->view('admin_panel/templates/end_page');

// Load quick sidebar
$this->load->view('admin_panel/templates/quick_sidebar');

// Load scrolltop button
$this->load->view('admin_panel/templates/scrolltop');

// Close body and html (contains some javascripts links)
$this->load->view('admin_panel/templates/close_html');

?>

<script>
  // maximum items allowed in homepage list
  var limit = 15;

  // make homepage list sortable
  $(function() {
    $("#homepageList").sortable({
      containment: "parent"
    }).disableSelection();
  });

  // move item to homepage list
  function moveToHomepageList(val) {
    if ($("#homepageList li").length < limit) {
      $(val).attr("ondblclick", "moveToFeaturedList($(this))");
      $("#homepageList").append(val);
    } else {
      toastr.warning("Cannot add more than " + limit + " items.")
    }
  }

  // move item to featured list
  function moveToFeaturedList(val) {
    $(val).attr("ondblclick", "moveToHomepageList($(this))");
    $("#featuredList").append(val);
    sortUnorderedList("featuredList");
  }

  // index to track of results in the list
  var index = <?= $index ?>

  // add blank tab to the homepage result list
  function addBlank(val) {
    if ($("#homepageList li").length < limit) {
      $("#homepageList").append(
        "<li class='btn btn-metal m-btn m-btn--air m-btn--custom' ondblclick='$(this).remove();' title='Double-click to remove'>\
       <input type='hidden' name='item[" + val + "][result_id]' value='0'> \
       <input type='hidden' name='item[" + val + "][is_result_umbrella]' value='0'></li>"
      );
      index++;
    } else {
      toastr.warning("Cannot add more than " + limit + " items.")
    }
  }

  // helper method to sort unordered list
  function sortUnorderedList(ul) {
    if (typeof ul == "string")
      ul = document.getElementById(ul);

    // Get the list items and setup an array for sorting
    var lis = ul.getElementsByTagName("LI");
    var vals = [];

    // Populate the array
    for (var i = 0, l = lis.length; i < l; i++)
      vals.push(lis[i].innerHTML);

    // Sort it
    vals.sort();

    // Change the list on the page
    for (var i = 0, l = lis.length; i < l; i++)
      lis[i].innerHTML = vals[i];
  }
</script>

<!-- Sidemenu class -->
<script>
  $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-suggestions").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#homepage").addClass("m-menu__item  m-menu__item--active");
</script>