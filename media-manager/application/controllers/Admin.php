<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Common_Controller {

  function __construct() {
    parent::__construct();

    // If they are not logged in, direct them to the index page of the welcome class
    if ( !$this -> ion_auth -> is_admin() ) {
      redirect( $this -> welcome . '/index' );
    }
  }

  /**
   *  A simple redirect function that will place the admin at the manage page since
   *    a login was required to reach this state.  See @home
   *
   * @goto ../admin/manage
   *
   */
  public function index() {
    $this -> manage();
  }

  /**
   * A POST collection function that will display the associated user information
   *  including personal information at register and the appid and secret for the
   *  application associated with the user
   *
   * @data POST 'userid' - the identifier of the user
   *
   */
  public function fetch( $userid=0 ) {
    //$userid   = $this -> input -> post( $this -> config -> item('data_userid'), true );
    if ( !$userid || $userid == $this -> config -> item('admin_id') ) {
      $this -> index();
    }
    redirect( $this -> view . "/fetch/$userid" );
  }

  /**
   *  A simple redirect function that will allow the admin to move around administrative
   *  pages implementing administrative functionality.
   *
   * @goto ../admin/*
   *
   */
  public function manage() {
    redirect( $this -> view . '/manage' );
  }

  /**
   *  A simple redirect function that will allow the admin to register a new user
   *    thus giving the user access to editing of their owned albums.
   *
   * @goto ../admin/register
   *
   */
  public function newuser() {
    redirect( $this -> view . '/register' );
  }

  /**
   * A POST collection function that will gather the information the admin has
   *  provided for the new user's details and create a new user.  This in turn
   *  will create a new appid, apikey, and secret string to be passed via application
   *  requests.  Neither the user or admin will be allowed to view apikeys but admin
   *  can view the appid and secret string for submission purposes.
   *
   * @data POST 'appname' - the name of the app that will be associated with the user
   * @data POST 'firstname' - the first name of the user
   * @data POST 'lastname' - the last name of the user
   * @data POST 'telephone' - the phone number of the user for contact purposes
   * @data POST 'email' - the email of the user that will be used as their username
   * @data POST 'password' - the password to allow access via the manager
   * @data POST 'confirm' - the confirmation password to allow access via the manager
   *
   * @goto ../admin/registered
   *
   */
  public function register() {
    // Get POST data
    $appname    = $this -> input -> post( $this -> config('data_appname'), true );
    $firstname  = $this -> input -> post( $this -> config('data_firstname'), true );
    $lastname   = $this -> input -> post( $this -> config('data_lastname'), true );
    $telephone  = $this -> input -> post( $this -> config('data_telephone'), true );
    $email      = $this -> input -> post( $this -> config('data_email'), true );
    $password   = $this -> input -> post( $this -> config('data_password'), true );
    $confirm    = $this -> input -> post( $this -> config('data_confirm'), true );

    if ( strlen($password) < 8 || $password != $confirm ) {
      $this -> register();
    }

    $username = $email;
    $additional_data = array(
        'first_name'  => $firstname,
        'last_name'   => $lastname,
        'phone'       => $telephone
      );

    // Pass to the model to deal with
    $id = $this -> ion_auth -> register( $username, $password, $email, $additional_data );
    if ( !$id ) {
      $this -> index();
    }

    $appid = $this -> adminator -> newUser( $id, $appname );
    if ( !$appid ) {
      $this -> index();
    }

    redirect( $this -> view . "/registered/$appid" );
  }

  /**
   *  A simple redirect function that will allow the admin to select a registered
   *    user providing details about the user.
   *
   * @goto ../admin/fetch
   *
   */
  public function selectuser() {
    redirect( $this -> view . '/selectuser' );
  }

}
