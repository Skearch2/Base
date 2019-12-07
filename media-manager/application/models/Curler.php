<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curler extends Common_Model {

  function __construct() {
    parent::__construct();
  }

  /**
   * A function that lets the ImageServer know to archive an image from the database
   *  as well as the filesystem
   *
   * @param integer - the identifier of the image to archive
   *
   * @return integer - the albumid that the image was archived from
   *
   */
  public function archiveImage( $pImageId ) {
    $aid  = $this -> config -> item('imageserver_field_album_id');
    $albumid = $this -> getImage( $pImageId ) -> {$aid};

    // disable image
    //$this -> post( "api/npm/active/$pImageId",array(),1 );
    // archive image
    $this -> post( "api/npm/archive/$pImageId",array(),1 );

    return $albumid;
  }

  /**
   * A function that lets the ImageServer know to delete an album and all its
   *  contents.
   *
   * @param integer - the identifier of the album to delete
   *
   */
  public function deleteAlbum( $pAlbumId ) {
    $curl = $this -> delete( "albums/$pAlbumId" );
  }

  /**
   * A function that lets the ImageServer know to delete an image from the database
   *  as well as the filesystem
   *
   * @param integer - the identifier of the image to delete
   *
   * @return integer - the albumid that the image was deleted from
   *
   */
  public function deleteImage( $pImageId ) {
    $aid  = $this -> config -> item('imageserver_field_album_id');
    $albumid = $this -> getImage( $pImageId ) -> {$aid};

    $curl = $this -> delete( "images/$pImageId" );

    return $albumid;
  }

  /**
   * A function that grabs all details of an album given its albumid.  The album,
   *  will contain not only the album information, but all images associated with
   *  the album and the images' individual details as well
   *
   * @param integer - the identifier of the album wanted
   *
   * @return array - an array of a parsed XML Object
   */
  public function getAlbum( $pAlbumId, $pArchived=0 ) {
    // albumtypeid = 0
    $curl = $this -> get( "albums/$pAlbumId/0/$pArchived" );

    return $this -> parse_xml_into_array($curl['xml']);
  }

  /**
   * A function to find out the albumid to which an image belongs to.
   *
   * @param integer - the identifier of the image to be referenced
   *
   * @return integer the albumid of the album this image belongs to
   *
   */
  public function getAlbumId( $pImageId ) {
    $albumid = $this -> config -> item( 'imageserver_field_album_id' );
    return $this -> getImage( $pImageId ) -> {$albumid};
  }

  /**
   * A function to find out the albumid based on media info.
   *
   * @param string - the type of the album
   * @param integer - the id of the type of album
   *
   * @return integer the albumid of the album this image belongs to
   *
   */
  public function getAlbumIdByMediaInfo( $pAlbumType, $pAlbumTypeId) {

    // $albumtypeas      = $this -> config -> item('imageserver_data_albumtype');
    // $albumtypeidas    = $this -> config -> item('imageserver_data_albumtypeid');

    $curl = $this -> get("albums/$pAlbumType/$pAlbumTypeId");

    return $this -> decode($curl['xml']);
  }

  /**
   * A function to retrieve only the album details and drop the contents of the
   *  images.  This is for a smaller loop to avoid unneccessary loading time.
   *
   * @param integer - the identifier of the album requested
   *
   * @return stdObject - the stdObject converted from the XML given by the ImageServer
   */
  public function getAlbumOnly( $pAlbumId, $pArchived=0 ) {
    $curl = $this -> get( "albums/$pAlbumId/$pArchived" );
    return $this -> decode($curl['xml']);
  }

  /**
   * A function that grabs all the albums that are owned by this user.  The albums
   *  will contain not only the descriptive information but also the images and
   *  their descriptive information.
   *
   * @return array - an array of a parsed XML Object
   *
   */
  public function getAllAlbums() {
    $curl = $this -> get( 'albums' );
    return $this -> parse_xml_into_array($curl['xml']);
  }

  /**
   * A function that grabs albums that are owned by this user.  The albums
   *  will contain not only the descriptive information but also the images and
   *  their descriptive information.
   *
   * @param String - the type of the album requested
   *
   * @return array - an array of a parsed XML Object
   *
   */
  public function getAlbums($pAlbumType) {
    $curl = $this -> get( "albums/$pAlbumType" );
    return $this -> parse_xml_into_array($curl['xml']);
  }

  /**
   * A funtion that gets the albumid of the album that was chosen as the default
   *  album for this user.  It will only return the albumid.
   *
   * @return integer - the identifier of the default album chosen
   *
   */
  public function getDefault() {
    $default  = $this -> config -> item('imageserver_field_album_id');
    $curl = $this -> get( 'apt' );
    return $this -> decode($curl['xml']) -> {$default};
  }

  /**
   * A function that grabs the details of an image given its imageid.  The image
   *  will be returned as an object pointing to each xml item.
   *
   * @param integer - the identifier of the image wanted
   *
   * @return stdObject - the stdObject converted from the XML given by the ImageServer
   */
  public function getImage( $pImageId ) {
    $curl = $this -> get( "images/$pImageId" );
    return $this -> decode($curl['xml']);
  }

  /**
   * A function requesting the ImageServer to create a new album with the given
   *  title and description.
   *
   * @param string - the title of the album to be
   * @param string - the description of the album to be
   * @param string - the type of the album to be
   * @param string - the id of the type of the album to be
   *
   */
  public function newAlbum( $pTitle, $pDescription, $pAlbumType, $pAlbumTypeId = 0, $pAlbumMediaBox ) {
    $titleas        = $this -> config -> item('imageserver_data_title');
    $descriptionas  = $this -> config -> item('imageserver_data_description');
    $albumtypeas    = $this -> config -> item('imageserver_data_albumtype');
    $albumtypeidas  = $this -> config -> item('imageserver_data_albumtypeid');
    $albummediaboxas     = $this -> config -> item('imageserver_data_albummediabox');

    $curl = $this -> post(
        'albums',
        array(
            $titleas        => $pTitle,
            $descriptionas  => $pDescription,
            $albumtypeas    => $pAlbumType,
            $albumtypeidas  => $pAlbumTypeId,
            $albummediaboxas => $pAlbumMediaBox
        )
    );

    $album  = $this -> config -> item('imageserver_field_album_id');
    return $this -> decode($curl['xml']) -> {$album};
  }

  /**
   * A function requesting the ImageServer to create a new image with the given
   *  title and description associated with the given albumid.
   *
   * @param integer - the identifier of the album to associate with
   * @param string - the title of the image to be
   * @param string - the description of the image to be
   * @param string - the hyperlink of the image to be
   * @param string - the duration of the image to be
   */
  public function newImage( $pAlbumId, $pTitle, $pDescription, $pMediaUrl, $pUrl, $pDuration ) {
    $albumas        = $this -> config -> item('imageserver_data_albums');
    $titleas        = $this -> config -> item('imageserver_data_title');
    $descriptionas  = $this -> config -> item('imageserver_data_description');
    $mediaurlas     = $this -> config -> item('imageserver_data_mediaurl');
    $urlas          = $this -> config -> item('imageserver_data_url');
    $durationas     = $this -> config -> item('imageserver_data_duration');

    // get the video id from the youtube video link
    parse_str( parse_url( $pMediaUrl, PHP_URL_QUERY ), $videoId );

    $curl = $this -> post(
        'images',
        array(
            $albumas        => $pAlbumId,
            $titleas        => $pTitle,
            $descriptionas  => $pDescription,
            $mediaurlas     => $videoId,
            $urlas          => $pUrl,
            $durationas     => $pDuration
        )
    );

    $image  = $this -> config -> item('imageserver_field_image_id');

    return $this -> decode($curl['xml']) -> {$image};
  }

  /**
   * A function requesting the ImageServer to change the default album for this
   *  user.
   *
   * @param integer - the identifier of the album to set as default
   *
   */
  public function setDefault( $pAlbumId ) {
    $curl = $this -> post( "apt/$pAlbumId" );
  }

  /**
   * A function to request the ImageServer to toggle the image view status
   *
   * @param integer - the identifier of the image
   *
   */
  public function setImageActiveStatus( $pImageId ) {
    $curl = $this -> post( "api/npm/active/$pImageId",array(),1 );
    return $this -> decode($curl['xml']);
  }

  /**
   * A function requesting an update of an album.  The function will update on
   *  title, description for album with albumid.
   *
   * @param integer - the identifier of the album to be updated
   * @param string - the title of the album to be updated
   * @param string - the description of the album to be updated
   * @param string - the type of the album to be updated
   * @param string - the id of the type of the album to be updated
   */
  public function updateAlbum( $pAlbumId, $pTitle, $pDescription) {
    //$albumas        = $this -> config -> item('imageserver_data_albums');
    $titleas        = $this -> config -> item('imageserver_data_title');
    $descriptionas  = $this -> config -> item('imageserver_data_description');

    $curl = $this -> put(
        "albums/$pAlbumId",
        array(
            $titleas        => $pTitle,
            $descriptionas  => $pDescription
        )
    );

    //print_r($curl); die();
  }

  /**
   * A function requesting an update of an album.  The function will update on
   *  title, description for album with albumid.
   *
   * @param integer = the identifier of the image to be updated
   * @param integer - the identifier of the album to be updated on indeirectly
   * @param string - the title of the album to be updated
   * @param string - the description of the album to be updated
   * @param string - the hyperlink of the album to be updated
   * @param string - the duration of the album to be updated
   */
  public function updateImage( $pImageId, $pAlbumId, $pTitle, $pDescription, $pMediaUrl, $pUrl, $pDuration ) {
    //$imageas        = $this -> config -> item('imageserver_data_images');
    $albumas        = $this -> config -> item('imageserver_data_albums');
    $titleas        = $this -> config -> item('imageserver_data_title');
    $descriptionas  = $this -> config -> item('imageserver_data_description');
    $mediaurlas     = $this -> config -> item('imageserver_data_mediaurl');
    $urlas          = $this -> config -> item('imageserver_data_url');
    $durationas     = $this -> config -> item('imageserver_data_duration');

    // get the video id from the youtube video link
    parse_str( parse_url( $pMediaUrl, PHP_URL_QUERY ), $videoId );

    $curl = $this -> put(
        "images/$pImageId",
        array(
            $albumas        => $pAlbumId,
            $titleas        => $pTitle,
            $descriptionas  => $pDescription,
            $mediaurlas     => $videoId,
            $urlas          => $pUrl,
            $durationas     => $pDuration
        )
    );
  }

  /**
   * A function to request the ImageServer to update media duration
   *
   * @param array integer - the duration of media
   *
   */
  public function updateMediaDuration( $pMediaId, $pDuration ) {

    $mediaas    = $this -> config -> item('imageserver_data_images');
    $durationas = $this -> config -> item('imageserver_data_duration');

    $curl = $this -> put(
      "api/npm/duration",
      array(
        $mediaas    => $pMediaId,
        $durationas => $pDuration
      ),
      1
    );

    return $curl;
  }

  /**
   * A function to request the ImageServer to update media priorities
   *
   * @param array integer - the priorites of media
   *
   */
  public function updatemediapriorities( $pMediaPriorities ) {

    $mediaprioritiesas = $this -> config -> item('imageserver_data_mediapriorities');

    $curl = $this -> post(
      "api/npm/priority",
      array(
        $mediaprioritiesas => $pMediaPriorities
      ),
      1
    );
  }


  /**
   * A function to upload an image's contents and place the new image onto the
   *  ImageServer with the given image id.  This function will upload the images
   *  contents to the file designated as temp from the root of the manager where
   *  the image will be uploaded then deleted after pulled to the ImageServer.
   *  This is to save space since having the image on this file system would be
   *  redundant and useless.
   *
   * @param integer - the identifier of the image to upload an image for
   *
   * @return boolean - true on success; false on failure
   */
  public function upload( $pImageId, $pUrl=Null ) {
    if ( !$pUrl ) {
      // We set a flag!
      $flag = true;
      // Build a configuration and load the upload library
      $tmp = $this -> config -> item('tmp_dir');

      //Safety check
      if ( !file_exists( "./$tmp/" ) ) {
        @mkdir( "./$tmp/", $this -> config -> item('tmp_permissions') );
      }

      $config['upload_path']    = "./$tmp/";
      $config['allowed_types']  = $this -> config -> item('imageserver_acceptedtypes');
      $config['max_size']       = $this -> config -> item('imageserver_maxsize');
      $config['encrypt_name']   = true;
      $this -> load -> library( 'upload', $config );


      // Do the upload
      $upload = $this->upload->do_upload($this -> config -> item('data_userfile'));

      if ( !$upload ) {
        log_message( 'error', 'There was a problem doing the upload!' );
        return false;
      }

      // Use the uploaded file as part of payload
      $data = $this -> upload -> data();

      $pUrl = base_url() . $tmp . '/' . $data['file_name'];

		$filepath = './' . $tmp . '/' . $data['file_name'];
    }
    $filename = uniqid() . '.' . pathinfo( $pUrl )['extension'];

    // Post this data to the server...
    $curl = $this -> put(
        "uploads/$pImageId",
        array(
            _IS_DATA_FILENAME_  => $filename,
            _IS_DATA_URL_       => $pUrl
        )
    );

    if ( isset( $flag) ) {
      // Delete the previously uploaded file
      if ( file_exists( $filepath ) ) {
        unlink( $filepath );
      }
    }

    return true;
  }

}

?>
