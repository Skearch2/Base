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
                  <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        <p class="flaticon-warning"> Error:</p>
                        <?= validation_errors(); ?>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Link Information</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Title</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="title" value="<?= set_value('title', $link->title); ?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label"> Short Description</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="description_short" value="<?= set_value('description_short', $link->description_short); ?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Display URL</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="display_url" value="<?= set_value('display_url', $link->display_url); ?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">URL</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="www" value="<?= set_value('www', $link->www); ?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Field</label>
                  <div class="col-7">
                    <select class="form-control" name="field_id" onchange="getPriorities(this.value)">
                      <option value="<?= $link->field_id ?>" <?= set_select("field_id", $link->field_id, TRUE) ?>><?= $link->field ?></option>
                      <?php foreach ($fields as $f) : ?>
                        <?php if ($link->field_id == $f->id) continue; ?>
                        <option value="<?= $f->id ?>" <?= set_select("field_id", $f->id) ?>><?= $f->title ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Priority</label>
                  <div class="col-7">
                    <select class="form-control" id="priority" name="priority">
                      <option value="<?= $link->priority ?>"><?= $link->priority ?></option>
                      <!-- <option selected value="0">Not Set</option>
                      <?php for ($i = 1; $i <= 250; $i++) { ?>
                        <?php if ($i == $result[0]->priority) { ?>
                          <option selected value="<?= $i ?>"><?= $i ?></option>
                        <?php } else if (in_array($i, $priorities)) { ?>
                          <option style="background-color: #99ff99" value="<?= $i ?>" disabled><?= $i ?></option>
                        <?php } else { ?>
                          <option value="<?= $i ?>"><?= $i ?></option>
                      <?php }
                      } ?> -->
                    </select>
                  </div>
                  <div id="priority-refresh" class="m-demo-icon__preview"><i class="flaticon-refresh" title="Refresh" onclick="getPriorities($('[name=field_id]').val())"></i></div>
                  <div id="priority-loader" class="m-loader m-loader--brand" style="width: 30px; display: none;"></div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Enabled</label>
                  <div class="col-7">
                    <input type="hidden" name="enabled" value="0" <?= set_value('enabled', $link->enabled) == 0 ? 'checked' : "" ?>>
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="enabled" value="1" <?= set_value('enabled', $link->enabled) == 1 ? 'checked' : "" ?>>
                        <span></span>
                      </label>
                    </span>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Brand Link</label>
                  <div class="col-7">
                    <input type="hidden" name="redirect" value="0" <?= set_value('redirect', $link->redirect) == 0 ? 'checked' : "" ?>>
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="redirect" value="1" <?= set_value('redirect', $link->redirect) == 1 ? 'checked' : "" ?>>
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
                      <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Submit</button>&nbsp;&nbsp;
                      <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane " id="m_user_profile_tab_2">
          </div>
          <div class="tab-pane " id="m_user_profile_tab_3">
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
  // get priorites of the links for the given field
  function getPriorities(fieldId) {

    var selectElement = document.getElementById("priority");
    selectElement.disabled = true;
    while (selectElement.length > 0) {
      selectElement.remove(0);
    }

    if (fieldId == "") return;
    $.ajax({
      url: '<?= site_url('admin/results/links/priorities/field/id/'); ?>' + fieldId,
      type: 'GET',
      beforeSend: function(xhr, options) {
        $("#priority-refresh").css("display", "none");
        $("#priority-loader").css("display", "inline-block");
        setTimeout(function() {
          $.ajax($.extend(options, {
            beforeSend: $.noop
          }));
        }, 500);
        return false;
      },
      success: function(data, status) {
        var obj = JSON.parse(data);
        var option = document.createElement("option");
        option.text = "Not Set";
        option.value = 0;
        selectElement.add(option);

        for (i = 1; i <= 255; i++) {
          var option = document.createElement("option");
          var array = searchArray(i, obj);
          if (array) {
            option.text = i + " - " + array.title;
            option.value = i;
            option.disabled = true;
          } else {
            option.text = i;
            option.value = i;
          }
          selectElement.add(option);
          selectElement.disabled = false;
        }
      },
      complete: function() {
        $("#priority-loader").css("display", "none");
        $("#priority-refresh").removeAttr('style');
      },
      error: function(xhr, status, error) {
        toastr.error("Error getting priorities.");
      }
    });
  }

  function searchArray(key, array) {
    for (var i = 0; i < array.length; i++) {
      if (array[i].priority == key) {
        return array[i];
      }
    }
    return false;
  }
</script>

<!-- Sidemenu class -->
<script>
  $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-results-links").addClass("m-menu__item  m-menu__item--active");
</script>