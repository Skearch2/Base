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
                        Suggestions has been updated.
                      </div>
                    </div>
                  <?php elseif ($this->session->flashdata('success') === 0) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="alert-icon">
                        <p class="flaticon-like"> Success:</p>
                        Unable to update suggestions.
                      </div>
                    </div>
                  <?php endif ?>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-10 ml-auto">
                    <h3 class="m-form__section">Umbrella Related Results</h3>
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <label for="example-text-input" class="col-2 col-form-label">Umbrella</label>
                  <div class="col-7">
                    <select class="form-control" onchange="getSuggestions(this.value)" required>
                      <option disabled selected>Select</option>
                      <?php foreach ($umbrellas as $umbrella) : ?>
                        <option value="<?= $umbrella->id ?>"><?= $umbrella->title ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div id='suggestionPanel' class="form-group m-form__group row" style="display:none">
                  <label class="col-2 col-form-label"></label>
                  <div class="col-7">
                    <div>
                      <h5>Results</h5>
                      <ul id="resultsList" class="connectedSortable">
                      </ul>
                    </div>
                    <form class="m-form m-form--fit m-form--label-align-right" role="form" method="POST">
                      <input type="hidden" class="umbrellaId" name="umbrellaId" value="">
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
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
  // maximum items allowed for suggested list
  var limit = 8;

  // initialize drag and drop
  $(function() {
    $("#resultsList, #suggestionList").sortable({
      containment: "parent"
    }).disableSelection();
  });

  // move item to homepage list
  function moveToSuggestionList(val) {
    if ($("#suggestionList li").length < limit) {
      $(val).attr("ondblclick", "moveToResultsList($(this))");
      $("#suggestionList").append(val);
    } else {
      toastr.warning("Cannot add more than " + limit + " items.")
    }
  }

  // move item to featured list
  function moveToResultsList(val) {
    $(val).attr("ondblclick", "moveToSuggestionList($(this))");
    $("#resultsList").append(val);
    sortUnorderedList("resultsList");
  }

  // get suggestions list
  function getSuggestions(umbrellaId) {

    $('.umbrellaId').each(function() {
      $(this).val(umbrellaId);
    });

    // clear both lists
    $(resultsList).empty();
    $(suggestionList).empty();

    $.ajax({
      url: '<?= site_url(); ?>admin/results/suggestions/umbrellas/get/id/' + umbrellaId,
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
          if (flag && r.id != umbrellaId) {
            var btn_class = (r.is_umbrella == 1) ? "btn btn-outline-brand m-btn m-btn--air m-btn--custom" : "btn btn-secondary m-btn m-btn--air m-btn--custom"
            var is_result_umbrella = (r.is_umbrella) ? 1 : 0

            $(resultsList).append(
              '<li ondblclick="moveToSuggestionList($(this))" class="' + btn_class + '">' + r.title +
              '<input type="hidden" name="item[' + index + '][umbrella_id]" value="' + umbrellaId + '">' +
              '<input type="hidden" name="item[' + index + '][result_id]" value="' + r.id + '">' +
              '<input type="hidden" name="item[' + index + '][is_result_umbrella]" value="' + r.is_umbrella + '"></li>'
            );
          }
          index++
        });

        obj['suggestions'].forEach(s => {
          var btn_class = (s.is_result_umbrella == 1) ? "btn btn-outline-brand m-btn m-btn--air m-btn--custom" : "btn btn-secondary m-btn m-btn--air m-btn--custom"
          $(suggestionList).append(
            '<li ondblclick="moveToResultsList($(this))" class="' + btn_class + '">' + s.title +
            '<input type="hidden" name="item[' + index + '][umbrella_id]" value="' + umbrellaId + '">' +
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
  $("#umbrellas").addClass("m-menu__item  m-menu__item--active");
</script>