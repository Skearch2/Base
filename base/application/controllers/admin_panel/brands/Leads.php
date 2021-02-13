<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * File: ~/application/controller/admin_panel/brands/Leads.php
 *
 * A controller for brandleads
 * 
 * @package      Skearch
 * @author       Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright    Copyright (c) 2020
 * @version      2.0
 */
class Leads extends MY_Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        if (!$this->ion_auth->in_group($this->config->item('staff', 'ion_auth'))) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        $this->load->model('admin_panel/brands/Brand_model', 'Brand');
        $this->load->model('admin_panel/brands/leads_model', 'Leads');
        $this->load->model('admin_panel/users/User_model', 'User');
        $this->load->model('Util_model', 'Util_model');
    }

    /**
     * Create brand from the lead
     *  
     * @param int $id Lead id
     * @return void
     */
    public function create_brand($id)
    {

        if (!$this->ion_auth_acl->has_permission('brands_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('brand', 'Brand', 'trim|required|is_unique[skearch_brands.brand]');
            $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'trim|required');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]|required');

            if ($this->form_validation->run() == false) {
                $lead = $this->Leads->get($id);

                if (!$lead) {
                    error_404('admin');
                    return;
                }

                $data['brand'] = $lead->brandname;

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                $data['title'] = ucwords("create brand");
                $this->load->view('admin_panel/pages/brands/leads/create_brand', $data);
            } else {
                $brand_data['brand'] = $this->input->post('brand');
                $brand_data['organization'] = $this->input->post('organization');
                $brand_data['address1'] = $this->input->post('address1');
                $brand_data['address2'] = $this->input->post('address2');
                $brand_data['city'] = $this->input->post('city');
                $brand_data['state'] = $this->input->post('state');
                $brand_data['country'] = $this->input->post('country');
                $brand_data['zipcode'] = $this->input->post('zipcode');

                $create = $this->Brand->create($brand_data);

                if ($create) {
                    $this->session->set_flashdata('brand_create_success', 1);
                } else {
                    $this->session->set_flashdata('brand_create_success', 0);
                }
                redirect("admin/brands/leads");
            }
        }
    }

    /**
     * Create brand user from the lead
     *  
     * @param int $id Lead id
     * @return void
     */
    public function create_user($id)
    {
        if (!$this->ion_auth_acl->has_permission('user_create') && !$this->ion_auth->is_admin()) {
            error_403('admin');
        } else {

            $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[skearch_users.username]|alpha_numeric|min_length[' . $this->config->item('min_username_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_username_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[skearch_users.email]');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|alpha');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha');
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('age_group', 'Age group', 'required');
            $this->form_validation->set_rules('brand', 'Brand', 'required');
            $this->form_validation->set_rules('brand_id', 'Brand ID', 'numeric');
            $this->form_validation->set_rules('key_member', 'Key Member', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'numeric|exact_length[10]');
            $this->form_validation->set_rules('address1', 'Address 1', 'trim');
            $this->form_validation->set_rules('address2', 'Address 2', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
            if (strlen($this->input->post('zipcode'))) {
                $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]');
            }

            if ($this->form_validation->run() == false) {
                $lead = $this->Leads->get($id);

                if (!$lead) {
                    error_404('admin');
                    return;
                }

                $name = explode(' ', $lead->name, 2);

                $data['firstname'] = $name[0];
                $data['lastname'] = ltrim($lead->name, $name[0] . ' ');
                $data['email'] = $lead->email;
                $data['phone'] = $lead->phone;
                $data['brands'] = $this->Brand->get();

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                $data['title'] = ucwords("create brand user");

                // Load page content
                $this->load->view('admin_panel/pages/brands/leads/create_user', $data);
            } else {

                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');

                $additional_data['firstname'] = $this->input->post('firstname');
                $additional_data['lastname'] = $this->input->post('lastname');
                $additional_data['gender'] = $this->input->post('gender');
                $additional_data['age_group'] = $this->input->post('age_group');
                $additional_data['phone'] = $this->input->post('phone');
                $additional_data['address1'] = $this->input->post('address1');
                $additional_data['address2'] = $this->input->post('address2');
                $additional_data['city'] = $this->input->post('city');
                $additional_data['state'] = $this->input->post('state');
                $additional_data['country'] = $this->input->post('country');
                $additional_data['zipcode'] = $this->input->post('zipcode');

                $create = $user_id = $this->User->create($username, $password, $email, $additional_data, array(3));

                // link user to brand
                $brand = $this->input->post('brand');
                $is_key_member = $this->input->post('key_member');
                $link = $this->Brand->link_user($user_id, $brand, $is_key_member);

                if ($create && $link) {
                    $this->session->set_flashdata('user_create_success', 1);
                } else {
                    $this->session->set_flashdata('user_create_success', 0);
                }
                redirect("admin/brands/leads");
            }
        }
    }

    /**
     * Delete a brandlead
     *
     * @param int $id
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('brandleads_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Leads->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Get all brandleads
     *
     * @return object
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('brandleads_get') or $this->ion_auth->is_admin()) {
            $brandleads = $this->Leads->get();
            $total_brands = sizeof($brandleads);
            $result = array(
                'iTotalRecords' => $total_brands,
                'iTotalDisplayRecords' => $total_brands,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $brandleads,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * View page for leads
     *
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('brandleads_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucfirst("Leads");

            // Load page content
            $this->load->view('admin_panel/pages/brands/leads/view', $data);
        }
    }
}
