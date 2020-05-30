<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Common_Controller
{

  function __construct()
  {
    parent::__construct();

    // If they are not logged in, direct them to the index page of the welcome class
    if (!$this->ion_auth->logged_in()) {
      redirect($this->welcome);
    }
  }

  /**
   *  A simple redirect function that will place the user at the home page since
   *    a login was required to reach this state.  See @home
   *
   * @goto ../main/home
   *
   */
  public function index()
  {
    $this->home();
  }

  /**
   * A simple redirect function that will be used as the home page for the Manager.
   *  The main page will contain crucial information and links that allows a user to
   *  not only build a new album, but also delete, edit, and add to.  See @diagram
   *  for more information.
   *
   * @goto ../view/home
   *
   */
  public function home()
  {
    redirect($this->view . '/home');
  }

  /**
   * A simple redirect function that will prompt the user for entry on new album
   *  information.  When the user submits the information, the createalbum function
   *  will be called.  See @createalbum for more information.
   *
   * @goto ../view/addalbum
   *
   */
  public function addalbum()
  {
    redirect($this->view . "/createalbum");
  }

  /**
   * A simple redirect function that will prompt the user for entry on new image
   *  information.  When the user submits the information, the createimage function
   *  will be called.  See @createimage for more information.
   *
   * @goto ../view/addimage
   *
   */
  public function addimage($pAlbumType, $pAlbumTypeId, $pKeyword, $pAlbumId)
  {

    redirect($this->view . "/createimage/$pAlbumType/$pAlbumTypeId/$pKeyword/$pAlbumId");
  }

  /**
   * A simple redirect function that will prompt the user for entry on new image
   *  information.  When the user submits the information, the createimage function
   *  will be called.  See @createimageglobal for more information.
   *
   * @goto ../view/addimageglobal/
   *
   */
  public function addimageglobal($pAlbumId)
  {
    redirect($this->view . "/createimageglobal/$pAlbumId");
  }

  /**
   * A function to archive an image from the ImageServer.  This function will archive
   *  the image from the database and the file system.
   *
   * @goto ../view/addimage/{albumid}
   *
   */
  public function archiveimage($pAlbumType, $pAlbumTypeId, $pImageId)
  {
    $albumid = $this->curler->archiveImage($pImageId);
    //$x = $this -> curler -> toggleimagestatus( $pImageId );



    $this->viewalbum($pAlbumType, $pAlbumTypeId);
  }

  /**
   * A function to archive an image from the ImageServer.  This function will archive
   *  the image from the database and the file system.
   *
   * @goto ../view/addimage/{albumtype}{keyword}{albumid}
   *
   */
  public function archiveimageglobal($pImageId)
  {
    //$x = $this -> curler -> toggleimagestatus( $pImageId );
    $albumid = $this->curler->archiveImage($pImageId);

    //print_r($x); die();

    $this->viewalbumglobal($albumid);
  }

  /**
   * A POST collection function allowing the model to create a new album on the
   *  imageserver.  This function will require title and description for the album.
   *
   * @data POST 'title' - the title of the album to be
   * @data POST 'description' - the description of the album to be
   *
   * @goto ../view/home
   *
   */
  public function createalbum()
  {
    // Grab the POST data
    $title        = $this->input->post($this->config('data_title'), true);
    $description  = $this->input->post($this->config('data_description'), true);
    $albumtype    = $this->input->post($this->config('data_albumtype'), true);

    $albumid = $this->curler->newAlbum($title, $description, $albumtype);

    $this->home();
  }

  /**
   * A POST collection function allowing the model to create a new image on the
   *  imageserver.  This function will require albumid, title, and description
   *  for the image.
   *
   * @data POST 'albumid' - the id of the album to add this image to
   * @data POST 'title' - the title of the image to be
   * @data POST 'description' - the description of the image to be
   *
   * @goto ../view/home
   *
   */
  public function createimage($pAlbumId, $pAlbumType, $pAlbumTypeId)
  {
    // Grab the POST data
    $albumid = $pAlbumId;
    $albumtype    = $this->input->post($this->config('data_albumtype'), true);
    $albumtypeid  = $this->input->post($this->config('data_albumtypeid'), true);

    $brandid      = $this->input->post($this->config('data_brandid'), true);
    $title        = $this->input->post($this->config('data_title'), true);
    $description  = $this->input->post($this->config('data_description'), true);
    $mediaurl     = $this->input->post($this->config('data_mediaurl'), true);
    $url          = $this->input->post($this->config('data_url'), true);
    $duration     = $this->input->post($this->config('data_duration'), true);

    // cURL it
    $imageid = $this->curler->newImage($albumid, $brandid, $title, $description, $mediaurl, $url, $duration);

    // upload media
    $this->curler->upload($imageid);

    $this->viewalbum($albumtype, $albumtypeid);
  }

  /**
   * A POST collection function allowing the model to create a new image on the
   *  imageserver.  This function will require albumid, title, and description
   *  for the image.
   *
   * @data POST 'albumid' - the id of the album to add this image to
   * @data POST 'title' - the title of the image to be
   * @data POST 'description' - the description of the image to be
   *
   * @goto ../view/home
   *
   */
  public function createimageglobal($pAlbumId)
  {
    // Grab the POST data
    $albumid = $pAlbumId;

    $brandid      = $this->input->post($this->config('data_brandid'), true);
    $title        = $this->input->post($this->config('data_title'), true);
    $description  = $this->input->post($this->config('data_description'), true);
    $mediaurl     = $this->input->post($this->config('data_mediaurl'), true);
    $url          = $this->input->post($this->config('data_url'), true);
    $duration     = $this->input->post($this->config('data_duration'), true);

    // cURL it
    $imageid = $this->curler->newImage($albumid, $brandid, $title, $description, $mediaurl, $url, $duration);

    // upload media
    $this->curler->upload($imageid);

    $this->viewalbumglobal($pAlbumId);
  }

  /**
   * A function to delete an album and all its contents.  This function will not
   *  only delete the album but also the images that are associated with this album.
   *
   * @goto ../view/home
   */
  public function deletealbum($pAlbumId)
  {
    if ($pAlbumId != 1) {
      $this->curler->deleteAlbum($pAlbumId);
    }
    $this->home();
  }

  /**
   * A function to delete an image from the ImageServer.  This function will delete
   *  the image from the database and the file system.
   *
   * @goto ../view/addimage/{albumid}
   *
   */
  public function deleteimage($pAlbumType, $pAlbumTypeId, $pImageId)
  {
    $albumid = $this->curler->deleteImage($pImageId);

    $this->viewalbum($pAlbumType, $pAlbumTypeId);
  }

  /**
   * A function to delete an image from the ImageServer.  This function will delete
   *  the image from the database and the file system.
   *
   * @goto ../view/addimage/{albumtype}{keyword}{albumid}
   *
   */
  public function deleteimageglobal($pImageId)
  {
    $albumid = $this->curler->deleteImage($pImageId);

    $this->viewalbumglobal($albumid);
  }

  /**
   * A simple redirect function that will prompt the user for information similar
   *  to the addalbum function.  This function will move the user to the proper form
   *  allowing for data which will be sent to the updatealbum function.  See
   *  @updatealbum for more information.
   *
   * @param integer - the identifier of the album to modify
   *
   * @goto ../view/editalbum/{albumid}
   *
   */
  public function editalbum($pAlbumId)
  {
    redirect($this->view . "/editalbum/$pAlbumId");
  }

  /**
   * A simple redirect function that will prompt the user for information similar
   *  to the addimage method.  This function will move the user to the proper form
   *  allowing for data which will be sent to the updateimage function.  See
   *  @updateimage for more information.
   *
   * @param integer - the identifier of the image to modify
   *
   * @goto ../view/editimage/{albumtype}{keyword}{imageid}
   *
   */
  public function editimage($pAlbumType, $pAlbumTypeId, $pKeyword, $pImageId)
  {
    redirect($this->view . "/editimage/$pAlbumType/$pAlbumTypeId/$pKeyword/$pImageId");
  }

  /**
   * A simple redirect function that will prompt the user for information similar
   *  to the addimage method.  This function will move the user to the proper form
   *  allowing for data which will be sent to the updateimage function.  See
   *  @updateimage for more information.
   *
   * @param integer - the identifier of the image to modify
   *
   * @goto ../view/editimage/global{imageid}
   *
   */
  public function editimageglobal($pImageId)
  {
    redirect($this->view . "/editimageglobal/$pImageId");
  }

  /**
   * A function to request the ImageServer to change the default album associated
   *  with this user.
   *
   */
  public function setdefault($pAlbumId)
  {
    $this->curler->setDefault($pAlbumId);
    $this->home();
  }

  /**
   * A function to request the ImageServer to toggle the image view status
   *
   */
  public function setimageactivestatus($pImageId)
  {
    $result = $this->curler->setImageActiveStatus($pImageId);
    echo $result->item->status;
  }

  /**
   * A POST collection allowing the model to update the current information of an
   *  album.  This function will require albumid, title, and description for the
   *  album.
   *
   * @data POST integer 'albumid' - the identifier of the album to be modified
   * @data POST integer 'title' - the title of the album to be modified
   * @data POST integer 'description' - the description of the album to be modified
   *
   * @goto ../view/home
   *
   */
  public function updatealbum($pAlbumId)
  {
    // Grab the POST data
    $albumid      = $pAlbumId;
    $title        = $this->input->post($this->config('data_title'), true);
    $description  = $this->input->post($this->config('data_description'), true);
    $albumtype    = $this->input->post($this->config('data_albumtype'), true);
    $albumtypeid  = $this->input->post($this->config('data_albumtypeid'), true);

    // cURL it
    $this->curler->updateAlbum($albumid, $title, $description, $albumtype, $albumtypeid);

    redirect($this->view . "/viewalbumglobal/$pAlbumId");
  }

  /**
   * A POST collection allowing the model to update the current information of an
   *  image.  This function will require imageid, albumid, title, and description
   *  for the image.
   *
   * @data POST integer 'imageid' - the identifier of the image to be modified
   * @data POST integer 'albumid' - the identifier of the album that this image
   *    belongs to (sent for easy redirection)
   * @data POST integer 'title' - the title of the album to be modified
   * @data POST integer 'description' - the description of the album to be modified
   *
   * @goto ../view/createimage/{albumid}
   *
   */
  public function updateimage($pAlbumId, $pImageId)
  {
    // Grab the POST data
    $imageid      = $pImageId;
    $albumid      = $pAlbumId;
    $albumtype    = $this->input->post($this->config('data_albumtype'), true);
    $albumtypeid  = $this->input->post($this->config('data_albumtypeid'), true);

    $brandid      = $this->input->post($this->config('data_brandid'), true);
    $title        = $this->input->post($this->config('data_title'), true);
    $description  = $this->input->post($this->config('data_description'), true);
    $url          = $this->input->post($this->config('data_url'), true);
    $mediaurl     = $this->input->post($this->config('data_mediaurl'), true);
    $duration     = $this->input->post($this->config('data_duration'), true);

    // cURL it
    $this->curler->updateImage($imageid, $albumid, $brandid, $title, $description, $mediaurl, $url, $duration);

    // upload media
    $this->curler->upload($imageid);

    if (isset($albumtype) && isset($albumtypeid)) {
      $this->viewalbum($albumtype, $albumtypeid);
    } else {
      $this->viewalbumglobal($albumid);
    }
  }

  // /**
  //  * A POST collection allowing the model to update the current information of an
  //  *  image.  This function will require imageid, albumid and can take either, a
  //  *  URL or an image to upload.
  //  *
  //  * @data POST integer 'imageid' - the identifier of the image to be modified
  //  * @data POST integer 'albumid' - the identifier of the album that this image
  //  *    belongs to (sent for easy redirection)
  //  * @data POST integer 'url' (optional) - the url of a remote image to upload
  //  *
  //  * @goto ../view/addimage/{albumid}
  //  *
  //  */
  // public function upload( $pAlbumId, $pImageId = 0 ) {
  //
  //   // Grab the POST data
  //   $imageid      = $pImageId;
  //   $albumid      = $pAlbumId;
  //   $url          = $this -> input -> post( $this -> config( 'data_url' ), true );
  //
  //   $this -> curler -> upload( $imageid, ( !$url ? '' : $url ) );
  //
  //   // ???
  //   $this -> addimage( $albumid );
  //}

  /**
   * A simple redirect function that will prompt the user for an image file - local
   *  or remote.  When the user submits the information, the upload function
   *  will be called.  See @upload for more information.
   *
   * @goto ../view/uploadimage/{imageid}
   *
   */
  public function uploadimage($pImageId)
  {
    redirect($this->view . "/uploadimage/$pImageId");
  }

  /**
   * A function to request the ImageServer to update media duration
   *
   */
  public function updatemediaduration($pMediaId, $pDuration)
  {
    // cURL it
    $curl = $this->curler->updateMediaDuration($pMediaId, $pDuration);

    print_r($curl);
  }

  /**
   * A function to request the ImageServer to update media priorites
   *
   */
  public function updatemediapriorities()
  {
    // Grab the POST data
    $mediapriorities = $this->input->post($this->config('data_mediapriorities'), true);

    // cURL it
    $this->curler->updatemediapriorities($mediapriorities);
  }

  /**
   * A simple redirect function that will show list of albums for the specific
   *  album type, the viewalbum function will be called.
   *  See @viewalbum for more information.
   *
   * @goto ../view/viewalbum/{albumtype}/{albumtypeid}
   *
   */
  public function viewalbum($pAlbumType, $pAlbumTypeId)
  {
    redirect($this->view . "/viewalbum/$pAlbumType/$pAlbumTypeId");
  }

  /**
   * A simple redirect function that will show list of albums,
   * the viewalbumglobal function will be called.
   *  See @viewalbum for more information.
   *
   * @goto ../view/viewalbum/{albumid}
   *
   */
  public function viewalbumglobal($pAlbumId, $pArchived = 0)
  {
    redirect($this->view . "/viewalbumglobal/$pAlbumId/$pArchived");
  }
}
