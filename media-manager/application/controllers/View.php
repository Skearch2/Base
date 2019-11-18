<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View extends Common_Controller {

  /**
   * A payload to send via the view load.  This array will be sent to the template
   *  view which will load pages, passing the keys as variables on the page.
   *  Thus, to take advantage of this ability, the details will hold an array to
   *  dynamically load the page name and css file, as well as, the scripts to be
   *  loaded in the footer.  A file and data can be designated to load a specific
   *  view file, relative to the views directory, and data to be used as those inner
   *  variables respectively.  The details array is initialized to be the index page
   *  thus avoiding unneccessary PHP errors, variable not set.  All functions will
   *  alter the details array to their liking and end with $this -> go() to perform
   *  the actual view loading.
   *
   */
  private $details;
  protected $default;
  protected $global;
  protected $umbrella;
  protected $field;
  protected $uri;

  function __construct() {
    parent::__construct();

    // Sets public views that can be viewed by anyone and private views that can
    //    only be viewed as the admin
    $public = array( 'forgot', 'index', 'login' );
    $private = array( 'fetch', 'manage', 'register', 'registered', 'selectuser' );
    // Check which function has been called and kick unauthorized views out
    $segment = $this -> uri -> segment( 2, 0 );
    if ( $segment && !in_array( $segment, $public ) ) {
      // We need to check their login in
      if ( !$this -> ion_auth -> logged_in() ) {
        redirect( $this -> welcome );
      }
      // Admins only
      if ( in_array( $segment, $private ) ) {
        if ( !$this -> ion_auth -> is_admin() ) {
          redirect( $this -> welcome );
        }
      }
    }

    // We default the values to ensure that a PHP error: variable not found is not thrown
    $this -> details['head'] = array( 'page' => '1.0.0', 'theme' => 'theme.css' );
    $this -> details['file'] = 'base/landing';
    $this -> details['data'] = array();
    $this -> details['foot'] = array( 'scripts' => array(), 'styles' => array() );
    // Alternatively, one could check if the variables are set in the template file and
    //    default to these values on false
    $this -> uri = $this -> config -> item('api_get_data');

    $this -> default = $this -> config -> item('album_default');
    $this -> global = $this -> config -> item('album_global');
    $this -> umbrella = $this -> config -> item('album_umbrella');
    $this -> field = $this -> config -> item('album_field');

  }

  /**
   * A view function that builds a page to submit data via the main/createalbum
   *  function.
   *
   * @goto ../main/createalbum
   */
  public function createalbum() {

    // if ($pAlbumType !== $this -> global && $pAlbumType !== $this -> umbrella && $pAlbumType !== $this -> field) {
    //   redirect( $this -> view . "/createalbum/$this->global" );
    // }

    $this -> details['head'] = array(
        'page'  => 'Create an Album',
        'theme'  => 'signin.css'
      );
    $this -> details['file'] = 'albums/createalbum';

    // // get albums of type umbrella
    // if ($pAlbumType === $this -> umbrella) {
    //     $url = $this -> uri . $this -> umbrella;
    //     $data = file_get_contents($url);
    //     $this -> details['umbrellas'] = json_decode($data);
    // }
    //
    // // get albums of type field
    // else if ($pAlbumType === $this -> field) {
    //     $url = $this -> uri . $this -> field;
    //     $data = file_get_contents($url);
    //     $this -> details['fields'] = json_decode($data);
    // }

    $this -> go();
  }

  /**
   * A view function that builds a page to submit data via the main/createimage
   *  function.  This function will display the current images associated with
   *  the album so the user will know what they have alread submitted.
   *
   * @param integer - the identifier of the album to add to
   *
   * @goto ../main/createimageglobal
   *
   */
  public function createimage( $pAlbumType, $pAlbumTypeId, $pKeyword, $pAlbumId ) {
    $this -> details['head'] = array(
        'page'  => 'Add an Image',
        'theme' => 'add-images.css'
      );
    $this -> details['file'] = 'images/createimage';
    $this -> details['data'] = array(
        'albumtype' => $pAlbumType,
        'albumtypeid' => $pAlbumTypeId,
        'keyword' => $pKeyword,
        'album' => $this -> curler -> getAlbumOnly( $pAlbumId )

      );
    $this -> go();
  }

  /**
   * A view function that builds a page to submit data via the main/createimageglobal
   *  function.  This function will display the current images associated with
   *  the global album so the user will know what they have alread submitted.
   *
   * @param integer - the identifier of the album to add to
   *
   * @goto ../main/createimageglobal
   *
   */
  public function createimageglobal( $pAlbumId ) {
    $this -> details['head'] = array(
        'page'  => 'Add an Image',
        'theme' => 'add-images.css'
      );
    $this -> details['file'] = 'images/createimageglobal';
    $this -> details['data'] = array(
        'images'  => $this -> curler -> getAlbum( $pAlbumId ),
        'album' => $this -> curler -> getAlbumOnly( $pAlbumId )
      );
    $this -> go();
  }

  /**
   * A view function that builds a page to resubmit data via the main/updatealbum
   *  function.  This function will fill in the current values associated with the
   *  album so far.
   *
   * @param integer - the identifier of the album to be modified
   *
   * @goto ../main/editalbum
   *
   */
  public function editalbum( $pAlbumId ) {

    $this -> details['head'] = array(
          'page'  => 'Edit an Album',
          'theme' => 'add-images.css'
      );
    $this -> details['file'] = 'albums/editalbum';
    $this -> details['data'] = array(
          'album' => $this -> curler -> getAlbumOnly( $pAlbumId )
      );
    $this -> details['album_type'] = $albumType = $this -> details['data']['album']->albumtype;

    if ($albumType === $this -> umbrella) {
        $url = $this -> uri . $this -> umbrella;
        $data = file_get_contents($url);
        $this -> details['umbrellas'] = json_decode($data);
    }

    else if ($albumType === $this -> field) {
        $url = $this -> uri . $this -> field;
        $data = file_get_contents($url);
        $this -> details['fields'] = json_decode($data);
    }

    $this -> go();
  }

  /**
   * A view function that builds a page to resubmit data via the main/updateimage
   *  function.  This function will fill in the current values associated with the
   *  image so far also allowing the user to upload an image or delete it.
   *
   * @param integer - the identifier of the image to be modified
   *
   * @goto ../main/editimageglobal
   *
   */
  public function editimageglobal( $pImageId ) {
    $this -> details['head'] = array(
          'page'  => 'Edit an Image',
          'theme' => 'theme.css'
      );
    $this -> details['file'] = 'images/editimageglobal';
    $this -> details['data'] = array(
          'image' => $this -> curler -> getImage( $pImageId )
      );

    $aid = $this -> config -> item('imageserver_data_albums');
    $atitle = $this -> config -> item('imageserver_data_title');

    $albumid = $this -> details['data']['image']-> $aid;
    $this -> details['data']['album'] = $this -> curler -> getAlbumOnly( $albumid );

    $this -> go();
  }

  /**
   * A view function that builds a page to resubmit data via the main/updateimage
   *  function.  This function will fill in the current values associated with the
   *  image so far also allowing the user to upload an image or delete it.
   *
   * @param integer - the identifier of the image to be modified
   *
   * @goto ../main/editimage
   *
   */
  public function editimage( $pAlbumType, $pAlbumTypeId, $pKeyword, $pImageId ) {
    $this -> details['head'] = array(
          'page'  => 'Edit an Image',
          'theme' => 'theme.css'
      );
    $this -> details['file'] = 'images/editimage';
    $this -> details['data'] = array(
          'albumtype' => $pAlbumType,
          'albumtypeid' => $pAlbumTypeId,
          'keyword' => $pKeyword,
          'image' => $this -> curler -> getImage( $pImageId )
      );

    $aid = $this -> config -> item('imageserver_data_albums');
    $atitle = $this -> config -> item('imageserver_data_title');

    $albumid = $this -> details['data']['image']-> $aid;
    $this -> details['data']['album'] = $this -> curler -> getAlbumOnly( $albumid );

    $this -> go();
  }

  /**
   * A view function that builds a page to display information about the user and
   *  app details that must be sent as the initial payload for an apikey.
   * @required Admin Login
   *
   * @param integer - the identifier of the user to get information on
   *
   */
  public function fetch( $pUserId ) {
    $this -> details['head'] = array(
        'page'  => 'User Information',
        'theme' => 'theme.css'
      );
    $this -> details['file'] = 'admin/fetch';
    $this -> details['data'] = array(
        'user' => $this -> adminator -> getUserInfo( $pUserId ),
        'app'  => $this -> adminator -> getAppInfo( $pUserId )
      );
    $this -> go();
  }

  /**
   * A view function that builds a page to submit their email via the welcome/forgot
   *  function.
   *
   *  @goto ../view/forgot
   */
  public function forgot() {
      $this -> details['head'] = array(
          'page'  => 'Forgot Password',
          'theme' => 'theme.css'
        );
      $this -> details['file'] = 'base/forgot';
      $this -> go();
  }

  /**
   * A view function that gets all albums associated with the current user to display
   *  and allow for deletion, addition, resubmission, or creation of an album.
   *  The function will pass two pieces of core information: all albums and their
   *  assciated albums and an albumid of the default album.
   *
   */
  public function home() {

    // get umbrellas
    $url = $this -> uri . $this -> umbrella;
    $data = file_get_contents($url);
    $this -> details['umbrellas'] = json_decode($data);

    // get fields
    $url = $this -> uri . $this -> field;
    $data = file_get_contents($url);
    $this -> details['fields'] = json_decode($data);

    $this -> details['head'] = array(
        'page'  => 'Home',
        'theme' => 'theme.css'
      );
    $this -> details['file'] = 'base/home';
    $this -> details['data'] = array(
        //'albums'  => $this -> curler -> getAllAlbums(),
        'albums_default'  => $this -> curler -> getAlbums($this -> default),
        'albums_global'  => $this -> curler -> getAlbums($this -> global)
        //'albums_umbrella'  => $this -> curler -> getAlbums($this -> umbrella),
        //'albums_field'  => $this -> curler -> getAlbums($this -> field),
        //'default' => $this -> curler -> getDefault()
      );
    $this -> go();
  }

  /**
   * A view function that will not only be used as the frontend for all function
   *  in this class, but also the default for this class.  If not logged in, the
   *  page would be displayed as a generic welcome page.  The function sends the
   *  details array into the template file located at ./views/template.php.
   *
   */
  public function index() {
    $this -> load -> view( $this -> config('frontend_view'), $this -> details );
  }

  /**
   * A view function that will prompt the user for login credentials (registered
   *  in the database) to allow access of main functionality.
   *
   * @goto ../welcome/login
   *
   */
  public function login() {
    $this -> details['head'] = array(
        'page'  => 'Login',
        'theme' => 'signin.css'
      );
    $this -> details['file'] = 'base/login';
    $this -> go();
  }

  /**
   * A view function that will allow the admin to see features that an admin can
   *  do.  This page mostly serves like a home page for administration purposes.
   * @required Admin Login
   *
   * @goto ../admin/*
   *
   */
  public function manage() {
    $this -> details['head'] = array(
        'page'  => 'Management',
        'theme' => 'theme.css'
      );
    $this -> details['file'] = 'admin/manage';
    $this -> details['data'] = array(
        'users' => $this -> adminator -> getUsers()
      );
    $this -> go();
  }

  /**
   * A view function that will prompt the admin for register information allowing
   *  a user access to the Manager and edit information about their albums.
   * @required Admin Login
   *
   * @goto ../admin/register
   *
   */
  public function register() {
    $this -> details['head'] = array(
        'page'  => 'Register a User',
        'theme' => 'signin.css'
      );
    $this -> details['file'] = 'admin/register';
    $this -> go();
  }

  /**
   * A view function that will display the results of the user that was recently
   *  registered.  This page will display instructions on how to configure an
   *  application correctly with the required material.
   * @required Admin Login
   *
   * @param integer - the identifier of the application that was registered
   *
   */
  public function registered( $pAppId ) {
    $this -> details['head'] = array(
        'page'  => 'User Registered',
        'theme' => 'theme.css'
      );
    $this -> details['file'] = 'admin/registered';
    $this -> details['data'] = array(
        'app'  => $this -> adminator -> getAppDetails( $pAppId )
      );
    $this -> go();
  }

  /**
   * A view function that builds a page to choose a user to get information on.
   * @required Admin Login
   *
   * @goto ../admin/fetch/{userid}
   *
   */
  /*
  public function selectuser() {
    $this -> details['head'] = array(
        'page'  => 'Select a User',
        'theme' => 'signin.css'
      );
    $this -> details['file'] = 'admin/selectuser';
    $this -> details['data'] = array(
        'users' => $this -> adminator -> getUsers()
      );
    $this -> go();
  }
  */

  /**
   * A view function that builds a page to submit data via the main/createimageglobal
   *  function.  This function will display the current images associated with
   *  the global album so the user will know what they have alread submitted.
   *
   * @param integer - the identifier of the album to add to
   *
   * @goto ../main/createimageglobal
   *
   */
  public function viewalbumglobal( $pAlbumId, $pArchived=0 ) {
    $this -> details['head'] = array(
        'page'  => 'Add an Image',
        'theme' => 'theme.css'
      );
    $this -> details['file'] = 'albums/viewalbumglobal';
    $this -> details['data'] = array(
        'images'  => $this -> curler -> getAlbum( $pAlbumId, $pArchived ),
        'album' => $this -> curler -> getAlbumOnly( $pAlbumId, $pArchived ),
        'archived' => $pArchived
      );

    //echo "<pre>"; print_r($this -> details['data']['images']);

    $this -> go();
  }


  /**
   * A view function that builds a page to view albums via the main/viewalbum
   *  function.
   *
   * @goto ../main/viewalbum
   */
  public function viewalbum($pAlbumType, $pAlbumTypeId) {

    if ($pAlbumType !== $this -> umbrella && $pAlbumType !== $this -> field) {
      redirect( $this -> view . "/home" );
    }

    $this -> details['head'] = array(
        'page'  => 'View '. ucwords($pAlbumType),
        'theme'  => 'theme.css'
      );
    $this -> details['file'] = 'albums/viewalbum';

    // get album ids of given album type and type id
    $albums = $this -> curler -> getAlbumIdByMediaInfo($pAlbumType, $pAlbumTypeId);

    // create albums if not found for the media
    if (!isset($albums->item)) {

      $mediaboxa_albumid = $this -> curler -> newAlbum( "Media Box A", "Media Box A", $pAlbumType, $pAlbumTypeId, "A" );

      if ($pAlbumType === $this -> umbrella) {
        $mediaboxu_albumid = $this -> curler -> newAlbum( "Media Box U", "Media Box U", $pAlbumType, $pAlbumTypeId, "U" );
      }

      else if ($pAlbumType === $this -> field) {
        $mediaboxb_albumid = $this -> curler -> newAlbum( "Media Box B", "Media Box B", $pAlbumType, $pAlbumTypeId, "B" );
      }

    }
    // retireve album ids for media
    else {

      $mediaboxa_albumid = $albums->item[0]->albumid;

      if ($pAlbumType === $this -> umbrella) {
        $mediaboxu_albumid = $albums->item[1]->albumid;
      }

      else if ($pAlbumType === $this -> field) {
        $mediaboxb_albumid = $albums->item[1]->albumid;
      }

    }

    // get umbrella media
    if ($pAlbumType === $this -> umbrella) {

      $this -> details['data'] = array(
              'mediaboxa_albumid' => $mediaboxa_albumid,
              'mediaboxa_images' => $this -> curler -> getAlbum( $mediaboxa_albumid ),
              'mediaboxu_albumid' => $mediaboxu_albumid,
              'mediaboxu_images' => $this -> curler -> getAlbum( $mediaboxu_albumid )
      );
    }

    // get field media
    else if ($pAlbumType === $this -> field) {

      $this -> details['data'] = array(
              'mediaboxa_albumid' => $mediaboxa_albumid,
              'mediaboxa_images' => $this -> curler -> getAlbum( $mediaboxa_albumid ),
              'mediaboxb_albumid' => $mediaboxb_albumid,
              'mediaboxb_images' => $this -> curler -> getAlbum( $mediaboxb_albumid )
      );
    }


    if ($pAlbumType === $this -> umbrella) {
      // get umbrellas
      $url = $this -> uri . $this -> umbrella;
      $data = file_get_contents($url);
      $umbrellas = json_decode($data);

      // get umbrella name
      foreach ($umbrellas as $umbrella) {
        if ($umbrella->id === $pAlbumTypeId) {
          $this -> details['data']['umbrella'] = $umbrella->title;
          break;
        }
      }

      $this -> details['data']['albumtype'] = $this -> umbrella;
    }

    else if ($pAlbumType === $this -> field) {

      // get fields
      $url = $this -> uri . $this -> field;
      $data = file_get_contents($url);
      $fields = json_decode($data);

      // get field name
      foreach ($fields as $field) {
        if ($field->id === $pAlbumTypeId) {
          $this -> details['data']['field'] = $field->title;
          break;
        }
      }

      $this -> details['data']['albumtype'] = $this -> field;
    }

    $this -> details['data']['albumtypeid'] = $pAlbumTypeId;

    $this -> go();
  }

  /**
   * A view function that serves as a renamed index.
   */
  public function go() {
    $this -> index();
  }

}

?>
