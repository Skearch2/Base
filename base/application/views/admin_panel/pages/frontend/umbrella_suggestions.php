<?php

// Set DocType and declare HTML protocol
$this->load->view('admin_panel/templates/start_html');

// Load default head (metadata & linking).
$this->load->view('admin_panel/templates/head');

?>

<head>
  <script src="<?php site_url(); ?>/assets/admin_panel/vendors/base/vendors.bundle.js" type="text/javascript"></script>
  <script src="<?php site_url(); ?>/assets/admin_panel/demo/demo12/base/scripts.bundle.js" type="text/javascript"></script>

  <script src="<?php site_url(); ?>/assets/admin_panel/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

  <script src="<?php site_url(); ?>/assets/admin_panel/app/js/dashboard.js" type="text/javascript"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

  <style>
    #sortable1SK,
    #sortable2SK {
      border: 1px solid #eee;
      width: 160px;
      min-height: 20px;
      list-style-type: none;
      margin: 0;
      padding: 5px 0 0 0;
      float: left;
      margin-right: 10px;
      max-height: 600px;
      overflow: auto;
    }

    #sortable1SK li,
    #sortable2SK li {
      margin: 0 5px 5px 5px;
      padding: 5px;
      font-size: 1em;
      width: 130px;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
      $(document).tooltip({
        track: true
      });

      $("#sortable1SK, #sortable2SK").sortable({
        connectWith: ".connectedSortable"
      }).disableSelection();
    });

    function addemptytab(val) {
      $("#sortable2SK").append("<li class='btn btn-secondary' title='Click to remove' onclick='$(this).remove();' style= 'background-color:red'> Empty Tab <input type='hidden' name='item[" + val + "][field_id] value='0'><input type='hidden' name='item[" + val + "][title]' value='empty'><input type='hidden' name='item[" + val + "][is_cat]' value='0'></li>");
      num++;
    }
  </script>
</head>

<?php

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
            <div class="m-form m-form--fit m-form--label-align-right">
              <div class="m-portlet__body">
                <div class="form-group m-form__group m--margin-top-10 m--show">
                  <?php echo $this->session->tempdata('success-msg'); ?>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Set Umbrella Suggestions</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Select Umbrella</label>
                  <div class="col-7">
                    <select class="form-control" onchange="getUmbSuggestions(this.value), $('#suggestionPanel').show(500)" required>
                      <option disabled selected value-"">Select Umbrella...</option>
                      <?php foreach ($umbrella as $item) { ?>
                        <option value="<?= $item->id ?>"><?= $item->title ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div id='suggestionPanel' class="form-group m-form__group row" style="display:none">
                  <label class="col-2 col-form-label">Drag item from the first list to the second list</label>
                  <div class="col-7">
                    <ul id="sortable1SK" class="connectedSortable">
                    </ul>
                    <form class="m-form m-form--fit m-form--label-align-right" role="form" method="POST">
                      <input type="hidden" class="umbrellaId" name="umbrellaId" value="">
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                      <ul id="sortable2SK" class="connectedSortable">
                      </ul>
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
                      <button type="reset" onClick="window.location.reload()" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
              </form>
            </div>
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
//$this->load->view('admin_panel/templates/close_html');

?>

<script>
  function getUmbSuggestions(umbId) {

    $('.umbrellaId').each(function() {
      $(this).val(umbId);
    });

    $(sortable1SK).empty();
    $(sortable2SK).empty();
    $.ajax({
      //changes
      url: '<?= site_url(); ?>admin/frontend/get_umbrella_suggestions/' + umbId,
      type: 'GET',
      success: function(result) {
        var obj = JSON.parse(result);
        obj['umbrella'].forEach(u => {
          var flag = true;
          obj['suggestions'].forEach(s => {
            if (u.id == s.suggest_umbrella_id) flag = false;
          });
          if (flag && u.id != umbId) {
            $(sortable1SK).append(
              '<li ondblclick="moveItem($(this))" class="btn btn-secondary m-btn m-btn--air m-btn--custom">' + u.title +
              '<input type="hidden" name="item[' + u.id + '][umbrella_id]" value="' + umbId + '">' +
              '<input type="hidden" name="item[' + u.id + '][suggest_umbrella_id]" value="' + u.id + '">' +
              '<input type="hidden" name="item[' + u.id + '][suggest_umbrella_title]" value="' + u.title + '"></li>'
            );
          }
        });

        obj['suggestions'].forEach(s => {
          $(sortable2SK).append(
            '<li ondblclick="moveItem($(this))" class="btn btn-secondary m-btn m-btn--air m-btn--custom">' + s.suggest_umbrella_title +
            '<input type="hidden" name="item[' + s.suggest_umbrella_id + '][umbrella_id]" value="' + umbId + '">' +
            '<input type="hidden" name="item[' + s.suggest_umbrella_id + '][suggest_umbrella_id]" value="' + s.suggest_umbrella_id + '">' +
            '<input type="hidden" name="item[' + s.suggest_umbrella_id + '][suggest_umbrella _title]" value="' + s.suggest_umbrella_title + '"></li>'
          );
        });
      },
      error: function(err) {
        alert("Error getting Fields");
      }
    });
  }

  function moveItem(val) {
    $("#sortable2SK").append(val);
  }
</script>

<!-- Sidemenu class -->
<script>
  $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-results-related_umbrellas").addClass("m-menu__item  m-menu__item--active");
</script>