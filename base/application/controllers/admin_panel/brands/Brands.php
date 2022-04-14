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
        $this->load->model('admin_panel/brands/Payments_model', 'Payments');
        $this->load->model('Util_model', 'Util_model');
    }

    /**
     * Callback for brand duplicate check
     *
     * @param string $brand Brand name
     * @return void
     */
    public function brand_check($brand)
    {
        //TODO

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
            $this->form_validation->set_rules('note', 'Note', 'trim|max_length[5000]');

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
                $brand_data['note'] = $this->input->post('note');
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
     * @param int $id Brand ID
     * @return void
     */
    public function get($id = null)
    {
        if ($this->ion_auth_acl->has_permission('brands_get') or $this->ion_auth->is_admin()) {

            if (!is_null($id) && $id > 0) {
                $result = $this->Brand->get($id);

                // include members associated to the brand
                $members = $this->Brand->get_members($id);
                $result->members = sizeof($members);
            } else {
                $total_brands = $this->db->count_all_results('skearch_brands');
                $brands = $this->Brand->get();
                $result = array(
                    'iTotalRecords' => $total_brands,
                    'iTotalDisplayRecords' => $total_brands,
                    'sEcho' => 0,
                    'sColumns' => "",
                    'aaData' => $brands,
                );

                for ($i = 0; $i < sizeof($result['aaData']); $i++) {
                    // add members associated to each brand
                    $members = $this->Brand->get_members($result['aaData'][$i]->id);
                    $result['aaData'][$i]->members = sizeof($members);

                    // add # of payments by each brand
                    $payments = $this->Payments->get($result['aaData'][$i]->id);
                    $result['aaData'][$i]->payments = sizeof($payments);
                }
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get brand members
     * @param int $id Brand ID
     * @return void
     */
    public function get_members($id)
    {
        if ($this->ion_auth_acl->has_permission('users_get') or $this->ion_auth->is_admin()) {

            $members = $this->Brand->get_members($id);
            $total_members = count($members);
            $result = array(
                'iTotalRecords' =>  $total_members,
                'iTotalDisplayRecords' =>  $total_members,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $members,
            );


            // for ($i = 0; $i < sizeof($result['aaData']); $i++) {
            //     // add members associated to each brand
            //     $members = $this->Brand->get_members($result['aaData'][$i]->id);
            //     $result['aaData'][$i]->members = sizeof($members);

            //     // add # of payments by each brand
            //     $payments = $this->Payments->get($result['aaData'][$i]->id);
            //     $result['aaData'][$i]->payments = sizeof($payments);
            // }


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
            $this->form_validation->set_rules('note', 'Note', 'trim|max_length[5000]');

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
                $data['note'] = $brand->note;

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
                $brand_data['note'] = $this->input->post('note');

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

    /**
     * Show brand members page associated to brand
     * @param int $id Brand ID
     * @return void
     */
    public function members($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_get') && !$this->ion_auth->is_admin()) {

            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['brand'] = $this->Brand->get($id);;

            $data['title'] = ucwords("Brand Members");
            $this->load->view('admin_panel/pages/brands/members', $data);
        }
    }

    /**
     * Upload media
     *
     * @param string $scope          Scope: Default|Global|Umbrella|Field
     * @param int $scope_id          Scope id
     * @return string|false
     */
    private function _upload_media($scope, $scope_id)
    {
        $tmp = $this->config->item('tmp_dir');

        if (!file_exists("./$tmp/")) {
            mkdir("./$tmp/", $this->config->item('tmp_permissions'));
        }

        $config['upload_path'] = "./$tmp/";
        $config['max_size'] = $this->config->item('upload_file_size');
        $config['allowed_types'] = $this->config->item('upload_file_types');
        $config['encrypt_name'] = true;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        $upload = $this->upload->do_upload('media');

        if ($upload) {

            $media = $this->upload->data();

            $folder_path = FCPATH . 'base/media/brands/';

            if (move_uploaded_file($_FILES['media']['tmp_name'], $folder_path . $media['file_name'])) {
                return $media['file_name'];
            } else {
                log_message('error', 'Unable to upload media.');
                return false;
            }
        } else {
            log_message('error', 'Unable to upload media.');
            return false;
            // http_response_code(500);
            // echo json_encode($this->upload->display_errors());
        }
    }
}
