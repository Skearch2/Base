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
class Giveaways extends MY_Controller
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

        $this->load->model('admin_panel/Giveaway_model', 'Giveaways');
        $this->load->model('admin_panel/users/User_model', 'Users');

        // update status on giveaways based on start/end date
        $this->Giveaways->update_status();
    }

    /**
     * Create brand
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('giveaway_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('end_date', 'Deadline', 'required');
            $this->form_validation->set_rules('crypto', 'Crypto', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

            if ($this->form_validation->run() == false) {
                // set page title
                $data['title'] = ucwords("create giveaway");

                $this->load->view('admin_panel/pages/giveaways/create', $data);
            } else {

                $giveaway_data['title'] = $this->input->post('title');
                $giveaway_data['end_date'] = date("Y-m-d H:i:s", strtotime($this->input->post('end_date')));
                $giveaway_data['crypto'] = $this->input->post('crypto');
                $giveaway_data['amount'] = $this->input->post('amount');

                $create = $this->Giveaways->create($giveaway_data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/giveaways");
            }
        }
    }

    /**
     * Delete giveaway
     *
     * @param int $id giveaway ID
     * @return void
     */
    public function delete($id)
    {
        if (!$this->ion_auth_acl->has_permission('giveaways_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Giveaways->delete($id);

            if ($delete) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Draw giveaway
     *
     * @param int $id giveaway ID
     * @return void
     */
    public function draw($id)
    {
        if (!$this->ion_auth_acl->has_permission('giveaways_update') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {

            $participants = $this->Giveaways->get_participants($id);

            if (!$participants) {
                echo json_encode(0);
                return;
            }

            $rand_key = array_rand($participants, 1);

            $user_id = $participants[$rand_key]->id;

            $set = $this->Giveaways->set_winner($id, $user_id);

            if ($set) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /**
     * Get giveaways
     * 
     * @param int $id Brand ID
     * @return void
     */
    public function get()
    {
        if ($this->ion_auth_acl->has_permission('giveaways_get') or $this->ion_auth->is_admin()) {

            $giveaways = $this->Giveaways->get();
            $total_giveaways = sizeof($giveaways);

            $result = array(
                'iTotalRecords' => $total_giveaways,
                'iTotalDisplayRecords' => $total_giveaways,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $giveaways,
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * Get giveaway participants
     * @param int $id giveaway ID
     * @return void
     */
    public function get_participants($id)
    {
        if ($this->ion_auth_acl->has_permission('giveaways_get') or $this->ion_auth->is_admin()) {

            $participants = $this->Giveaways->get_participants($id);
            $total_participants = count($participants);
            $result = array(
                'iTotalRecords' => $total_participants,
                'iTotalDisplayRecords' => $total_participants,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $participants
            );

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
    }

    /**
     * View page for giveaways listing
     *
     * @return void
     */
    public function index()
    {
        if (!$this->ion_auth_acl->has_permission('giveaways_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['title'] = ucwords("Giveaways");
            $this->load->view('admin_panel/pages/giveaways/view', $data);
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

        if (!$this->ion_auth_acl->has_permission('giveaways_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('end_date', 'Deadline', 'required');
            $this->form_validation->set_rules('crypto', 'Crypto', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');

            if ($this->form_validation->run() == false) {
                $data['giveaway'] = $this->Giveaways->get_by_id($id);

                $data['title'] = ucwords("edit giveaway");
                $this->load->view('admin_panel/pages/giveaways/edit', $data);
            } else {
                $giveaway_data['title'] = $this->input->post('title');
                $giveaway_data['end_date'] = date("Y-m-d H:i:s", strtotime($this->input->post('end_date')));
                $giveaway_data['crypto'] = $this->input->post('crypto');
                $giveaway_data['amount'] = $this->input->post('amount');

                $update = $this->Giveaways->update($id, $giveaway_data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect("admin/giveaways");
            }
        }
    }

    /**
     * Show giveaway participants page
     * 
     * @param int $id giveaway ID
     * @return void
     */
    public function view_participants($id)
    {
        if (!$this->ion_auth_acl->has_permission('giveaways_get') && !$this->ion_auth->is_admin()) {

            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['giveaway'] = $this->Giveaways->get_by_id($id);

            $data['title'] = ucwords("giveaway participants");
            $this->load->view('admin_panel/pages/giveaways/participants', $data);
        }
    }
}
