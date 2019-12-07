<!-- Start fetch.php -->

<?php
  // Ensure that this is an admin
  if ( !$this -> ion_auth -> logged_in() || $this -> ion_auth -> user() -> row() -> id != $this -> config -> item('admin_id') ) {
    redirect( base_url( $this -> config -> item('welcome_class') ) );
  }
 ?>

<?php
  $welcome  = $this -> config -> item('welcome_class');

  $uid      = $this -> config -> item('field_userid');
  $uname    = $this -> config -> item('field_username');
  $fname    = $this -> config -> item('field_firstname');
  $lname    = $this -> config -> item('field_lastname');
  $phone    = $this -> config -> item('field_telephone');
  $email    = $this -> config -> item('field_email');

  $aid      = $this -> config -> item('imageserver_field_app_id');
  $aname    = $this -> config -> item('imageserver_field_app_name');
  $asecret  = $this -> config -> item('imageserver_field_app_secret');
 ?>

      <h2>User Information for <?=$user -> {$uname};?></h2>
      <ul>
        <li><span>Email: <?=$user -> {$email}?></span></li>
        <li><span>First Name: <?=$user -> {$fname}?></span></li>
        <li><span>Last Name: <?=$user -> {$lname}?></span></li>
        <li><span>Telephone: <?=$user -> {$lname}?></span></li>
      </ul>

      <h2>App Information for <?=$app -> {$aname};?></h2>
      <ul>
        <li><span>AppId: <?=$app -> {$aid};?></span></li>
        <li><span>Secret: <?=$app -> {$asecret};?></span></li>
      </ul>

<!-- End fetch.php -->
