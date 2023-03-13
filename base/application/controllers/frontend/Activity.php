<?php

/**
 * File: ~/application/controller/frontend/Activity.php
 */

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * Manage ads and link redirections and interactions on frontend
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */

class Activity extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('frontend/ads_model', 'Ads');
    $this->load->model('frontend/activity_model', 'Activity');
  }

  /**
   * Redirect to ad's link reference (sponsored link)
   *
   * @param int $ad_id  Ad ID
   * @return void
   */
  public function ad_redirect($ad_id)
  {
    $this->Activity->update_ad_activity($ad_id, $column = 'clicks');

    $link_reference = $this->Activity->get_ad_link_reference($ad_id)->url;

    redirect($link_reference);
  }

  /**
   * Redirect to link url reference
   *
   * @param int $ad_id  Link ID
   * @return void
   */
  public function link_redirect($link_id)
  {
    $this->Activity->update_link_activity($link_id, $column = 'clicks');

    $link_reference = $this->Activity->get_link_url_reference($link_id)->www;

    redirect($link_reference);
  }

  /**
   * Update ad impression
   *
   * @param int $ad_id Ad ID
   * @return void
   */
  public function update_ad_impression($ad_id)
  {
    $this->Activity->update_ad_activity($ad_id, $column = 'impressions');
  }
}
