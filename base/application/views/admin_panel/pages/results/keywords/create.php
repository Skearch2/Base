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
            <form class="m-form m-form--fit m-form--label-align-right" id="m_form" method="POST">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
              <div class="m-portlet__body">
                <?php if ($this->session->flashdata('create_success') === 1) : ?>
                  <div class="m-form__content">
                    <div class="m-alert m-alert--icon alert alert-success m--show" role="alert">
                      <div class="m-alert__icon">
                        <i class="la la-check-circle"></i>
                      </div>
                      <div class="m-alert__text">
                        The keyword(s) have been added.
                      </div>
                      <div class="m-alert__close">
                        <button type="button" class="close" data-close="alert" aria-label="Close">
                        </button>
                      </div>
                    </div>
                  </div>
                <?php elseif ($this->session->flashdata('create_success') === 0) : ?>
                  <div class="m-form__content">
                    <div class="m-alert m-alert--icon alert alert-danger m--show" role="alert">
                      <div class="m-alert__icon">
                        <i class="la la-times-circle"></i>
                      </div>
                      <div class="m-alert__text">
                        Unable to add keyword(s).
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
                <div class="m-form__content">
                  <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_msg">
                    <div class="m-alert__icon">
                      <i class="la la-warning"></i>
                    </div>
                    <div class="m-alert__text">
                      There are some errors found in the form, please check and try submitting again!
                    </div>
                    <div class="m-alert__close">
                      <button type="button" class="close" data-close="alert" aria-label="Close">
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Keyword Information</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Keyword(s) *</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" id="keywords" name="keywords" data-role="tagsinput" value="<?= set_value('keywords') ?>">
                  </div>
                </div>
                <input type="hidden" id="keywords_field_input_check" value="">
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Link to *</label>
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
                <div class="form-group m-form__group row" id="umbrella-list" style=<?= $link_type == 'umbrella' ?: 'display:none' ?>>
                  <label for="example-text-input" class="col-2 col-form-label">Umbrella *</label>
                  <div class="col-7">
                    <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="umbrella_id" id="umbrella_id">
                      <option value="" <?= set_select('umbrella_id', '', TRUE) ?>>Select</option>
                      <?php foreach ($umbrellas as $umbrella) : ?>
                        <option value="<?= $umbrella->id ?>" <?= set_select("umbrella_id", $umbrella->id) ?>><?= $umbrella->title ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-group m-form__group row" id="field-list" style=<?= $link_type == 'field' ?: 'display:none' ?>>
                  <label for="example-text-input" class="col-2 col-form-label">Field *</label>
                  <div class="col-7">
                    <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="field_id" id="field_id">
                      <option value="" <?= set_select('field_id', '', TRUE) ?>>Select</option>
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
                    <div class="col-3">
                      <small>* Indicates required field</small>
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

<!--begin::Page Scripts -->

<script>
  var FormControls = {
    init: function() {
      $("#m_form").validate({
        rules: {
          keywords: {
            required: '#keywords:blank'
          },
          link_type: {
            required: 1
          },
          umbrella_id: {
            required: function(element) {
              return $("#field_id").val() == "";
            }
          },
          field_id: {
            required: function(element) {
              return $("#umbrella_id").val() == "";
            }
          }
        },
        invalidHandler: function(e, r) {
          $("#m_form_msg").removeClass("m--hide").show(), mUtil.scrollTop();
        },
        submitHandler: function(e) {
          form.submit();
        },
      });
    }
  };

  // hide option which has no value
  $('option[value=""]').hide().parent().selectpicker('refresh');

  $(document).ready(function() {
    FormControls.init();
  });

  // show umbrella or field list
  function listShow(type) {

    var listUmbrella = document.getElementById("umbrella-list");
    var listField = document.getElementById("field-list");

    if (type == 'umbrella') {
      listUmbrella.style.display = "";
      listField.style.display = "none";
      $("#field_id").val('').selectpicker("refresh");
    } else if (type == 'field') {
      listUmbrella.style.display = "none";
      listField.style.display = "";
      $("#umbrella_id").val('').selectpicker("refresh");
    }
  }
</script>
<!--end::Page Scripts -->

<!-- Sidemenu class -->
<script>
  $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-results-keywords").addClass("m-menu__item  m-menu__item--active");
</script>