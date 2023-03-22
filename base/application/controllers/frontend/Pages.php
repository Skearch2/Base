<?php

/**
 * File: ~/application/controller/frontend.php
 */

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * Control default pages for Skearch frontend
 *
 * Shows default fields on the homepage
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */

class Pages extends MY_Controller
{

  /**
   * Constructor
   */
  public function __construct()
  {
    parent::__construct();

    $this->load->model('my_skearch/User_model', 'User');

    $this->user_id = $this->session->userdata('user_id');

    if ($this->user_id && !$this->User->check_latest_tos_ack($this->user_id)) {
      if (current_url() !== site_url('tos_pp_ack'))
        redirect('tos_pp_ack');
    }

    $this->load->model('Category_model', 'Category_model');
    $this->load->model('Fields_History_model', 'Fields_History');
    $this->load->model('admin_panel/Settings_model', 'Settings');
    $this->load->model('frontend/ads_model', 'Ads');
    $this->load->model('admin_panel/Tips_crypto_model', 'Tips_crypto_wallets');
    $this->load->model('admin_panel/Tos_pp_model', 'TOS');

    // set default skearch theme
    if (empty($this->session->userdata('settings'))) {
      $settings = (object) array('theme' => 'light');
      $this->session->set_userdata('settings', $settings);
    }
  }

  /**
   * View page for Skearch Home
   */
  public function index()
  {

    $data['results'] = $this->Category_model->get_homepage_results();

    $data['user'] = $this->ion_auth->user()->row();
    $data['admin'] = $this->ion_auth->is_admin();
    $data['version'] = $this->Settings->get()->site_version;

    // set page title
    $data['title'] = ucwords('Skearch Home');
    $this->load->view('frontend/home', $data);
  }

  /**
   * Browse all page
   *
   * @param string $order
   */
  public function browse_all($order = 'asc')
  {

    // get all umbrellas
    $umbrellas = $this->Category_model->get_categories(NULL, $order);

    // get fields for each umbrellas
    foreach ($umbrellas as $umbrella) {
      $data['umbrellas'][$umbrella->title] = $this->Category_model->get_subcategories($umbrella->id);
    }

    // get global ads for banner va
    $banner_va_ads = $this->Ads->get_ads('VA', 'global', 0);

    // if no global ads found get default ads for banner va
    if (!$banner_va_ads) {
      $banner_va_ads = $this->Ads->get_ads('VA', 'default', 0);
    }

    $data['banner_va_ads'] = $banner_va_ads;

    // page title
    $data['title'] = ucfirst('browse all fields');

    $this->load->view('frontend/browse', $data);
  }


  /**
   * Umbrella page
   *
   * @param string $umbrella_name
   */
  public function browse_umbrella($umbrella_name)
  {

    // redirect if umbrella is not found
    if (!$this->Category_model->get_category_id($umbrella_name)) {
      redirect(site_url() . 'browse');
    } else {

      $umbrella_id = $this->Category_model->get_category_id($umbrella_name)->id;

      // get ads for banner a
      $banner_a_ads = $this->Ads->get_ads('A', 'umbrella', $umbrella_id);
      // get ads for banner u
      $banner_u_ads = $this->Ads->get_ads('U', 'umbrella', $umbrella_id);

      // if no ads found get global ads for banner a
      if (!$banner_a_ads) {
        $banner_a_ads = $this->Ads->get_ads('A', 'global', 0);
        if (!$banner_a_ads) {
          // if no global ads found get default ads for banner a
          $banner_a_ads = $this->Ads->get_ads('A', 'default', 0);
        }
      }

      // if no ads found get global ads for banner u
      if (!$banner_u_ads) {
        $banner_u_ads = $this->Ads->get_ads('U', 'global', 0);
        if (!$banner_u_ads) {
          // if no global ads found get default ads for banner u
          $banner_u_ads = $this->Ads->get_ads('U', 'default', 0);
        }
      }

      $data['results'] = $this->Category_model->get_umbrella_suggestions($umbrella_id);
      $data['fields'] = $this->Category_model->get_subcategories($umbrella_id);
      $data['umbrella_name'] = urldecode($umbrella_name);
      $data['banner_a_ads'] = $banner_a_ads;
      $data['banner_u_ads'] = $banner_u_ads;

      // set page title
      $data['title'] = ucfirst(urldecode($umbrella_name));
      $this->load->view('frontend/umbrella', $data);
    }
  }

  /**
   * Field page
   *
   * @param string $umbrella_name
   * @param string $field_name
   */
  public function browse_field($umbrella_name, $field_name)
  {
    // redirect if umbrella is not found
    if (!$this->Category_model->get_category_id($umbrella_name) or !$this->Category_model->get_subcategory_id($field_name)) {
      redirect(site_url() . 'browse');
    } else {

      $field_id = $this->Category_model->get_subcategory_id($field_name)->id;

      // get ads for banner a
      $banner_a_ads = $this->Ads->get_ads('A', 'field', $field_id);
      // get ads for banner b
      $banner_b_ads = $this->Ads->get_ads('B', 'field', $field_id);

      // if no ads found get global ads for banner a
      if (!$banner_a_ads) {
        $banner_a_ads = $this->Ads->get_ads('A', 'global', 0);
        if (!$banner_a_ads) {
          // if no global ads found get default ads for banner a
          $banner_a_ads = $this->Ads->get_ads('A', 'default', 0);
        }
      }

      // if no ads found get global ads for banner b
      if (!$banner_b_ads) {
        $banner_b_ads = $this->Ads->get_ads('B', 'global', 0);
        if (!$banner_b_ads) {
          // if no global ads found get default ads for banner b
          $banner_b_ads = $this->Ads->get_ads('B', 'default', 0);
        }
      }

      $data['field_id'] = $field_id;
      $data['suggest_fields'] = $this->Category_model->get_field_suggestions($data['field_id']);
      $data['results'] = $this->Category_model->get_field_suggestions($field_id);
      $data['umbrella_name'] = ucwords(urldecode($umbrella_name));
      $data['field_name'] = urldecode($field_name);
      $data['banner_a_ads'] = $banner_a_ads;
      $data['banner_b_ads'] = $banner_b_ads;

      // save the field in the field history
      if ($this->ion_auth->logged_in()) {

        $user_data = array(
          'user_id' => $this->session->userdata('user_id'),
          'field_id' => $field_id
        );

        if ($this->Fields_History->exists($user_data)) {
          $this->Fields_History->update($user_data);
        } else {
          $this->Fields_History->create($user_data);
        }
      }

      // set page title
      $data['title'] = ucwords(urldecode($umbrella_name) . " - " . urldecode($field_name));

      $this->load->view('frontend/field', $data);
    }
  }

  /**
   * Tips page
   */
  public function tips()
  {
    $data['crypto_wallets'] = $this->Tips_crypto_wallets->get();

    $data['title'] = ucwords("MySkearch | Tips");
    $this->load->view('frontend/tips', $data);
  }

  /**
   * TOS/PP page
   */
  public function tos_pp($require_ack = null)
  {
    if ($require_ack) {
      // get the lastest version of TOS/PP (date sorted desc)
      $data['content'] = $this->TOS->get()[0]->content;

      $data['title'] = ucwords("MySkearch | TOS/PP");
      $this->load->view('frontend/tos_pp_ack', $data);
    } else {
      // get the lastest version of TOS/PP (date sorted desc)
      $data['content'] = $this->TOS->get()[0]->content;

      $data['title'] = ucwords("MySkearch | TOS/PP");
      $this->load->view('frontend/tos_pp', $data);
    }
  }


  /**
   * Change theme
   */
  public function change_theme()
  {
    $settings = $this->session->userdata('settings');

    if ($settings->theme === 'light') {
      $settings->theme = 'dark';
      $this->session->set_userdata('settings', $settings);
      if ($this->ion_auth->logged_in()) {
        $this->User->update_settings($this->user_id, array('theme' => 'dark'));
      }
    } else if ($settings->theme === 'dark') {
      $settings->theme = 'light';
      $this->session->set_userdata('settings', $settings);
      if ($this->ion_auth->logged_in()) {
        $this->User->update_settings($this->user_id, array('theme' => 'light'));
      }
    }
  }

  /**
   * Output all umbrellas or fields
   *
   * @param string $keyword
   * @return void
   */
  public function get_data($keyword)
  {

    if ($keyword === "umbrella") {
      $result = $this->Category_model->get_categories(NULL, "ASC", "id, title");
    } elseif ($keyword === "field") {
      $result = $this->Category_model->get_subcategories(NULL, NULL, "ASC", "id, title");
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($result));
  }


  /**
   *  Output all results for a given field
   *
   * @param int $field_id
   * @param string $order
   * @return void
   */
  public function get_results($field_id, $order = 'auto')
  {

    $userlinks_status = $this->Settings->get()->userlinks == 1;

    if ($order == 'auto' && $userlinks_status == 1) {
      $order = 'clicks';
    } elseif ($order == 'auto' && $userlinks_status == 0) {
      $order = 'priority';
    }

    $links = $this->Category_model->get_adlinks($field_id, $order);

    // sequence priority numbers
    foreach ($links as $index => $link) {
      $link->priority = $index + 1;
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($links));
  }

  /**
   * Redirect to link url reference
   *
   * @param int $link_id  Link ID
   * @return void
   */
  public function redirect($link_id)
  {
    if (!$this->Ads->update_ad_activity($ad_id, $column = 'clicks')) {
      log_message('error', "Unable to update ad's impression.");
    }

    $link_reference = $this->Ads->get_ad_link_reference($ad_id)->url;

    redirect($link_reference);
  }
}
