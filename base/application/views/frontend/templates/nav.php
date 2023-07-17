<nav class="index-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 login-bar">
                <?php if ($this->ion_auth->logged_in()) : ?>
                    <span class="member-welcome">Hello <?= ucfirst($this->session->userdata('username')) ?></span>
                    <?php if ($this->ion_auth->is_admin()) : ?>
                        <a href="<?= site_url('admin') ?>" class="btn btn-danger" role="button">Admin Panel</a>
                    <?php endif ?>
                    <a href="myskearch" class="btn btn-danger" role="button">MySkearch</a>
                    <a href="myskearch/auth/logout" class="btn btn-danger" role="button">Logout</a>
                <?php else : ?>
                    <a href="myskearch/auth/login" class="btn btn-danger" role="button">Sign in</a>
                    <!--span>Not a Member?</span-->
                    <a href="myskearch/auth/signup" class="btn btn-danger" role="button">Get Started</a>
                <?php endif ?>
                <a class="theme-change" onclick="changeTheme()" title="Change theme">
                    <?php if ($this->session->userdata('settings')->theme == 'auto') : ?>
                        <div class="theme-change icon auto"></div>
                    <?php else : ?>
                        <div class="theme-change icon"></div>
                    <?php endif ?>
                </a>
            </div>
        </div>
    </div>
</nav>