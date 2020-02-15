<nav class="index-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 login-bar">
                <?php if ($this->ion_auth->logged_in()) : ?>
                    <span class="member-welcome">Hello <?= ucwords($user->firstname . " " . $user->lastname); ?></span>
                    <?php if ($this->ion_auth->is_admin()) : ?>
                        <a href="admin" class="btn btn-danger" role="button">Admin Panel</a>
                    <?php endif ?>
                    <a href="myskearch" class="btn btn-danger" role="button">My Skearch</a>
                    <a href="myskearch/auth/logout" class="btn btn-danger" role="button">Logout</a>
                <?php else : ?>
                    <span>Not a Member?</span>
                    <a href="myskearch" class="btn btn-danger" role="button">Sign Up</a>
                    <a href="myskearch/auth/login" class="btn btn-danger" role="button">Login</a>
                <?php endif ?>
                <a class="theme-change" href="#">
                    <img src="<?= base_url(ASSETS) ?>/frontend/images/moon_theme.png" class="theme-change moon" alt="" />
                    <img src="<?= base_url(ASSETS) ?>/frontend/images/sun_theme.png" class="theme-change sun" alt="" />
                </a>
            </div>
        </div>
    </div>
</nav>