<!-- Start createimage.php -->

<?php
$main   = $this->config->item('main_class');

$aid    = $this->config->item('imageserver_field_album_id');
$atitle = $this->config->item('imageserver_field_album_title');
$amediabox = $this->config->item('imageserver_field_album_mediabox');

$brandid  = $this->config->item('data_brandid');
$title  = $this->config->item('data_title');
$desc   = $this->config->item('data_description');
$media  = $this->config->item('data_userfile');
$mediaurl  = $this->config->item('data_mediaurl');
$url    = $this->config->item('data_url');
$duration = $this->config->item('data_duration');
$sign = $this->config->item('data_sign');
$mediabox = $this->config->item('data_albummediabox');

$mediaboxu = $this->config->item('mediaboxu');

$basedomain = $this->config->item('base_domain');

?>

<h3 style="display:inline;">Add Media</h3>
<h4 class="float-right"><?= "Album: " . ucwords($album->$atitle) . " - " . ucwords($albumtype) . ": " . $keyword; ?></h4>

<br>
<br>

<form id="create-image-form" class="form-horizontal" method="POST" action="<?= base_url(); ?><?= "$main/createimage/{$album->$aid}/$albumtype/$albumtypeid"; ?>" enctype="multipart/form-data">

  <input type="hidden" name="albumtype" value="<?= $albumtype; ?>">
  <input type="hidden" name="albumtypeid" value="<?= $albumtypeid; ?>">

  <label for="<?= $title; ?>" class="control-label">Brand</label>
  <input type="text" name="brand" id="brand-search" class="form-control" placeholder="Search Brand" required autofocus>
  <input type="hidden" name="<?= $brandid; ?>" id="<?= $brandid; ?>">

  <br>

  <label for=" <?= $title; ?>" class="control-label">Title</label>
  <input type="text" name="<?= $title; ?>" id="<?= $title; ?>" class="form-control" placeholder="Name" required autofocus>

  <br>

  <label for="<?= $desc; ?>" class="control-label">Description</label>
  <input type="text" name="<?= $desc; ?>" id="<?= $desc; ?>" class="form-control" placeholder="Description" required>

  <br>

  <label for="<?= $url; ?>" class="control-label">Link Reference</label>
  <input type="url" name="<?= $url; ?>" id="<?= $url; ?>" class="form-control" placeholder="http://www.example.com" required>

  <br>

  <label for=" <?= $duration; ?>" class="control-label">Duration</label>
  <input type="number" name="<?= $duration; ?>" id="<?= $duration; ?>" class="form-control" min="1" max="120" placeholder="Duration in seconds" required>

  <br>

  <label for="<?= $media; ?>" class="control-label">Media</label>
  <input id="mediaupload" name="<?= $media; ?>" type="file" class="file" data-show-preview="true" data-msg-placeholder="Upload Media" data-allowed-file-extensions='["mp4", "gif", "jpeg", "jpg", "png"]'>
  <input type="url" name="<?= $mediaurl; ?>" id="mediaurl" class="form-control" placeholder="https://www.youtube.com/watch?v=abcxyz">

  <?php if (strcasecmp($album->$amediabox, $mediaboxu) == 0) : ?>
    <button type="button" class="btn btn-link" id="mediaurl_button">or Add Youtube Link</button>
    <br>
  <?php endif; ?>

  <br>

  <label for="<?= $sign; ?>" class="control-label">Show Ad Sign</label>
  <input type="checkbox" id="<?= $sign; ?>" name="<?= $sign; ?>">

  <br><br>

  <button class="btn btn-small btn-primary" type="submit" form="create-image-form">Submit</button>
  <button class="btn btn-small btn-secondary" type="button" form="create-image-form" onclick="history.back();">Cancel</button>

</form>

<script>
  // settings for brand search
  var options = {

    url: function(phrase) {
      return "<?= $basedomain ?>/admin/brands/search/" + phrase
    },

    getValue: "brand",

    template: {
      type: "description",
      fields: {
        description: "organization"
      }
    },

    list: {
      match: {
        enabled: true
      },

      sort: {
        enabled: true
      },

      onSelectItemEvent: function() {
        var brand = $("#brand-search").getSelectedItemData().brand;
        var id = $("#brand-search").getSelectedItemData().id;

        $("#brand-search").val(brand).trigger("change");
        $("#<?= $brandid ?>").val(id);
      },

      showAnimation: {
        type: "slide", //normal|slide|fade
        callback: function() {}
      },

      hideAnimation: {
        type: "normal", //normal|slide|fade
        callback: function() {}
      }
    },

    theme: "bootstrap"
  };

  // initialize brand search
  $("#brand-search").easyAutocomplete(options);
</script>


<script>
  $(document).ready(function() {
    $("#mediaurl").hide();
    <?php if (strcasecmp($album->$amediabox, $mediaboxu) == 0) : ?>
      $("#mediaurl_button").parent().on('click', "#mediaurl_button", function() {
        $('#inputGroupFile01').removeAttr('required');
        $("#mediaupload").hide();
        $("#mediaurl_button").html("or Upload Media");
        $('#mediaurl_button').attr('id', 'mediaupload_button');
        $('#mediaurl').attr('required', 'true');
        $("#mediaurl").show();
      }).on('click', "#mediaupload_button", function() {
        $('#mediaurl').removeAttr('required');
        $("#mediaurl").hide();
        $("#mediaupload_button").html("or Add Youtube Link");
        $('#mediaupload_button').attr('id', 'mediaurl_button');
        $('#inputGroupFile01').attr('required', 'true');
        $("#mediaupload").show();
      });
    <?php endif; ?>
  });

  $("#mediaupload").fileinput({
    'theme': "fas",
    'showUpload': false,
    'showClose': false,
    'focusCaptionOnBrowse': false,
    'focusCaptionOnClear': false,
    'previewFileType': ['mp4 ', 'jpeg', 'jpg', 'gif', 'png'],
    'dropZoneEnabled': false,
    'maxFileCount': 1,
    'fileActionSettings': {
      'showZoom': false
    }
  });
</script>

<!-- End createimage.php -->