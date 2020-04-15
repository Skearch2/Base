<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * File: ~/application/controller/admin_panel/users/Groups.php
 * 
 * Controller for users groups
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2020
 * @version        2.0
 */
class Groups extends MY_Controller
{
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

        $this->load->model('admin_panel/users/Group_model', 'Group');
    }

    /**
     * Create a user group
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('groups_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[5]|is_unique[skearch_groups.name]');
            $this->form_validation->set_rules('description', 'Description', 'trim|min_length[8]');

            if ($this->form_validation->run() === false) {

                $data['title'] = ucwords('create user group');
                $this->load->view('admin_panel/pages/users/groups/create', $data);
            } else {

                $create = $this->Group->create_user_group();

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect('admin/users/groups');
            }
        }
    }

    /**
     * Delete user group
     *
     * @param int $id ID of the user group
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('groups_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Group->delete($id);

            return $delete;
        }
    }

    /**
     * Get all users groups
     *
     * @return void
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('groups_get') or $this->ion_auth->is_admin()) {
            $total_groups = $this->db->count_all_results('skearch_users_groups');
            $groups = $this->Group->get();
            $result = array(
                'iTotalRecords' => $total_groups,
                'iTotalDisplayRecords' => $total_groups,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $groups,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Show users groups page
     *
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('groups_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['title'] = ucwords("users groups");

            $this->load->view('admin_panel/pages/users/groups/view', $data);
        }
    }

    /**
     * Update user group
     *
     * @param int $id ID of the user group
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('groups_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {

            $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[5]');
            $this->form_validation->set_rules('description', 'Description', 'trim|min_length[8]');

            if ($this->form_validation->run() === false) {

                $group = $this->Group->get($id);

                $data = array(
                    'name' => $group->name,
                    'description' => $group->description,
                );

                $data['permissions'] = $this->ion_auth_acl->permissions('full', 'perm_key');
                $data['group_permissions'] = $this->ion_auth_acl->get_group_permissions($id);

                $data['title'] = ucwords('edit group');
                $this->load->view('admin_panel/pages/users/groups/edit', $data);
            } else {

                $name = $this->input->post('name');
                $additional_data = array(
                    'description' => $this->input->post('description')
                );

                $update = TRUE;

                // update group info
                if ($this->Group->update($id, $name, $additional_data) === FALSE) {
                    $update = FALSE;
                }

                // update group permissions
                foreach ($this->input->post() as $k => $v) {
                    if (substr($k, 0, 5) == 'perm_') {
                        $permission_id  =   str_replace("perm_", "", $k);

                        if ($v == "X") {
                            if ($this->ion_auth_acl->remove_permission_from_group($id, $permission_id) === FALSE) {
                                $update = FALSE;
                            }
                        } else {
                            if ($this->ion_auth_acl->add_permission_to_group($id, $permission_id, $v) === FALSE) {
                                $update = FALSE;
                            }
                        }
                    }
                }

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect('admin/users/groups');
            }
        }
    }
}
