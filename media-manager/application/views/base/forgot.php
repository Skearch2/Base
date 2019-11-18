 <!-- Start forgot content -->

 <?php
      $welcome    = $this -> config -> item('welcome_class');
      $email      = $this -> config -> item('data_email');
    ?>

    <form class="form-signin" method="POST" action="<?=base_url();?><?=$welcome;?>/reminder">

        <h2 class="form-signin-heading">Request a password reset</h2>

        <p>Please enter your email so we can send you a password reset code.</p>

        <label for="<?=$email;?>" class="sr-only">Email address</label>
        <input type="email" name="<?=$email;?>" id="<?=$email;?>" class="form-control" placeholder="Email address" required autofocus>

        <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Send reset</button>

      </form>

<!-- End forgot content -->
