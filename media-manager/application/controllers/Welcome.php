<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Image Server is a backend server that stores images into albums for users
 *  to easily pull the contents of these albums.  This can be used in many ways
 *  but was origianally engineered to make custom advertisement queues.
 *
 * This is a welcome class that will serve as the initial page for a user, not
 *  requiring login thus allowing the user to perform the actual login process.
 *  By separating the functions that should be accessible to all users, this puts
 *  restriction on the functions that should not be accessible for
 *
 */
class Welcome extends Common_Controller {

  function __construct() {
    parent::__construct();

    if (!$this -> ion_auth -> is_admin()) {
      $base_url  = $this -> config -> item('base_domain');
      redirect( $base_url . 'admin' );
    }

    $segment = $this -> uri -> segment( 2, 0 );
    if ( $segment != 'logout' ) {
      // If they are already logged in, direct to the main controller
      if ( $this -> ion_auth -> logged_in() ) {
        redirect( $this -> main );
      }
    }
  }

  /**
   * A redirect function to move the user to the index page of the view.
   *
   * @goto ../view/index
   */
  public function index() {
    redirect(  $this -> view );
  }

  /**
   * A redirect function to prompt the user for their email for a password reset
   *
   * @goto ../view/forgot
   */
  public function forgot() {
    redirect( $this -> view . '/forgot' );
  }

  /**
   * A redirect function that sends the user to the login screen.  The login screen
   *  will send the data to the signin function
   *
   * @goto ../view/login
   */
  // public function login() {
  //   redirect(  $this -> view . '/login' );
  // }

  /**
   * A redirect function that sends the user to the logout screen.
   *
   * @goto ../view/index
   */
  // public function logout() {
  //   $logout = $this -> ion_auth -> logout();
  //   $this -> index();
  // }

  /**
   * A POST collection functoin to aid users who have forgotten their passwords.
   *    All they need is the email they registered under.  A confirmation will be
   *    sent to that email.
   *
   * @data POST 'email' - the email the user was registered under
   *
   */
  public function reminder() {
    $email = $this -> input -> post( $this -> config -> item( 'data_email' ), true );

    $this -> ion_auth -> forgotten_password( $email );

    $this -> login();
  }

  /**
   * A POST collection function that will sign the user in.  The function requires
   *  an email, password, and a flag signifying whether the user should be remembered
   *  or not.  If incorrect credentials are given, the user is redirected back to
   *  the index page.  On a successful login, the user is sent to the home page.
   *
   * @goto ../view/home
   */
  public function signin() {
    // Grab the POST data
    $email    = $this -> input -> post( $this -> config -> item( 'data_email' ), true );
    $password = $this -> input -> post( $this -> config -> item( 'data_password'), true );
    $remember = $this -> input -> post( $this -> config -> item( 'data_rememberme'), true );
    // try to login
    $loggedin = $this -> ion_auth -> login( $email, $password, $remember );

    redirect( ( !$loggedin ? $this -> welcome : $this -> main ) );
  }

}

?>
