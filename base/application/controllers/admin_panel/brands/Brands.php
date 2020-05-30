<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * File: ~/application/controller/admin_panel/brands/Brands.php
 * 
 * Controller for users
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Brands extends MY_Controller
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
        $this->load->model('Util_model', 'Util_model');
    }

    /**
     * Callback for brand validation
     *
     * @param string $brand Brand name
     * @return void
     */
    public function brand_check($brand)
    {
        $id =  $this->input->post('id');

        if ($this->ion_auth->username_check($brand)) {
            if ($this->User->get($id)->brand !== $brand) {
                $this->form_validation->set_message('username_check', 'The brand already exists.');
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Create brand
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('brands_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('brand', 'Brand', 'is_unique[skearch_brands.brand]|trim|required');
            $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'trim|required');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]|required');

            if ($this->form_validation->run() == false) {
                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                // set page title
                $data['title'] = ucwords("create brand");

                $this->load->view('admin_panel/pages/brands/create', $data);
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
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/brands");
            }
        }
    }

    /**
     * Delete brand
     *
     * @param int $id Brand ID
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('brands_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Brand->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Get brands
     *
     * @return void
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('brands_get') or $this->ion_auth->is_admin()) {

            $total_brands = $this->db->count_all_results('skearch_brands');
            $brands = $this->Brand->get();
            $result = array(
                'iTotalRecords' => $total_brands,
                'iTotalDisplayRecords' => $total_brands,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $brands,
            );

            // add members associated to each brand
            for ($i = 0; $i < sizeof($result['aaData']); $i++) {
                $members = $this->Brand->get_members($result['aaData'][$i]->id);
                $result['aaData'][$i]->members = sizeof($members);
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Show user list based on group
     *
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('brands_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['title'] = ucwords("Brands");

            $this->load->view('admin_panel/pages/brands/view', $data);
        }
    }

    /**
     * Get brands by name
     *
     * @param string $brand Brand name
     * @return object
     */
    public function search($brand)
    {
        if ($this->ion_auth_acl->has_permission('brands_get') or $this->ion_auth->is_admin()) {
            $result = $this->Brand->get_by_name($brand);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Update brand
     *
     * @param int $id Brand ID
     * @return void
     */
    public function update($id)
    {

        if (!$this->ion_auth_acl->has_permission('brands_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('brand', 'Brand', 'callback_brand_check|trim|required');
            $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'trim|required');
            $this->form_validation->set_rules('address2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'numeric|exact_length[5]|required');

            if ($this->form_validation->run() == false) {
                $brand = $this->Brand->get($id);

                $data['id'] = $brand->id;
                $data['brand'] = $brand->brand;
                $data['organization'] = $brand->organization;
                $data['address1'] = $brand->address1;
                $data['address2'] = $brand->address2;
                $data['city'] = $brand->city;
                $data['state'] = $brand->state;
                $data['country'] = $brand->country;
                $data['zipcode'] = $brand->zipcode;

                $data['states'] = $this->Util_model->get_state_list();
                $data['countries'] = $this->Util_model->get_country_list();

                $data['title'] = ucwords("edit brand");
                $this->load->view('admin_panel/pages/brands/edit', $data);
            } else {
                $brand_data['brand'] = $this->input->post('brand');
                $brand_data['organization'] = $this->input->post('organization');
                $brand_data['address1'] = $this->input->post('address1');
                $brand_data['address2'] = $this->input->post('address2');
                $brand_data['city'] = $this->input->post('city');
                $brand_data['state'] = $this->input->post('state');
                $brand_data['country'] = $this->input->post('country');
                $brand_data['zipcode'] = $this->input->post('zipcode');

                $update = $this->Brand->update($id, $brand_data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect("admin/brands");
            }
        }
    }
}
