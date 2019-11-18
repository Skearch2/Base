<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logging {

  function __construct() {

  }

  function __destruct() {

  }

  public function log( $location='' ) {
    // Let's grab everything we want
    $data = array(
        print_r( $_REQUEST, true )
      );

	$filename = $location . 'log-' . date( 'Y-m-d', time() ) . '.php';

    file_put_contents( $filename, $data, FILE_APPEND );
  }

}

?>
