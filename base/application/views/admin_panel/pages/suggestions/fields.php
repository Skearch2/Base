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
  #resultsList,
  #suggestionList {
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

  #resultsList li,
  #suggestionList li {
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
            <form class="m-form m-form--fit m-form--label-align-right" id="m_form" role="form" method="POST">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
              <div class="m-form m-form--fit m-form--label-align-right">
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
                      <h3 class="m-form__section">Field Related Results</h3>
                    </div>
                  </div>
                  <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label">Field</label>
                    <div class="col-7">
                      <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" onchange="getSuggestions(this.value)" name="field">
                        <option value="" <?= set_select('field_id', '', TRUE) ?>>Select</option>
                        <?php foreach ($fields as $field) : ?>
                          <option value="<?= $field->id ?>"><?= $field->title ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <input type="hidden" class="fieldId" name="fieldId" value="">
                  </div>
                  <div id='suggestionPanel' class="form-group m-form__group row" style="display:none">
                    <label class="col-2 col-form-label"></label>
                    <div class="col-7">
                      <div>
                        <h5>Results</h5>
                        <ul id="resultsList" class="connectedSortable">
                        </ul>
                      </div>
                      <div>
                        <h5>Suggested Results</h5>
                        <ul id="suggestionList" class="connectedSortable">
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

// Load global JS files
$this->load->view('admin_panel/templates/js_global');

?>

<!--begin::Page Scripts -->


<script>
  var FormControls = {
    init: function() {
      $("#m_form").validate({
        rules: {
          field: {
            required: 1
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
    // initialize drag and drop
    $(function() {
      $("#resultsList, #suggestionList").sortable({
        containment: "parent"
      }).disableSelection();
    });
  });

  // maximum items allowed for suggested list
  var limit = 7;

  // get suggestions list
  function getSuggestions(fieldId) {

    $('.fieldId').each(function() {
      $(this).val(fieldId);
    });

    // clear both lists
    $(resultsList).empty();
    $(suggestionList).empty();

    $.ajax({
      url: '<?= site_url(); ?>admin/results/suggestions/fields/get/id/' + fieldId,
      type: 'GET',
      beforeSend: function() {
        $('#suggestionPanel').fadeOut(100)
      },
      success: function(result) {
        var obj = JSON.parse(result);
        var index = 0
        obj['results'].forEach(r => {
          var flag = true;
          obj['suggestions'].forEach(s => {
            if (r.id == s.result_id && r.is_umbrella == s.is_result_umbrella) flag = false;
          });
          if (flag && r.id != fieldId) {
            var btn_class = (r.is_umbrella == 1) ? "btn btn-outline-brand m-btn m-btn--air m-btn--custom" : "btn btn-secondary m-btn m-btn--air m-btn--custom"
            var is_result_umbrella = (r.is_umbrella) ? 1 : 0

            $(resultsList).append(
              '<li ondblclick="moveToSuggestionList($(this))" class="' + btn_class + '" title="Double-click to move">' + r.title +
              '<input type="hidden" name="item[' + index + '][field_id]" value="' + fieldId + '" disabled="">' +
              '<input type="hidden" name="item[' + index + '][result_id]" value="' + r.id + '" disabled="">' +
              '<input type="hidden" name="item[' + index + '][is_result_umbrella]" value="' + r.is_umbrella + '" disabled=""></li>'
            );
          }
          index++
        });

        obj['suggestions'].forEach(s => {
          var btn_class = (s.is_result_umbrella == 1) ? "btn btn-outline-brand m-btn m-btn--air m-btn--custom" : "btn btn-secondary m-btn m-btn--air m-btn--custom"
          $(suggestionList).append(
            '<li ondblclick="moveToResultsList($(this))" class="' + btn_class + '" title="Double-click to move">' + s.title +
            '<input type="hidden" name="item[' + index + '][field_id]" value="' + fieldId + '">' +
            '<input type="hidden" name="item[' + index + '][result_id]" value="' + s.result_id + '">' +
            '<input type="hidden" name="item[' + index + '][is_result_umbrella]" value="' + s.is_result_umbrella + '"></li>'
          );
          index++
        });
      },
      complete: function() {
        $('#suggestionPanel').fadeIn(500)
      },
      error: function(err) {
        toastr.error("Unable to process request.")
      }
    });
  }

  // move item to suggestions list
  function moveToSuggestionList(item) {
    if ($("#suggestionList li").length < limit) {
      $(item).attr("ondblclick", "moveToResultsList($(this))");
      $(item).children('input').each(function() {
        $(this).prop('disabled', false);
      });
      $("#suggestionList").append(item);
    } else {
      toastr.warning("Cannot add more than " + limit + " items.")
    }
  }

  // move item to result list
  function moveToResultsList(item) {
    $(item).attr("ondblclick", "moveToSuggestionList($(this))");
    $(item).children('input').each(function() {
      $(this).prop('disabled', true);
    });
    $("#resultsList").append(item);
    sortUnorderedList("resultsList");
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

  $("#menu-results").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#submenu-suggestions").addClass("m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded");
  $("#fields").addClass("m-menu__item  m-menu__item--active");
</script>

<!--end::Page Scripts -->

<?php
// Close body and html
$this->load->view('admin_panel/templates/close_html');
?>