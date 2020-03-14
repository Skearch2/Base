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
                    <a href="myskearch/auth/signup" class="btn btn-danger" role="button">Sign Up</a>
                    <a href="myskearch/auth/login" class="btn btn-danger" role="button">Login</a>
                <?php endif ?>
                <a class="theme-change" onclick="changeTheme()" title="Change theme">
                    <div class="theme-change icon"></div>
                </a>
            </div>
        </div>
    </div>
</nav>