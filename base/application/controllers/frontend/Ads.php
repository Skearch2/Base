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

class Ads extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('frontend/ads_model', 'Ads');
  }

  /**
   * Redirect to ad's link reference (sponsored link)
   *
   * @param int $ad_id  Ad ID
   * @return void
   */
  public function redirect($ad_id)
  {
    if (!$this->Ads->update_ad_activity($ad_id, $column = 'clicks')) {
      log_message('error', "Unable to update ad's impression.");
    }

    $link_reference = $this->Ads->get_link_reference($ad_id)->url;

    redirect($link_reference);
  }

  /**
   * Update ad impression
   *
   * @param int $ad_id Ad ID
   * @return void
   */
  public function update_impression($ad_id)
  {
    if (!$this->Ads->update_ad_activity($ad_id, $column = 'impressions')) {
      log_message('error', "Unable to update ad's impression.");
    }
  }
}
