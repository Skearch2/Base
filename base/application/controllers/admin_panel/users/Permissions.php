<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * File: ~/application/controller/admin_panel/users/Permissions.php
 * 
 * Controller for users groups
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Permissions extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            // redirect to the admin login page
            redirect('admin/auth/login');
        }

        if (!$this->ion_auth->in_group($this->config->item('staff', 'ion_auth'))) {
            $this->session->set_flashdata('no_access', 1);
            // redirect to the admin login page
            redirect('admin/auth/login');
        }
    }

    /**
     * Create a permission
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('permissions_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('description', 'Description', 'required|trim|min_length[8]');
            $this->form_validation->set_rules('key', 'Key', 'required|trim|is_unique[permissions.perm_key]');

            if ($this->form_validation->run() === false) {

                $data['title'] = ucwords('create permission');
                $this->load->view('admin_panel/pages/users/permissions/create', $data);
            } else {

                $key = $this->input->post('key');
                $description = $this->input->post('description');

                $create = $this->ion_auth_acl->create_permission($key, $description);
                if ($create) {
                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('success', 0);
                }
                redirect('admin/users/permission/create');
            }
        }
    }

    /**
     * Delete permission
     *
     * @param int $id ID of the permission
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('users_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->ion_auth_acl->remove_permission($id);

            return $delete;
        }
    }

    /**
     * Get all permissions
     *
     * @return void
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('permissions_get') or $this->ion_auth->is_admin()) {
            $total_permissions = $this->db->count_all_results('permissions');
            $permissions = $this->ion_auth_acl->permissions();
            $result = array(
                'iTotalRecords' => $total_permissions,
                'iTotalDisplayRecords' => $total_permissions,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $permissions,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Show permissions page
     *
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('permissions_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $data['title'] = ucwords("Permissions");

            $this->load->view('admin_panel/pages/users/permissions/view', $data);
        }
    }

    /**
     * Update permission
     *
     * @param int $id ID of the permission
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('permissions_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('description', 'Description', 'required|trim|min_length[8]');

            if ($this->form_validation->run() === false) {

                $permission = $this->ion_auth_acl->permission($id);

                $data = array(
                    'description' => $permission->perm_name,
                    'key' => $permission->perm_key,
                );

                $data['title'] = ucwords('edit permission');
                $this->load->view('admin_panel/pages/users/permissions/edit', $data);
            } else {

                $additional_data = array(
                    'perm_name' => $this->input->post('description')
                );

                $update = $this->ion_auth_acl->update_permission($id, $this->input->post('key'), $additional_data);;

                if ($update) {
                    $this->session->set_flashdata('success', 1);
                } else {
                    $this->session->set_flashdata('success', 0);
                }
                redirect('admin/users/permissions');
            }
        }
    }
}
