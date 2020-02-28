<?php
/**
 * File: ~/application/controller/Pages.php
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Control default pages for My Skearch
 *
 * Shows default fields on the homepage
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2018 Skearch LLC
 */

class Media extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


  public function media_redirect($image_id) {

    // curl request for media box
    $this -> curl -> create("https://media.skearch.com/api/npm/url/$image_id");
    $this -> curl -> {'get'}();
    $this -> curl -> http_header( 'X-API-KEY', '374986acc824c8621fa528d04740f308' );
    $this -> curl -> http_header( 'X-I-USER', 1 );

    // xml data for media box
    $xml = $this -> curl -> execute();

    // parse xml to array for media box
    $objxml = new SimpleXMLElement($xml);

    $url = $objxml->item->url;

    redirect($url);

  }

  public function update_image_impression($image_id) {

    // curl request for media box
    $this -> curl -> create("https://media.skearch.com/api/npm/impression/$image_id");
    $this -> curl -> {'post'}();
    $this -> curl -> http_header( 'X-API-KEY', '374986acc824c8621fa528d04740f308' );
    $this -> curl -> http_header( 'X-I-USER', 1 );

    $this -> curl -> execute();

  }


}
