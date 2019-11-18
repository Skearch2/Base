<!-- Start createalbum.php -->

<?php
  $main   = $this -> config -> item('main_class');

  $alb_umbrella = $this -> config -> item('umbrella');
  $alb_field = $this -> config -> item('field');

  $aid    = $this -> config -> item('imageserver_field_album_id');

  $desc   = $this -> config -> item('data_description');
  $title  = $this -> config -> item('data_title');
  $albumtype = $this -> config -> item('data_albumtype');
  $albumtypeid = $this -> config -> item('data_albumtypeid');
 ?>

      <form class="form-horizontal" method="POST" action="<?=base_url();?><?=$main;?>/createalbum">

        <h3 class="form-signin-heading">Add a new album</h3>

        <label for="<?=$title;?>" class="control-label">Album Name</label>
        <input type="text" name="<?=$title;?>" id="<?=$title;?>" class="form-control" placeholder="Album Name" required autofocus>

			<br>

        <label for="<?=$desc;?>" class="control-label">Album Description</label>
        <input type="text" name="<?=$desc;?>" id="<?=$desc;?>" class="form-control" placeholder="Album Description" required>

			<br>

        <label for="<?=$albumtype;?>" class="control-label">Album Type</label>
        <br>
        
        <select name="<?= $albumtype; ?>">
          <option value="default" selected>Default</option>
          <option value="global">Global</option>
        </select>

			<br>
      <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>

			<br>

		<a href="<?=base_url();?><?=$main;?>/home" class="btn btn-lg btn-primary btn-block">Cancel</a>

      </form>

<!-- End createalbum.php -->
