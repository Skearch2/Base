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
<h2 class="form-signin-heading"><?= "Album: " . ucwords($album->$atitle); ?></h2>
  <br>
  <br>
  <br>

<div class="img-container">
  <?php if ( strcasecmp($image -> $imediaurl, '#') ) : ?>
    <iframe width="590" height="300" src="https://www.youtube.com/embed/<?=$image -> $imediaurl;?>?&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="<?=$css;?>"></iframe>
  <?php else : ?>
    <img src="<?= ( !is_string($image -> {$ifile}) ? 'unknown' : $image -> {$ifile} ); ?>" alt="<?= $image -> {$ititle}; ?>" title="<?= $image -> {$idesc}; ?>" class="<?=$css;?>">
  <?php endif; ?>
<div>
  <br>

<form id="edit-image-form" class="form-horizontal" method="POST" action="<?=base_url();?><?=$main;?>/updateimage/<?= $image -> {$aid}; ?>/<?= $image -> {$iid}; ?>" enctype="multipart/form-data">

  <label for="<?=$title;?>" class="control-label">Image Title</label>
  <input type="text" name="<?=$title;?>" id="<?=$title;?>" class="form-control" value="<?= $image -> {$ititle}; ?>" required autofocus>

    <br>

  <label for="<?=$desc;?>" class="control-label">Image Description</label>
  <input type="text" name="<?=$desc;?>" id="<?=$desc;?>" class="form-control" value="<?= $image -> {$idesc}; ?>" required autofocus>

    <br>

    <label for="<?=$media;?>" class="control-label">Media</label>

    <br>

    <?php if ( strcasecmp($image -> $imediaurl, '#') == 0 ) : ?>
      <div class="input-group" id="mediaupload">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
        </div>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="inputGroupFile01" name="<?=$media;?>" aria-describedby="inputGroupFileAddon01">
          <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
      </div>
    <?php else : ?>
      <input type="url" name="<?=$mediaurl;?>" id="mediaurl" class="form-control" value=<?= $image -> {$imediaurl}; ?>>
    <?php endif; ?>

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
  <a href="<?=base_url();?><?=$main;?>/deleteimageglobal/<?= $image -> {$iid}; ?>" class="btn btn-lg btn-danger float-right">Delete Image</a><br>
</form>

<!-- End editimage.php -->
