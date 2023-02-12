<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * File: ~/application/controller/admin_panel/TOS_PP.php
 * 
 * Controller for TOS/PP
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2023
 * @version        2.0
 */
class TOS_PP extends MY_Controller
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

        $this->load->model('admin_panel/Tos_pp_model', 'TOS');
    }

    /**
     * Create new TOS/PP
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('tos_create') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('content', 'Content', 'trim|required');

            if ($this->form_validation->run() == false) {
                // set page title
                $data['title'] = ucwords("TOS/PP | Create");

                $this->load->view('admin_panel/pages/tos/create', $data);
            } else {
                $data['content'] = $this->input->post('content');

                $create = $this->TOS->create($data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/tos");
            }
        }
    }

    /**
     * Get all TOS/PP
     * 
     * @param int $id id
     * @return void
     */
    public function get($id = null)
    {
        if ($this->ion_auth_acl->has_permission('tos_get') or $this->ion_auth->is_admin()) {

            if ($id) {
                $result = $this->TOS->get($id);
            } else {
                $tos = $this->TOS->get();
                $total_tos = sizeof($tos);

                $result = array(
                    'iTotalRecords' => $total_tos,
                    'iTotalDisplayRecords' => $total_tos,
                    'sEcho' => 0,
                    'sColumns' => "",
                    'aaData' => $tos,
                );
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * View page for TOS/PP
     *
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('tos_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['title'] = ucwords("TOS/PP");
            $this->load->view('admin_panel/pages/tos/view', $data);
        }
    }
}
