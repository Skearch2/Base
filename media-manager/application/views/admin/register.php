<!-- Start register.php -->

<?php
  // Ensure that this is an admin
  if ( !$this -> ion_auth -> logged_in() || $this -> ion_auth -> user() -> row() -> id != $this -> config -> item('admin_id') ) {
    redirect( base_url( $this -> config -> item('welcome_class') ) );
  }
 ?>
<?php
  $admin      = $this -> config -> item('admin_class');

  $appname    = $this -> config -> item('data_appname');
  $firstname  = $this -> config -> item('data_firstname');
  $lastname   = $this -> config -> item('data_lastname');
  $telephone  = $this -> config -> item('data_telephone');
  $email      = $this -> config -> item('data_email');
  $password   = $this -> config -> item('data_password');
  $confirm    = $this -> config -> item('data_confirm');
 ?>

  <div id="register-user" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="form-horizontal" method="POST" action="<?=base_url($admin);?>/register" role="form">

          <div class="modal-header">
            <button class="close" data-dismiss="modal">&times;</button>
            <h2 class="form-signin-heading">Registration</h2>
          </div>

          <div class="modal-body">

            <div class="form-group">
              <label for="<?=$appname;?>" class="control-label col-md-3">App name</label>
              <div class="col-md-9">
                <input type="text" name="<?=$appname;?>" id="<?=$appname;?>"
                       class="form-control" placeholder="App name" required autofocus>
              </div>
            </div>

              <br>

            <div class="form-group">
              <label for="<?=$firstname;?>" class="control-label col-md-3">First name</label>
              <div class="col-md-9">
                <input type="text" name="<?=$firstname;?>" id="<?=$firstname;?>"
                       class="form-control" placeholder="First name" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="<?=$lastname;?>" class="control-label col-md-3">Last name</label>
              <div class="col-md-9">
                <input type="text" name="<?=$lastname;?>" id="<?=$lastname;?>"
                       class="form-control" placeholder="Last name" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="<?=$telephone;?>" class="control-label col-md-3">Telephone</label>
              <div class="col-md-9">
                <input type="tel" name="<?=$telephone;?>" id="<?=$telephone;?>"
                       class="form-control" placeholder="Telephone" required autofocus>
              </div>
            </div>

              <br>

            <div class="form-group">
              <label for="<?=$email;?>" class="control-label col-md-3">Email address</label>
              <div class="col-md-9">
                <input type="email" name="<?=$email;?>" id="<?=$email;?>"
                       class="form-control" placeholder="Email address" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="<?=$password;?>" class="control-label col-md-3">Password</label>
              <div class="col-md-9">
                <input type="password" name="<?=$password;?>" id="<?=$password;?>"
                       class="form-control" placeholder="Password" required autofocus>
              </div>
            </div>

            <div class="form-group">
              <label for="<?=$confirm;?>" class="control-label col-md-3">Confirm</label>
              <div class="col-md-9">
                <input type="password" name="<?=$confirm;?>" id="<?=$confirm;?>"
                       class="form-control" placeholder="Password confirm" required autofocus>
              </div>
            </div>
            </div>


          <div class="modal-footer">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
          </div>

        </form>
      </div>
    </div>
  </div>

<!-- End register.php -->
