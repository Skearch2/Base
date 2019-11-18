<!-- Start registered.php -->

<?php
  // Ensure that this is an admin
  if ( !$this -> ion_auth -> is_admin() ) {
    redirect( base_url( $this -> config -> item('welcome_class') ) );
  }
 ?>

<?php
  $welcome  = $this -> config -> item('welcome_class');

  $isurl    = $this -> config -> item('imageserver_basepath');
  $api      = $this -> config -> item('imageserver_apifolder');
  $yum      = $this -> config -> item('imageserver_frontend_access');
  $apt      = $this -> config -> item('imageserver_frontend_mobile');

  $apikeyas = $this -> config -> item('imageserver_header_apikey');
  $appidas  = $this -> config -> item('imageserver_header_appid');
  $secretas = $this -> config -> item('imageserver_header_secret');

  $pubkey   = $this -> config -> item('imageserver_public_apikey');

  $aid      = $this -> config -> item('imageserver_field_app_id');
  $aname    = $this -> config -> item('imageserver_field_app_name');
  $asecret  = $this -> config -> item('imageserver_field_app_secret');
 ?>

      <h2><?=$app -> {$aname};?> has been Registered!!</h2>

      <div class="well">
        <p>Please provide the following information to the programmer responsible for
        building your mobile application.</p>

        <p>Programmer, please request a GET response from the ImageServer with the following credentials</p>
        <ol>
          <li><span>Construct an HTTP response with the method GET to the following URL: <?=$isurl;?><?=$api;?>/<?=$yum;?>.</span></li>
          <li>
            <span>Place each of these items in the HTTP Header (Format <i>Name : Value</i>)</span>
            <ul>
              <li><span><?=$apikeyas;?> : <?=$pubkey;?></span></li>
              <li><span><?=$appidas;?> : <?=$app -> {$aid};?></span></li>
              <li><span><?=$secretas;?> : <?=$app -> {$asecret};?></span></li>
            </ul>
          </li>
          <li><span>The server will return an API key that you should store and pass for each request to the server as <?=$apikeyas;?>:MyApiKey</span></li>
          <li><span>Each request will be sent to the following URL: <?=$isurl;?><?=$api;?>/<?=$apt;?>.</span></li>
        </ol>

        <p>Thanks for using the Image Server!</p>
      </div>

      <a href="<?=base_url();?><?=$welcome;?>/index">Done</a>
