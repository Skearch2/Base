<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_Controller extends CI_Controller {

  protected $view;

  protected $main;

  protected $welcome;

  function __construct() {
    parent::__construct();

    $this -> load -> model( $this -> config -> item( 'curl_model' ), 'curler' );
    $this -> load -> model( $this -> config -> item('admin_model'), 'adminator' );
    // Load the common used URLs, i.e. the controllers that will be used for this
    //  server
    $this -> view     = base_url( $this -> config -> item( 'view_class' ) );
    $this -> main     = base_url( $this -> config -> item( 'main_class' ) );
    $this -> welcome  = base_url( $this -> config -> item( 'welcome_class' ) );
    $this -> admin    = base_url( $this -> config -> item( 'admin_class' ) );

  }

  /**
   * A common helper function that is used to grab configuration elements.
   *
   *  @param string - the name of the config item
   *
   *  @return the request config item
   */
  protected function config( $item ) {
    return $this -> config -> item( $item );
  }

  /**
   *
   *
   *
   *
   */

}

?>
