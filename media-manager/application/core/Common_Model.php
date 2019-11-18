<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_Model extends CI_Model {

  function __construct() {
    parent::__construct();

    $this -> load -> config( 'imageserver' );

    if ( !defined('ISBASEPATH') ) {
      define( 'ISBASEPATH',                 $this -> config -> item( 'imageserver_basepath' ) );
      define( 'APIPATH',                    ISBASEPATH . $this -> config -> item( 'imageserver_apifolder' ) . '/' );
      define( 'MANAGERPATH',                APIPATH . $this -> config -> item( 'imageserver_frontend_manager' ) . '/' );
      define( 'ACCESSPATH',                 APIPATH . $this -> config -> item( 'imageserver_frontend_access' ) . '/' );
      define( 'MOBILEPATH',                 APIPATH . $this -> config -> item( 'imageserver_frontend_mobile' ) . '/' );
      define( 'ADMINPATH',                  APIPATH . $this -> config -> item( 'imageserver_frontend_admin' ) . '/' );

      define( '_IS_HEADER_APIKEY_',         $this -> config -> item( 'imageserver_header_apikey' ) );
      define( '_IS_HEADER_SECRET_',         $this -> config -> item( 'imageserver_header_secret' ) );
      define( '_IS_HEADER_USERID_',         $this -> config -> item( 'imageserver_header_userid' ) );

      define( '_IS_APPID_',                 $this -> config -> item( 'imageserver_appid' ) );
      define( '_IS_APIKEY_',                $this -> config -> item( 'imageserver_apikey' ) );
      define( '_IS_SECRET_',                $this -> config -> item( 'imageserver_secret' ) );

      define( '_IS_DATA_ALBUMS_',           $this -> config -> item( 'imageserver_data_albums' ) );
      define( '_IS_DATA_IMAGES_',           $this -> config -> item( 'imageserver_data_images' ) );
      define( '_IS_DATA_USERS_',            $this -> config -> item( 'imageserver_data_users' ) );
      define( '_IS_DATA_APPS_',             $this -> config -> item( 'imageserver_data_apps' ) );

      define( '_IS_DATA_TITLE_',            $this -> config -> item( 'imageserver_data_title' ) );
      define( '_IS_DATA_DESCRIPTION_',      $this -> config -> item( 'imageserver_data_description' ) );
      define( '_IS_DATA_APPNAME_',          $this -> config -> item( 'imageserver_data_appname' ) );
      define( '_IS_DATA_URL_',              $this -> config -> item( 'imageserver_data_url' ) );
      define( '_IS_DATA_FILENAME_',         $this -> config -> item( 'imageserver_data_filename' ) );
      define( '_IS_DATA_LEVEL_',            $this -> config -> item( 'imageserver_data_level' ) );
      define( '_IS_DATA_LIMIT_',            $this -> config -> item( 'imageserver_data_limit' ) );

      define( '_IS_DATA_USERFILE_',         $this -> config -> item( 'imageserver_data_userfile' ) );

      define( '_IS_RESPONSE_CODE_',         $this -> config -> item( 'imageserver_response_code' ) );
      define( '_IS_RESPONSE_MESSAGE_',      $this -> config -> item( 'imageserver_response_message' ) );
      define( '_IS_RESPONSE_ERROR_',        $this -> config -> item( 'imageserver_response_error' ) );

      define( '_FIELD_ALBUM_ID_',           $this -> config -> item( 'imageserver_field_album_id' ) );
      define( '_FIELD_ALBUM_TITLE_',        $this -> config -> item( 'imageserver_field_album_title' ) );
      define( '_FIELD_ALBUM_DESCRIPTION_',  $this -> config -> item( 'imageserver_field_album_description' ) );
      define( '_FIELD_ALBUM_IMAGES_',       $this -> config -> item( 'imageserver_field_album_images' ) );

      define( '_FIELD_IMAGE_ID_',           $this -> config -> item( 'imageserver_field_image_id' ) );
      define( '_FIELD_IMAGE_TITLE_',        $this -> config -> item( 'imageserver_field_image_title' ) );
      define( '_FIELD_IMAGE_DESCRIPTION_',  $this -> config -> item( 'imageserver_field_image_description' ) );
      define( '_FIELD_IMAGE_FILENAME_',     $this -> config -> item( 'imageserver_field_image_filename' ) );

      define( '_FIELD_APP_ID_',             $this -> config -> item( 'imageserver_field_app_id' ) );

      define( '_IS_MANAGER_NEWUSER_QUERY_', $this -> config -> item( 'query_last_insert_id' ) );
    }
  }

  /**
   * A common function allowing the models to reach the ImageServer consistently.
   *  If the ImageServer were to change locations, config/imageserver.php must be
   *  changed to accomodate this modification.
   *
   * @param string - the url after the ImageServer's base path
   *
   * @return string - the full url for the ImageServer and it's ending
   *
   */
  protected function that_site( $pEnd ) {
    return MANAGERPATH . $pEnd;
  }

  /**
   * A function to convert an XML format into an array format.
   * 	This function is mostly for use within the other parsers
   * @param string $pXmlStr - XML formatted string to break down to
   * 		an array
   */
  protected function parse_xml_into_array( $pXmlStr ) {
    // This is to accomodate for when only one album is passed since the single
    //   album will not be encapsulated by an item tag
    if ( strpos( $pXmlStr, '<xml><item>' ) == false ) {
      $pXmlStr = str_replace( '<xml>', '<xml><item>', $pXmlStr );
      $pXmlStr = str_replace( '</xml>', '</item></xml>', $pXmlStr );
    }
    // Create an XML parser to process the results, parse the XML into an
    // array and free the parse
    $p = xml_parser_create();
    xml_parse_into_struct ( $p, $pXmlStr, $vals, $index );
    xml_parser_free ( $p );

    // Return
    return array ( 'vals' => $vals, 'index' => $index );
  }

  /**
   * A private function to convert an XML string into an stdObject for easy HTML
   *  building.  The method simply converts the XML string into an SimpleXMLObject,
   *  encoding that into JSON, and lastly decoding that JSON encoding.
   *
   * @param string - the XML String to parse
   *
   */
  protected function decode( $pXmlStr ) {
    return json_decode( json_encode( simplexml_load_string( $pXmlStr ), 1 ) );
  }

  /**
   * A common helper function to make an HTTP GET request.  A class for the ImageServer
   *  and data that is to be passed is required.
   *
   * @param string - the class that is to be called via the manager class in the
   *      ImageServer
   *
   */
  protected function get( $class='', $data=array(), $directaccess=0 ) {
    return $this -> _curl( 'get', $class, $data, $directaccess );
  }

  /**
   * A common helper function to make an HTTP POST request.  A class for the ImageServer
   *  and data that is to be passed is required.
   *
   * @param string - the class that is to be called via the manager class in the
   *      ImageServer
   *
   */
  protected function post( $class='', $data=array(), $directaccess=0 ) {
    return $this -> _curl( 'post', $class, $data, $directaccess );
  }

  /**
   * A common helper function to make an HTTP PUT request.  A class for the ImageServer
   *  and data that is to be passed is required.
   *
   * @param string - the class that is to be called via the manager class in the
   *      ImageServer
   *
   */
  protected function put( $class='', $data=array(), $directaccess=0 ) {
    return $this -> _curl( 'put', $class, $data, $directaccess );
  }

  /**
   * A common helper function to make an HTTP DELETE request.  A class for the ImageServer
   *  and data that is to be passed is required.
   *
   * @param string - the class that is to be called via the manager class in the
   *      ImageServer
   *
   */
  protected function delete( $class='', $data=array() ) {
    return $this -> _curl( 'delete', $class, $data );
  }

  /*
   |-----------------------------------------------------------------------|
   |	cURLer
   |-----------------------------------------------------------------------|
   */

   /**
    * A private function to perform cURL requests.  There is a method to perform
    * simple cURL requests; however, this way of doing the requests does not allow
    * the HTTP Responses to be caught by the method.  Instead, it just throws it
    * to the wed browser.
    * <p>
    * The first parameter passed in should indicate what type of HTTP Request should
    * be made.  Next the URL, and finally the data that should be passed to the URL.
    * </p>
    * @param string - the HTTP Request to be made
    * @param string - the URL from the imageserver index.php control
    * @param array - the data that should be passed to the server
    *
    * @return array
    *		'xml' => the XML returned by the server
    *		'code' => the HTTP Response code
    *
    */
  private function _curl( $method='get', $class='', $data=array(), $directaccess=0 ) {

    $admin_group_id = (int) $this -> config -> item( 'admin_group_id' );

    if ($this->ion_auth->in_group( $admin_group_id ))
    {
      // Load the cURL library
      $this -> load -> library('curl');
      $this -> load -> helper('url');

      // We build the curl request

      if ($directaccess == 1) {
          $this -> curl -> create( ISBASEPATH . $class );
          $this -> curl -> {$method}( $data );

      } else if ($directaccess == 0) {
        $this -> curl -> create( $this -> that_site( $class ) );
        $this -> curl -> {$method}( $data );
      }

      $this -> curl -> http_header( _IS_HEADER_APIKEY_, _IS_APIKEY_ );
      $this -> curl -> http_header( _IS_HEADER_SECRET_, _IS_SECRET_ );
      $this -> curl -> http_header( _IS_HEADER_USERID_, $admin_group_id );

      // We send the curl request and grab data we want
      $xml = $this -> curl -> execute();
      $info = $this -> curl -> info;
      $code = $info['http_code'];

      //print_r($xml); die();

      log_message( 'debug', "Returned from " . $this -> that_site( $class ) . " with code: $code, xml: $xml" );

      // @todo - May need to return more than this
      return array(
          'code'  => $code,
          'xml'   => $xml
      );
    }
  }

}

?>
