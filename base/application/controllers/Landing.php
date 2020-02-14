<?php

/**
 * File: ~/application/controller/landing.php
 */

if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

/**
 * Default landing for the application
 *
 * Redirects to Pages controller
 *
 * @version      2.0
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020 Skearch LLC
 */

class Landing extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    redirect('home', 'location', 302);
  }
}
