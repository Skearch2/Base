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
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <div class="m-portlet__body">
                <div class="form-group m-form__group m--margin-top-10 m--show">
                  <?php echo $this->session->tempdata('success-msg'); ?>
                  <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        <p class="flaticon-danger"> Error:</p>
                        <?= validation_errors(); ?>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Ad Link Information</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Title</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="title" value="<?php if (form_error('title') == '') echo set_value('title'); ?>" required>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Short Description</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="description_short" value="<?php if (form_error('description_short') == '') echo set_value('description_short'); ?>" required>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Display URL</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="display_url" value="<?php if (form_error('display_url') == '') echo set_value('display_url'); ?>">
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">URL</label>
                  <div class="col-7">
                    <input class="form-control m-input" type="text" name="www" value="<?php if (form_error('www') == '') echo set_value('www'); ?>" required>

                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Field</label>
                  <div class="col-7">
                    <select class="form-control" name="sub_id" onchange="updatePriority(this.value)" required>
                      <option value="">Choose Field</option>
                      <?php foreach ($subcategory_list as $item) { ?>
                        <option value="<?= $item->id ?>"><?= $item->title ?> </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Priority</label>
                  <div class="col-7">
                    <select class="form-control" id="priorities" name="priority" required>
                      <option selected value="0">Not Set</option>
                      <?php for ($i = 1; $i <= 250; $i++) { ?>
                        <?php if ($i == $result[0]->priority) { ?>
                          <option selected value="<?= $i ?>"><?= $i ?></option>
                        <?php } else if (in_array($i, $priorities)) { ?>
                          <option style="background-color: #99ff99" value="<?= $i ?>" disabled><?= $i ?></option>
                        <?php } else { ?>
                          <option value="<?= $i ?>"><?= $i ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Enabled</label>
                  <div class="col-7">
                    <input type="hidden" name="enabled" value="0">
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="enabled" value="1" checked>
                        <span></span>
                      </label>
                    </span>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Brand Link</label>
                  <div class="col-7">
                    <input type="hidden" name="redirect" value="0">
                    <span class="m-switch m-switch--icon-check">
                      <label>
                        <input type="checkbox" name="redirect" value="1" checked>
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
  jQuery(document).ready(function() {
    Dashboard.init(); // init metronic core componets
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "positionClass": "toast-bottom-right",
      "onclick": null,
      "showDuration": "500",
      "hideDuration": "500",
      "timeOut": "1500",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };
  });

  $("#smenu_data").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  //$( "#priorities" ).prop( "disabled", true );

  function updatePriority(id) {
    toastr.info("", "Updating Priority...");

    var selectElement = document.getElementById("priorities");
    selectElement.disabled = true;
    while (selectElement.length > 0) {
      selectElement.remove(0);
    }

    if (id == "") return;
    $.ajax({
      //changes
      url: '<?= site_url(); ?>/admin/categories/get_links_priority/' + id,
      type: 'GET',
      success: function(result) {
        var obj = JSON.parse(result);
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
            option.style.backgroundColor = "#99ff99";
            option.disabled = true;
          } else {
            option.text = i;
            option.value = i;
          }
          selectElement.add(option);
          selectElement.disabled = false;
        }
      },
      error: function(err) {
        alert("Error Updating Priority");
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