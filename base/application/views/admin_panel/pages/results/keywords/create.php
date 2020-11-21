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

<div class="m-content">
  <div class="row">
    <div class="col-xl-9 col-lg-8">
      <div class="m-portlet m-portlet--full-height m-portlet--tabs m-portlet--unair">
        <div class="tab-content">
          <div class="tab-pane active" id="m_user_profile_tab_1">
            <form class="m-form m-form--fit m-form--label-align-right" method="POST">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
              <div class="m-portlet__body">
                <div class="form-group m-form__group m--margin-top-10 m--show">
                  <?php if ($this->session->flashdata('create_success') === 1) : ?>
                    <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        The keyword(s) have been created.
                      </div>
                    </div>
                  <?php elseif ($this->session->flashdata('create_success') === 0) : ?>
                    <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        Unable to create keyword(s).
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        <p class="flaticon-danger"> Error:</p>
                        <?= validation_errors() ?>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Keyword Information</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Keyword(s)</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="keywords" data-role="tagsinput" value="<?= set_value('keywords') ?>">
                  </div>
                </div>
                <div class="m-form__group form-group row">
                  <label for="example-text-input" class="col-2 col-form-label">Link to</label>
                  <div class="col-9">
                    <div class="m-radio-inline">
                      <label class="m-radio">
                        <input type="radio" name="link_type" value="umbrella" <?= set_value('link_type') == 'umbrella' ? 'checked' : "" ?> onchange="listShow('umbrella')"> Umbrella
                        <span></span>
                      </label>
                      <label class="m-radio">
                        <input type="radio" name="link_type" value="field" <?= set_value('link_type') == 'field' ? 'checked' : "" ?> onchange="listShow('field')"> Field
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group m-form__group row" id="umbrella-list" style=<?= $link_type == 'umbrella' ? 'display:block' : 'display:none' ?>>
                  <label for="example-text-input" class="col-2 col-form-label"></label>
                  <div class="col-7">
                    <select class="form-control" name="umbrella_id">
                      <option value="">Select</option>
                      <?php foreach ($umbrellas as $umbrella) : ?>
                        <option value="<?= $umbrella->id ?>" <?= set_select("umbrella_id", $umbrella->id) ?>><?= $umbrella->title ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-group m-form__group row" id="field-list" style=<?= $link_type == 'field' ? 'display:block' : 'display:none' ?>>
                  <label for="example-text-input" class="col-2 col-form-label"></label>
                  <div class="col-7">
                    <select class="form-control" name="field_id">
                      <option value="">Select</option>
                      <?php foreach ($fields as $field) : ?>
                        <option value="<?= $field->id ?>" <?= set_select("field_id", $field->id) ?>><?= $field->title ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Enabled</label>
                  <div class="col-7">
                    <input type="hidden" name="status" value="0" <?= set_value('status') == 0 ? 'checked' : "" ?>>
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="status" value="1" <?= set_value('status', 1) == 1 ? 'checked' : "" ?>>
                        <span></span>
                      </label>
                    </span>
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

<!-- Sidemenu class -->
<script>
  $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-results-keywords").addClass("m-menu__item  m-menu__item--active");
</script>

<!--begin::Page Scripts -->

<script>
  // show umbrella or field list
  function listShow(type) {

    var listUmbrella = document.getElementById("umbrella-list");
    var listField = document.getElementById("field-list");

    if (type == 'umbrella') {

      listUmbrella.style.display = "block";
      listField.style.display = "none";

    } else if (type == 'field') {

      listUmbrella.style.display = "none";
      listField.style.display = "block";

    }
  }
</script>
<!--end::Page Scripts -->