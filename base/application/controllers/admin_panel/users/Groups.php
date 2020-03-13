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

        if (!$this->ion_auth->is_admin()) {
            // redirect them to the login page
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

        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[5]|is_unique[skearch_groups.name]');
        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[8]');

        if ($this->form_validation->run() === false) {

            $data['title'] = ucwords('create user group');
            $this->load->view('admin_panel/pages/users/groups/create', $data);
        } else {

            $create = $this->Group->create_user_group();

            if ($create) {
                $this->session->set_flashdata('success', 1);
            } else {
                $this->session->set_flashdata('success', 0);
            }
            redirect('admin/users/groups');
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
        $delete = $this->Group->delete($id);

        return $delete;
    }

    /**
     * Get all users groups
     *
     * @return void
     */
    public function get()
    {
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

    /**
     * Show users groups page
     *
     * @return void
     */
    public function index()
    {
        $data['title'] = ucwords("users groups");

        $this->load->view('admin_panel/pages/users/groups/view', $data);
    }

    /**
     * Update user group
     *
     * @param int $id ID of the user group
     * @return void
     */
    public function update($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[8]');

        if ($this->form_validation->run() === false) {

            $group = $this->Group->get($id);

            $data = array(
                'name' => $group->name,
                'description' => $group->description,
            );

            $data['title'] = ucwords('edit group');
            $this->load->view('admin_panel/pages/users/groups/edit', $data);
        } else {

            $update = $this->Group->update($id);

            if ($update) {
                $this->session->set_flashdata('success', 1);
            } else {
                $this->session->set_flashdata('success', 0);
            }
            redirect('admin/users/groups');
        }
    }
}
