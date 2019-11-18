<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminator extends Common_Model {

  function __construct() {
    parent::__construct();

    // Load admin variables
    if ( !defined('USER_QUERY') ) {
      define( 'USER_QUERY',         $this -> config -> item( 'user_query' ) );
      define( 'USERINFO_QUERY',     $this -> config -> item( 'userinfo_query' ) );
      define( 'USERCOUNT_QUERY',    $this -> config -> item( 'usercount_query' ) );
    }
  }

  /**
   * A function to request information from the ImageServer relating to a newly
   *  registered user/app.  The information will contain multiple pieces of
   *  information that should be provided for accessing the ImageServer.  This
   *  is similar to the getAppInfo function.
   *
   * @param integer - the identifier of the application associated with a user
   *
   */
  public function getAppDetails( $pAppId ) {
    $curl = $this -> admin_curl( 'get', "keys/$pAppId" );
    return $this -> decode($curl['xml']);
  }

  /**
   * A function to request information from the ImageServer relating to a newly
   *  registered user/app.  The information will contain multiple pieces of
   *  information that should be provided for accessing the ImageServer.  This
   *  is similar to the getAppInfo function.
   *
   * @param integer - the identifier of the application associated with a user
   *
   */
  public function getAppInfo( $pUserId ) {
    $curl = $this -> admin_curl( 'get', 'keys', array(), $pUserId );
    return $this -> decode($curl['xml']);
  }

  /**
   * A function to request information from the ImageServer relating to a newly
   *  registered user.  The information will contain multiple pieces of information
   *  on the user.
   *
   * @param integer - the identifier of the user
   *
   */
  public function getUserInfo( $pUserId ) {
    $user = $this -> db -> query( USERINFO_QUERY );
    if ( !$user ) {
      return array();
    }
    return $user -> result()[0];
  }

  /**
   * A function to find out how many users are currently registered on the Manager.
   *
   * @return integer - the number of users currently registered minus the admin of course
   *
   */
  public function getUserCount() {
    $count = $this -> db -> query( USERCOUNT_QUERY );
    if ( !$count ) {
      return 0;
    }
    $usercountas = $this -> config -> item('field_usercount');
    return $count -> result()[0] -> {$usercountas};
  }

  /**
   * A function to request the user ids and the username used for that user.
   *
   * @return DBobject - each user's id and username
   *
   */
  public function getUsers() {
    $users = $this -> db -> query( USER_QUERY );
    if ( !$users ) {
      return array();
    }
    return $users -> result();
  }

// @todo userid can be passed to the appInfo instead of returning this appid and
//      passing to appDetails
  /**
   * A function to build a new user and request new details via the ImageServer
   *  where the user will be identified by the userid.
   *
   * @data integer - the identifier of the user
   * @data string - the name of application to be associated with the user
   *
   * @return integer - the application id
   *
   */
  public function newUser( $pUserId, $pAppname ) {
    $curl = $this -> admin_curl( 'post', 'keys', array( _IS_DATA_USERS_ => $pUserId, _IS_DATA_APPNAME_ => $pAppname ) );
    return $this -> decode($curl['xml']) -> {_FIELD_APP_ID_};
  }

  /**
   * Directs the admin to the proper admin site versus the manager site.
   *
   * @param string - the method and any parameters to be sent to the ImageServer
   *           via the Admin site
   *
   * @return string - the url of the admin site with the desired ending
   *
   */
  private function admin_site( $pUrlEnd='' ) {
    return ADMINPATH . $pUrlEnd;
  }

  /**
   * A cURLer to the admin site of the ImageServer, making requests where only admin
   *  should be allowed access.
   *
   */
  private function admin_curl( $method='get', $class='', $data=array(), $userid='' ) {
    // Load the cURL library
    $this -> load -> library('curl');
    $this -> load -> helper('url');
    // We build the curl request
    $this -> curl -> create( $this -> admin_site( $class ) );
    $this -> curl -> {$method}( $data );
    $this -> curl -> http_header( _IS_HEADER_APIKEY_, $this -> config -> item('imageserver_admin_apikey') );
    $this -> curl -> http_header( _IS_HEADER_SECRET_, $this -> config -> item('imageserver_admin_secret') );
    $this -> curl -> http_header( _IS_HEADER_USERID_, ( !$userid ? $this -> ion_auth -> user() -> row() -> id : $userid ) );

    // We send the curl request and grab data we want
    $xml = $this -> curl -> execute();
    $info = $this -> curl -> info;
    $code = $info['http_code'];

    // @todo - May need to return more than this
    return array(
        'code'  => $code,
        'xml'   => $xml
    );
  }

}
