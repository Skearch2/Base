<!-- Start createimage.php -->

<?php
  $main   = $this -> config -> item('main_class');

  $aid    = $this -> config -> item('imageserver_field_album_id');
  $atitle = $this -> config -> item('imageserver_field_album_title');
  $amediabox = $this -> config -> item('imageserver_field_album_mediabox');

  $title  = $this -> config -> item('data_title');
  $desc   = $this -> config -> item('data_description');
  $media	= $this -> config -> item('data_userfile');
  $mediaurl	= $this -> config -> item('data_mediaurl');
  $url    = $this -> config -> item('data_url');
  $duration = $this -> config -> item('data_duration');
  $mediabox = $this -> config -> item('data_albummediabox');

  $mediaboxu = $this -> config -> item('mediaboxu');

 ?>

    <br>

    <h2 class="form-signin-heading"><?= "Album: " . ucwords($album->$atitle) . " - " . ucwords($albumtype) . ": " . $keyword; ?></h2>

      <br>
      <h2 class="form-signin-heading">Create new Media</h2>

      <form id="create-image-form" class="form-horizontal" method="POST" action="<?=base_url();?><?="$main/createimage/{$album->$aid}/$albumtype/$albumtypeid";?>" enctype="multipart/form-data">

        <input type="hidden" name="albumtype" value="<?= $albumtype; ?>">
        <input type="hidden" name="albumtypeid" value="<?= $albumtypeid; ?>">

        <label for="<?=$title;?>" class="control-label">Media Name</label>
        <input type="text" name="<?=$title;?>" id="<?=$title;?>" class="form-control" placeholder="Media Name" required autofocus>

			     <br>

        <label for="<?=$desc;?>" class="control-label">Media Description</label>
        <input type="text" name="<?=$desc;?>" id="<?=$desc;?>" class="form-control" placeholder="Media Description" required>

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
            <input type="file" class="custom-file-input" id="inputGroupFile01" name="<?=$media;?>" aria-describedby="inputGroupFileAddon01" required>
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>

        <input type="url" name="<?=$mediaurl;?>" id="mediaurl" class="form-control" placeholder="https://www.youtube.com/watch?v=abcxyz">

          <br>

        <label for="<?=$url;?>" class="control-label">Media Link Reference</label>
        <input type="url" name="<?=$url;?>" id="<?=$url;?>" class="form-control" placeholder="http://www.example.com/" required>

            <br>

        <label for="<?=$duration;?>" class="control-label">Media Duration</label>
        <input type="number" name="<?=$duration;?>" id="<?=$duration;?>" class="form-control" min="1" max="120" placeholder="Duration in seconds" required>

            <br>
			<br>

        <button class="btn btn-lg btn-success" type="submit" form="create-image-form">Create</button>
        <button class="btn btn-lg btn-primary" type="button" form="create-image-form" onclick="history.back();">Cancel</button>

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

<!-- End createimage.php -->
