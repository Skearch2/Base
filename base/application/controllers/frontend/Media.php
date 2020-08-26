<?php

/**
 * File: ~/application/controller/Media_api.php
 */

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * API calls to Media Server
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */

class Media extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Undocumented function
   *
   * @param [type] $brand_id
   * @return void
   */
  public function get_brand_ads_stats($brand_id)
  {
    // curl request for media box
    $this->curl->create("https://media.skearch.com/api/npm/activity/$brand_id");
    $this->curl->{'get'}();
    $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
    $this->curl->http_header('X-I-USER', 1);

    $xml = $this->curl->execute();

    // parse xml to array
    $objxml = new SimpleXMLElement($xml);
  }

  /**
   * Undocumented function
   *
   * @param [type] $image_id
   * @return void
   */
  public function media_redirect($image_id)
  {
    // curl request for media box
    $this->curl->create("https://media.skearch.com/api/npm/url/$image_id");
    $this->curl->{'get'}();
    $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
    $this->curl->http_header('X-I-USER', 1);

    // xml data for media box
    $xml = $this->curl->execute();

    // parse xml to array for media box
    $objxml = new SimpleXMLElement($xml);

    $url = $objxml->item->url;

    redirect($url);
  }

  /**
   * Undocumented function
   *
   * @param [type] $image_id
   * @return void
   */
  public function update_image_impression($image_id)
  {

    // curl request for media box
    $this->curl->create("https://media.skearch.com/api/npm/impression/$image_id");
    $this->curl->{'post'}();
    $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
    $this->curl->http_header('X-I-USER', 1);

    $this->curl->execute();
  }
}
