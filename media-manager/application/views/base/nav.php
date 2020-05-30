<!-- Start nav.php -->

<?php
$welcome  = $this->config->item('welcome_class');
$admin    = $this->config->item('admin_class');
$main     = $this->config->item('main_class');
$base_url  = $this->config->item('base_domain');
?>

<div class="container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= base_url("$main/home"); ?>"><b>Media</b> Server Manager</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNav" class="collapse navbar-collapse">
      <!-- <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="">Media<span class="sr-only">(current)</span></a>
            </li>
          </ul> -->
      <div class="navbar-nav ml-auto">
        <?php
        if ($this->ion_auth->is_admin())
          echo '<a class="btn btn-info" href="' . base_url($admin) . '">Manager User</a>';
        echo '<span>&nbsp;</span>';
        echo '<a class="btn btn-primary" href="' . $base_url . '/admin">Admin Panel</a>';
        ?>
      </div>
    </div>
  </nav>
</div>

<!-- End nav.php -->