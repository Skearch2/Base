<!-- Start login.php -->
<?php
  $welcome      = $this -> config -> item('welcome_class');

  $email        = $this -> config -> item('data_email');
  $password     = $this -> config -> item('data_password');
  $rememberme   = $this -> config -> item('data_rememberme');
 ?>

      <form class="form-signin" method="POST" action="<?=base_url( "$welcome/signin" );?>">

        <h2 class="form-signin-heading">Please sign in</h2>

        <label for="<?=$email;?>" class="sr-only">Username</label>
        <input type="text" name="<?=$email;?>" id="<?=$email;?>" class="form-control" placeholder="Username" required autofocus>

        <label for="<?=$password;?>" class="sr-only">Password</label>
        <input type="password" name="<?=$password;?>" id="<?=$password;?>" class="form-control" placeholder="Password" required>

        <div class="checkbox">
          <label>
            <input type="checkbox" name="<?=$rememberme;?>" value="remember-me"> Remember me
          </label>
        </div>

	<a href="<?=base_url();?><?=$welcome;?>/forgot">Forgot password?</a>
        <?php //echo anchor_base( base_url( "$welcome/forgot" ), 'Forgot password?'); ?>

        <br>
        <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

      </form>

<!-- End login.php -->
