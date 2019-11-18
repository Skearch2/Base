<!-- Start selectuser.php -->

<?php
// Ensure that this is an admin
if ( !$this -> ion_auth -> logged_in() || $this -> ion_auth -> user() -> row() -> id != $this -> config -> item('admin_id') ) {
    redirect( base_url( $this -> config -> item('welcome_class') ) );
}
?>

<?php
    $admin  = $this -> config -> item('admin_class');

    $uid      = $this -> config -> item('field_userid');
    $uname    = $this -> config -> item('field_username');
?>


    <div id="select-user" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Select a User</h2>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <?php
                            foreach( $users as $user ) {
                                echo '<a class="list-group-item" href="' . base_url($admin) . '/fetch/' . $user -> {$uid} . '">' . $user -> {$uname} . '</a>' . PHP_EOL;
                            }
                        ?>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

<!-- End selectuser.php -->
