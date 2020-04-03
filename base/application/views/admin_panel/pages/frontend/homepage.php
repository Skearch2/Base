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
  <div class="row">
    <div class="col-xl-9 col-lg-8">
      <div class="m-portlet m-portlet--full-height m-portlet--tabs m-portlet--unair">
        <div class="tab-content">
          <div class="tab-pane active" id="m_user_profile_tab_1">
            <div class="m-form m-form--fit m-form--label-align-right">
              <div class="m-portlet__body">
                <div class="form-group m-form__group m--margin-top-10 m--show">
                  <?php if ($this->session->flashdata('success') === 1) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                        Homepage results has been updated.
                      </div>
                    </div>
                  <?php elseif ($this->session->flashdata('success') === 0) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                        Unable to update homepage results.
                      </div>
                    </div>
                  <?php endif ?>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Choose Hompage Results</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Drag item from the first list to the second list</label>
                  <div class="col-5">
                    <div>
                      <h5>Featured Results</h5>
                      <ul id="featuredList" class="connectedSortable">
                        <?php $index = 0; ?>
                        <?php foreach ($featured_results as $f_result) : ?>
                          <?php $flag = true; // check to see if the featured result is already in the homepage result                           
                          ?>
                          <?php foreach ($homepage_results as $h_result) : ?>
                            <?php if ($f_result->id == $h_result->result_id && $f_result->is_umbrella == $h_result->is_result_umbrella) $flag = false; ?>
                          <?php endforeach ?>
                          <?php if ($flag) : ?>
                            <li class="<?= ($f_result->is_umbrella) ? 'btn btn-outline-brand m-btn m-btn--air m-btn--custom' : 'btn btn-secondary m-btn m-btn--air m-btn--custom' ?>"><?= $f_result->title ?>
                              <input type="hidden" name=item[<?= $index ?>][result_id] value="<?= $f_result->id ?>">
                              <input type="hidden" name=item[<?= $index ?>][is_result_umbrella] value="<?= $f_result->is_umbrella ?>">
                            </li>
                            <?php $index++; ?>
                          <?php endif ?>
                        <?php endforeach ?>
                      </ul>
                    </div>

                    <form class="m-form m-form--fit m-form--label-align-right" role="form" method="POST">
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                      <div>
                        <h5>Homepage Results</h5>
                        <ul id="homepageList" class="connectedSortable">
                          <?php foreach ($homepage_results as $h_result) : ?>
                            <?php if ($h_result->result_id == 0) : ?>
                              <li class='btn btn-metal m-btn m-btn--air m-btn--custom' ondblclick='$(this).remove();' title='Double click to remove'>
                              <?php else : ?>
                              <li class="<?= ($h_result->is_result_umbrella) ? 'btn btn-outline-brand m-btn m-btn--air m-btn--custom' : 'btn btn-secondary m-btn m-btn--air m-btn--custom' ?>"><?= $h_result->title ?>
                              <?php endif ?>
                              <input type="hidden" name=item[<?= $index ?>][result_id] value='<?= $h_result->result_id ?>'>
                              <input type="hidden" name=item[<?= $index ?>][is_result_umbrella] value='<?= $h_result->is_result_umbrella ?>'>
                              </li>
                              <?php $index++; ?>
                            <?php endforeach ?>
                        </ul>
                      </div>
                  </div>
                  <div align="right"><input onclick="addBlank(index);" class="btn btn-brand m-btn m-btn--air" type="button" value="Add Blank Tab"></div>
                </div>
              </div>
              <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                  <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-7">
                      <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>&nbsp;&nbsp;
                    </div>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
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

  // initialize drag and drop
  $(function() {
    $("#featuredList, #homepageList").sortable({
      connectWith: ".connectedSortable",
      dropOnEmpty: true,
      cursor: "move",
    }).disableSelection();

    $("#homepageList").on("sortreceive", function(event, ui) {
      if ($("#homepageList li").length > limit) {
        $(ui.sender).sortable('cancel');
        toastr.warning("Cannot add more than " + limit + " items.")
      }
    });
  });

  // index to track of results in the list
  var index = <?= $index ?>

  // add blank tab to the homepage result list
  function addBlank(val) {
    if ($("#homepageList li").length < limit) {
      $("#homepageList").append(
        "<li class='btn btn-metal m-btn m-btn--air m-btn--custom' title='Double click to remove' ondblclick='$(this).remove();'>\
       <input type='hidden' name='item[" + val + "][result_id]' value='0'> \
       <input type='hidden' name='item[" + val + "][is_result_umbrella]' value='0'></li>"
      );
      index++;
    } else {
      toastr.warning("Cannot add more than " + limit + " items.")
    }
  }
</script>

<!-- Sidemenu class -->
<script>
  $("#menu-frontend").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-frontend-homepage_items").addClass("m-menu__item  m-menu__item--active");
</script>