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

    $this->load->model('Category_model', 'Category_model');
    $this->load->model('Fields_History_model', 'Fields_History');
    $this->load->model('admin_panel/Option_model_admin', 'Option_model');
    $this->load->model('my_skearch/User_model', 'User');

    $this->user_id = $this->session->userdata('user_id');

    // set default skearch theme
    if (empty($this->session->userdata('settings'))) {
      $settings = (object) array('theme' => 'light');
      $this->session->set_userdata('settings', $settings);
    }
  }

  /**
   * View page for Skearch Home
   *
   * @return void
   */
  public function index()
  {

    $data['results'] = $this->Category_model->get_homepage_results();

    $data['user'] = $this->ion_auth->user()->row();
    $data['admin'] = $this->ion_auth->is_admin();
    $data['version'] = $this->Option_model->get_skearch_ver();

    // set page title
    $data['title'] = ucwords('Skearch Home');
    $this->load->view('frontend/home', $data);
  }

  /**
   * View page for all umbrellas and fields
   *
   * @param string $order
   * @return void
   */
  public function browse_all($order = 'asc')
  {

    // get all umbrellas
    $umbrellas = $this->Category_model->get_categories(NULL, $order);

    // get fields for each umbrellas
    foreach ($umbrellas as $umbrella) {
      $data['umbrellas'][$umbrella->title] = $this->Category_model->get_subcategories($umbrella->id);
    }

    // get media for media box va
    $album_id = $this->get_album("global", 0, "VA");
    if ($album_id != NULL) {
      $data['media_box_va'] = $this->get_media_contents($album_id);
      if ($data['media_box_va'] == NULL) {
        // get the default media
        $album_id = $this->get_album("default", 0, "VA");
        $data['media_box_va'] = $this->get_media_contents($album_id);
      }
    } else {
      $album_id = $this->get_album("default", 0, "VA");
      $data['media_box_va'] = $this->get_media_contents($album_id);
    }

    // page title
    $data['title'] = ucfirst('browse all fields');

    $this->load->view('frontend/browse', $data);
  }


  /**
   * View page for an umbrella
   *
   * @param string $umbrella_name
   * @return void
   */
  public function browse_umbrella($umbrella_name)
  {

    // redirect if umbrella is not found
    if (!$this->Category_model->get_category_id($umbrella_name)) {
      redirect(site_url() . '/browse', 'refresh');
    } else {

      $umbrella_id = $this->Category_model->get_category_id($umbrella_name)->id;

      // get media for media box a
      $album_id = $this->get_album("umbrella", $umbrella_id, "A");
      if ($album_id != NULL) {
        // get the appropriate media for umbrella
        $data['media_box_a'] = $this->get_media_contents($album_id);
        if ($data['media_box_a'] == NULL) {
          $album_id = $this->get_album("global", 0, "A");
          if ($album_id != NULL) {
            // get the global media for umbrella
            $data['media_box_a'] = $this->get_media_contents($album_id);
            if ($data['media_box_a'] == NULL) {
              $album_id = $this->get_album("default", 0, "A");
              // get the default media for umbrella
              $data['media_box_a'] = $this->get_media_contents($album_id);
            }
          } else {
            $album_id = $this->get_album("default", 0, "A");
            // get the default media for umbrella
            $data['media_box_a'] = $this->get_media_contents($album_id);
          }
        }
      } else {
        $album_id = $this->get_album("global", 0, "A");
        if ($album_id != NULL) {
          // get the global media for umbrella
          $data['media_box_a'] = $this->get_media_contents($album_id);
          if ($data['media_box_a'] == NULL) {
            $album_id = $this->get_album("default", 0, "A");
            // get the default media for umbrella
            $data['media_box_a'] = $this->get_media_contents($album_id);
          }
        } else {
          $album_id = $this->get_album("default", 0, "A");
          // get the default media for umbrella
          $data['media_box_a'] = $this->get_media_contents($album_id);
        }
      }

      // get media for media box u
      $album_id = $this->get_album("umbrella", $umbrella_id, "U");
      if ($album_id != NULL) {
        // get the appropriate media for umbrella
        $data['media_box_u'] = $this->get_media_contents($album_id);
        if ($data['media_box_u'] == NULL) {
          $album_id = $this->get_album("global", 0, "U");
          if ($album_id != NULL) {
            // get the global media for umbrella
            $data['media_box_u'] = $this->get_media_contents($album_id);
            if ($data['media_box_u'] == NULL) {
              $album_id = $this->get_album("default", 0, "U");
              // get the default media for umbrella
              $data['media_box_u'] = $this->get_media_contents($album_id);
            }
          } else {
            $album_id = $this->get_album("default", 0, "U");
            // get the default media for umbrella
            $data['media_box_u'] = $this->get_media_contents($album_id);
          }
        }
      } else {
        $album_id = $this->get_album("global", 0, "U");
        if ($album_id != NULL) {
          // get the global media for umbrella
          $data['media_box_u'] = $this->get_media_contents($album_id);
          if ($data['media_box_u'] == NULL) {
            $album_id = $this->get_album("default", 0, "U");
            // get the default media for umbrella
            $data['media_box_u'] = $this->get_media_contents($album_id);
          }
        } else {
          $album_id = $this->get_album("default", 0, "U");
          // get the default media for umbrella
          $data['media_box_u'] = $this->get_media_contents($album_id);
        }
      }

      $data['results'] = $this->Category_model->get_umbrella_suggestions($umbrella_id);
      $data['fields'] = $this->Category_model->get_subcategories($umbrella_id);
      $data['umbrella_name'] = urldecode($umbrella_name);

      // set page title
      $data['title'] = ucfirst(urldecode($umbrella_name));
      $this->load->view('frontend/umbrella', $data);
    }
  }

  /**
   * View page for a field
   *
   * @param string $umbrella_name
   * @param string $field_name
   * @return void
   */
  public function browse_field($umbrella_name, $field_name)
  {
    // redirect if umbrella is not found
    if (!$this->Category_model->get_category_id($umbrella_name)) {
      redirect(site_url() . '/browse', 'refresh');
    } else {
      $umbrella_id = $this->Category_model->get_category_id($umbrella_name)->id;

      if (!$this->Category_model->get_subcategory_id($field_name)) {
        redirect(site_url() . '/browse/' . $umbrella_name, 'refresh');
      } else {
        $field_id = $this->Category_model->get_subcategory_id($field_name)->id;
        $data['field_id'] = $field_id;
        $data['suggest_fields'] = $this->Category_model->get_field_suggestions($data['field_id']);

        // get media for media box a
        $album_id = $this->get_album("field", $umbrella_id, "A");
        if ($album_id != NULL) {
          // get the appropriate media for field
          $data['media_box_a'] = $this->get_media_contents($album_id);
          if ($data['media_box_a'] == NULL) {
            $album_id = $this->get_album("global", 0, "A");
            if ($album_id != NULL) {
              // get the global media for field
              $data['media_box_a'] = $this->get_media_contents($album_id);
              if ($data['media_box_a'] == NULL) {
                $album_id = $this->get_album("default", 0, "A");
                // get the default media for field
                $data['media_box_a'] = $this->get_media_contents($album_id);
              }
            } else {
              $album_id = $this->get_album("default", 0, "A");
              // get the default media for field
              $data['media_box_a'] = $this->get_media_contents($album_id);
            }
          }
        } else {
          $album_id = $this->get_album("global", 0, "A");
          if ($album_id != NULL) {
            // get the global media for field
            $data['media_box_a'] = $this->get_media_contents($album_id);

            if ($data['media_box_a'] == NULL) {
              // var_dump($data['media_box_a']);
              // //var_dump($album_id);
              // die();
              $album_id = $this->get_album("default", 0, "A");
              // get the default media for field
              $data['media_box_a'] = $this->get_media_contents($album_id);
            }
          } else {
            $album_id = $this->get_album("default", 0, "A");
            // get the default media for field
            $data['media_box_a'] = $this->get_media_contents($album_id);
          }
        }

        // get media for media box b
        $album_id = $this->get_album("field", $umbrella_id, "B");
        if ($album_id != NULL) {
          // get the appropriate media for field
          $data['media_box_b'] = $this->get_media_contents($album_id);
          if ($data['media_box_b'] == NULL) {
            $album_id = $this->get_album("global", 0, "B");
            if ($album_id != NULL) {
              // get the global media for field
              $data['media_box_b'] = $this->get_media_contents($album_id);
              if ($data['media_box_b'] == NULL) {
                $album_id = $this->get_album("default", 0, "B");
                // get the default media for field
                $data['media_box_b'] = $this->get_media_contents($album_id);
              }
            } else {
              $album_id = $this->get_album("default", 0, "B");
              // get the default media for field
              $data['media_box_b'] = $this->get_media_contents($album_id);
            }
          }
        } else {
          $album_id = $this->get_album("global", 0, "B");
          if ($album_id != NULL) {
            // get the global media for field
            $data['media_box_b'] = $this->get_media_contents($album_id);
            if ($data['media_box_b'] == NULL) {
              $album_id = $this->get_album("default", 0, "B");
              // get the default media for field
              $data['media_box_b'] = $this->get_media_contents($album_id);
            }
          } else {
            $album_id = $this->get_album("default", 0, "B");
            // get the default media for field
            $data['media_box_b'] = $this->get_media_contents($album_id);
          }
        }

        $data['results'] = $this->Category_model->get_field_suggestions($field_id);
        $data['umbrella_name'] = ucwords(urldecode($umbrella_name));
        $data['field_name'] = urldecode($field_name);

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
  }

  /**
   * Change theme
   *
   * @return void
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
  public function get_field_results($field_id, $order)
  {

    $query_result = $this->Category_model->get_adlinks($field_id, $order);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($query_result));
  }

  /**
   * Returns album id
   *
   * @param string $album_type
   * @param int $album_type_id
   * @param string $media_box
   * @return int
   */
  private function get_album($album_type, $album_type_id, $media_box)
  {

    // curl request for media box
    $this->curl->create("https://media.skearch.com/api/npm/album/$album_type/$album_type_id/$media_box");
    $this->curl->{'get'}();
    $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
    $this->curl->http_header('X-I-USER', 1);

    // xml data for media box
    $xml = $this->curl->execute();

    // parse xml to array
    $objxml = new SimpleXMLElement($xml);

    $albumid = $objxml->item->albumid;

    return $albumid;
  }

  /**
   * Returns all media for given album
   *
   * @param int $album_id
   * @return object
   */
  private function get_media_contents($album_id)
  {

    // curl request for media box
    $this->curl->create("https://media.skearch.com/api/manager/albums/$album_id");
    $this->curl->{'get'}();
    $this->curl->http_header('X-API-KEY', '374986acc824c8621fa528d04740f308');
    $this->curl->http_header('X-I-USER', 1);

    // xml data for media box
    $xml = $this->curl->execute();

    // parse xml to array for media box
    $objxml = new SimpleXMLElement($xml);

    if (!is_object($objxml->images) || count(get_object_vars($objxml->images)) !== 0) {

      if ($objxml->images->item->item) {

        foreach ($objxml->images->item->item as $banner) {
          $banner_id = (string) $banner->imageid;
          if ($banner->imagestatus == 1) {
            $media_contents[$banner_id] = array(
              'imageid' => (string) $banner->imageid,
              'title' => (string) $banner->imagetitle,
              'description' => (string) $banner->imagedescription,
              'mediaurl' => (string) $banner->mediaurl,
              'image' => (string) $banner->imagefilename,
              'duration' => (string) ($banner->imageduration * 1000),
              'adsign' => (string) $banner->adsign
            );
          }
        }
      } else {

        foreach ($objxml->images->item as $banner) {
          $banner_id = (string) $banner->imageid;
          if ($banner->imagestatus == 1) {
            $media_contents[$banner_id] = array(
              'imageid' => (string) $banner->imageid,
              'title' => (string) $banner->imagetitle,
              'description' => (string) $banner->imagedescription,
              'mediaurl' => (string) $banner->mediaurl,
              'image' => (string) $banner->imagefilename,
              'duration' => (string) ($banner->imageduration * 1000),
              'adsign' => (string) $banner->adsign
            );
          }
        }
      }
    } else {
      $media_contents = NULL;
      // $banner_id = NULL;
      // $media_contents[$banner_id] = array(
      //   'imageid' => '#',
      //   'title' => NULL,
      //   'description' => NULL,
      //   'image' => NULL,
      //   'duration' => NULL
      // );
    }

    return $media_contents;
  }
}
