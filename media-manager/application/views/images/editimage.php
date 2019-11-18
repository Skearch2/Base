<!-- Start editimage.php -->

<?php
  $main     = $this -> config -> item('main_class');

  $css      = $this -> config -> item('css_original_img_class');

  $aid      = $this -> config -> item('imageserver_field_album_id');
  $atitle   = $this -> config -> item('imageserver_field_album_title');
  $amediabox = $this -> config -> item('imageserver_field_album_mediabox');

  $iid      = $this -> config -> item('imageserver_field_image_id');
  $ititle   = $this -> config -> item('imageserver_field_image_title');
  $idesc    = $this -> config -> item('imageserver_field_image_description');
  $ifile    = $this -> config -> item('imageserver_field_image_filename');
  $imediaurl  = $this -> config -> item('imageserver_field_image_mediaurl');
  $iurl     = $this -> config -> item('imageserver_field_image_url');
  $iduration = $this -> config -> item('imageserver_field_image_duration');

  $imageid  = $this -> config -> item('data_imageid');
  $albumid  = $this -> config -> item('data_albumid');
  $title    = $this -> config -> item('data_title');
  $desc     = $this -> config -> item('data_description');
  $media   	= $this -> config -> item('data_userfile');
  $mediaurl	= $this -> config -> item('data_mediaurl');
  $url      = $this -> config -> item('data_url');
  $duration = $this -> config -> item('data_duration');

  $mediaboxu = $this -> config -> item('mediaboxu');
 ?>

  <br>
<h2 class="form-signin-heading"><?= "Album: " . ucwords($album->$atitle) . " - " . ucwords($albumtype) . ": " . $keyword; ?></h2>
  <br>

<div class="img-container">
  <img src="<?= ( !is_string($image -> {$ifile}) ? 'unknown' : $image -> {$ifile} ); ?>" alt="<?= $image -> {$ititle}; ?>" title="<?= $image -> {$idesc}; ?>" class="<?=$css;?>">
</div>
  <br>

<form id="edit-image-form" class="form-horizontal" method="POST" action="<?=base_url();?><?="$main/updateimage/{$image->$aid}/{$image->$iid}"; ?>" enctype="multipart/form-data">
   <br>

 <input name="albumtype" type="hidden" value="<?= $albumtype; ?>">
 <input name="albumtypeid" type="hidden" value="<?= $albumtypeid; ?>">

  <label for="<?=$title;?>" class="control-label">Image Title</label>
  <input type="text" name="<?=$title;?>" id="<?=$title;?>" class="form-control" value="<?= $image -> {$ititle}; ?>" required autofocus>

    <br>

  <label for="<?=$desc;?>" class="control-label">Image Description</label>
  <input type="text" name="<?=$desc;?>" id="<?=$desc;?>" class="form-control" value="<?= $image -> {$idesc}; ?>" required autofocus>

    <br>

    <label for="<?=$media;?>" class="control-label">Media</label>
    &emsp;
    <?php if ( strcasecmp($album -> $amediabox, $mediaboxu) == 0 ) : ?>
      <button type="button" class="btn btn-outline-primary btn-sm" id="mediaurl_button">Add Youtube Link</button>
    <?php endif; ?>
    <br>

    <div class="input-group" id="mediaupload">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
      </div>
      <div class="custom-file">
        <input type="file" class="custom-file-input" id="inputGroupFile01" name="<?=$media;?>" aria-describedby="inputGroupFileAddon01">
        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
      </div>
    </div>

    <input type="url" name="<?=$mediaurl;?>" id="mediaurl" class="form-control" placeholder="https://www.youtube.com/watch?v=abcxyz">

      <br>

  <label for="<?=$url;?>" class="control-label">Image Link Reference</label>
  <input type="url" name="<?=$url;?>" id="<?=$url;?>" class="form-control" value="<?= $image -> {$iurl}; ?>">

    <br>

  <label for="<?=$duration;?>" class="control-label">Image Duration</label>
  <input type="number" name="<?=$duration;?>" id="<?=$duration;?>" class="form-control" min="1" max="120" value="<?= $image -> {$iduration}; ?>">

    <br>
    <br>

  <button class="btn btn-lg btn-success" type="submit" form="edit-image-form" >Submit</button>
  <button class="btn btn-lg btn-primary" type="button" form="create-image-form" onclick="history.back();">Cancel</button>
  <a href="<?=base_url();?><?=$main;?>/deleteimage/<?= $albumtype."/".$albumtypeid."/".$image -> {$iid}; ?>" class="btn btn-lg btn-danger float-right">Delete Image</a><br>
</form>

<script>
  $(document).ready(function(){
    $("#mediaurl").hide();
    <?php if ( strcasecmp($album -> $amediabox, $mediaboxu) == 0 ) : ?>
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
