<!-- Start manage.php -->

<?php
  // Ensure that this is an admin
  if ( !$this -> ion_auth -> is_admin() ) {
    redirect( base_url( $this -> config -> item('welcome_class') ) );
  }
 ?>

 <?php
    $admin  = $this -> config -> item('admin_class');

    $uid      = $this -> config -> item('field_userid');
    $uname    = $this -> config -> item('field_username');
  ?>

  <div class="jumbotron">
    <h1>Welcome, Administrator!</h1>
    <p>Welcome to the Manage Page. Here, you can manage users and their information.</p>
    <p>Currently, there are <strong><?=sizeof($users);?></strong> enrolled users!</p>
  </div>

  <?php //print_r($this->session->userdata()); ?>

  <div class="list-group">
      <a class="list-group-item" data-toggle="modal" data-target="#register-user">Register a new user</a>
      <a class="list-group-item" data-toggle="modal" data-target="#select-user">Fetch a user's information</a>
  </div>


    <!-- Start Template -->
        <?php
            $this -> load -> view( 'admin/selectuser', array( 'users' => $users ) );
            $this -> load -> view( 'admin/register' );
         ?>
    <!-- End Template -->

<!-- End manage.php -->
