<!-- Start editimage.php -->

<?php
$main     = $this->config->item('main_class');

$css      = $this->config->item('css_original_img_class');

$aid      = $this->config->item('imageserver_field_album_id');
$atitle   = $this->config->item('imageserver_field_album_title');
$amediabox = $this->config->item('imageserver_field_album_mediabox');

$iid      = $this->config->item('imageserver_field_image_id');
$ititle   = $this->config->item('imageserver_field_image_title');
$idesc    = $this->config->item('imageserver_field_image_description');
$ifile    = $this->config->item('imageserver_field_image_filename');
$imediaurl  = $this->config->item('imageserver_field_image_mediaurl');
$iurl     = $this->config->item('imageserver_field_image_url');
$iduration = $this->config->item('imageserver_field_image_duration');
$isign = $this->config->item('imageserver_field_image_sign');

$imageid  = $this->config->item('data_imageid');
$albumid  = $this->config->item('data_albumid');
$title    = $this->config->item('data_title');
$desc     = $this->config->item('data_description');
$media     = $this->config->item('data_userfile');
$mediaurl  = $this->config->item('data_mediaurl');
$url      = $this->config->item('data_url');
$duration = $this->config->item('data_duration');
$sign = $this->config->item('data_sign');

$mediaboxu = $this->config->item('mediaboxu');

$basedomain = $this->config->item('base_domain');
?>

<h3 style="display:inline;">Edit Media</h3>
<h4 class="float-right"><?= "Album: " . ucwords($album->$atitle) . " - " . ucwords($albumtype) . ": " . $keyword; ?></h4>

<br>
<br>

<div class="img-container">
  <?php if (strcasecmp($image->{$imediaurl}, '#')) : ?>
    <iframe width="590" height="300" src="https://www.youtube.com/embed/<?= $image->{$imediaurl} ?>?&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="<?= $css; ?>"></iframe>
  <?php else : ?>
    <?php $is_video = substr(strtolower($image->{$ifile}), -3) == 'mp4' ? 1 : 0 ?>
    <?php if ($is_video) : ?>
      <video class="<?= $css; ?>" controls>
        <source src="<?= $image->{$ifile} ?>" type="video/mp4">
        Unable to play video, incompatible browser.
      </video>
    <?php else : ?>
      <img src="<?= (!is_string($image->{$ifile}) ? 'unknown' : $image->{$ifile}); ?>" alt="No Media" title="<?= $image->{$idesc}; ?>" class="<?= $css; ?>">
    <?php endif; ?>
  <?php endif; ?>
</div>

<br>

<form id="edit-image-form" class="form-horizontal" method="POST" action="<?= base_url(); ?><?= "$main/updateimage/{$image->$aid}/{$image->$iid}"; ?>" enctype="multipart/form-data">

  <label for="brand" class="control-label">Brand</label>
  <input type="text" class="form-control m-input" id="brand-search" name="brand" placeholder="Search" value="<?= set_value('brand', $brand->name) ?>">
  <input type="hidden" id="brand-id" name="brand_id" value="<?= set_value('brand_id', $brand->id) ?>">

  <br>

  <input name="albumtype" type="hidden" value="<?= $albumtype; ?>">
  <input name="albumtypeid" type="hidden" value="<?= $albumtypeid; ?>">

  <label for="<?= $title; ?>" class="control-label">Title</label>
  <input type="text" name="<?= $title; ?>" id="<?= $title; ?>" class="form-control" value="<?= $image->{$ititle}; ?>" required autofocus>

  <br>

  <label for="<?= $desc; ?>" class="control-label">Description</label>
  <input type="text" name="<?= $desc; ?>" id="<?= $desc; ?>" class="form-control" value="<?= $image->{$idesc}; ?>" required autofocus>

  <br>

  <label for="<?= $url; ?>" class="control-label">Link Reference</label>
  <input type="url" name="<?= $url; ?>" id="<?= $url; ?>" class="form-control" value="<?= $image->{$iurl}; ?>">

  <br>

  <label for="<?= $duration; ?>" class="control-label">Duration</label>
  <input type="number" name="<?= $duration; ?>" id="<?= $duration; ?>" class="form-control" min="1" max="120" value="<?= $image->{$iduration}; ?>">

  <br>

  <?php if (strcasecmp($image->$imediaurl, '#') == 0) : ?>
    <label for="<?= $media; ?>" class="control-label">Media</label>
    <input id="mediaupload" name="<?= $media; ?>" type="file" data-show-preview="true" data-msg-placeholder="Upload Media" data-allowed-file-extensions='["mp4", "gif", "jpeg", "jpg", "png"]'>
    <input type="hidden" name="<?= $mediaurl; ?>" value="<?= $image->{$imediaurl}; ?>">
  <?php else : ?>
    <label for="<?= $media; ?>" class="control-label">Youtube Link</label>
    <input type="url" name="<?= $mediaurl; ?>" id="mediaurl" class="form-control" value=<?= $image->{$imediaurl}; ?>>
    <input type="hidden" name="<?= $media; ?>">
    <br>
  <?php endif; ?>

  <br>

  <label for="<?= $sign; ?>" class="control-label">Show Ad Sign</label>
  <input type="hidden" name="<?= $sign; ?>" value="0" <?= $image->{$isign} == 0 ? 'checked' : "" ?>>
  <input type="checkbox" name="<?= $sign; ?>" value="1" <?= $image->{$isign} == 1 ? 'checked' : "" ?>>

  <br><br>

  <button class="btn btn-small btn-primary" type="submit" form="edit-image-form">Submit</button>
  <button class="btn btn-small btn-secondary" type="button" form="create-image-form" onclick="history.back();">Cancel</button>
  <a href="<?= base_url(); ?><?= $main; ?>/deleteimage/<?= $albumtype . "/" . $albumtypeid . "/" . $image->{$iid}; ?>" class="btn btn-small btn-danger float-right">Delete</a><br>
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
        $("#mediaurl_button").html("Upload Media");
        $('#mediaurl_button').attr('id', 'mediaupload_button');
        $('#mediaurl').attr('required', 'true');
        $("#mediaurl").show();
      }).on('click', "#mediaupload_button", function() {
        $('#mediaurl').removeAttr('required');
        $("#mediaurl").hide();
        $("#mediaupload_button").html("Add Youtube Link");
        $('#mediaupload_button').attr('id', 'mediaurl_button');
        $('#inputGroupFile01').attr('required', 'true');
        $("#mediaupload").show();
      });
    <?php endif; ?>
  });
</script>

<!-- End editimage.php -->