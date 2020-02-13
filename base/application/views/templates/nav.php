<nav id='navigation_top' style="max-width:100%">
    <?php if ($this->ion_auth->logged_in()) : ?>
        <ul id='member-display'>
            <li><span style='font-weight: lighter;'>Hello <?= ucwords($user->firstname . " " . $user->lastname); ?></span></li>
            <?php if ($this->ion_auth->is_admin()) : ?>
                <li><a href="admin">Admin Panel</a></li>
            <?php endif ?>
            <li><a href="myskearch">My Skearch</a></li>
            <li><a href="myskearch/auth/logout" class="ls">Logout</a></li>
        </ul>
    <?php else : ?>
        <div id='navigation_top_welcome'>
            Not a member?<a href="myskearch/auth/signup" class="ls">Sign Up</a><a href="myskearch" class="ls">Login</a>
        </div>
    <?php endif ?>
</nav>