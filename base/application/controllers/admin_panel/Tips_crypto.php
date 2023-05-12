<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * File: ~/application/controller/admin_panel/Tips_crypto.php
 * 
 * Controller for tipping system in crypto
 *
 * @package        Skearch
 * @author         Iftikhar Ejaz <ejaziftikhar@gmail.com>
 * @copyright      Copyright (c) 2022
 * @version        2.0
 */
class Tips_crypto extends MY_Controller
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

        $this->load->model('admin_panel/Tips_crypto_model', 'Crypto_addresses');
    }

    /**
     * Create brand
     *
     * @return void
     */
    public function create()
    {
        if (!$this->ion_auth_acl->has_permission('tips_system_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('coin_name', 'Coin Name', 'trim|required');
            $this->form_validation->set_rules('coin_wallet_address', 'Wallet Address', 'trim|required');

            if ($this->form_validation->run() == false) {
                // set page title
                $data['title'] = ucwords("Tip System | Add Wallet");

                $this->load->view('admin_panel/pages/tips/create', $data);
            } else {
                $coin_data['coin_name'] = $this->input->post('coin_name');
                $coin_data['coin_wallet_address'] = $this->input->post('coin_wallet_address');

                $create = $this->Crypto_addresses->create($coin_data);

                if ($create) {
                    $this->session->set_flashdata('create_success', 1);
                } else {
                    $this->session->set_flashdata('create_success', 0);
                }
                redirect("admin/tips");
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
        if (!$this->ion_auth_acl->has_permission('tips_system_delete') && !$this->ion_auth->is_admin()) {
            echo json_encode(-1);
        } else {
            $delete = $this->Crypto_addresses->delete($id);

            if ($delete) {
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
        if ($this->ion_auth_acl->has_permission('tips_system_get') or $this->ion_auth->is_admin()) {

            $crypto_addresses = $this->Crypto_addresses->get();
            $total_crypto_addresses = sizeof($crypto_addresses);

            $result = array(
                'iTotalRecords' => $total_crypto_addresses,
                'iTotalDisplayRecords' => $total_crypto_addresses,
                'sEcho' => 0,
                'sColumns' => "",
                'aaData' => $crypto_addresses,
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
        if (!$this->ion_auth_acl->has_permission('tips_system_get') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $data['title'] = ucwords("Tip System");
            $this->load->view('admin_panel/pages/tips/view', $data);
        }
    }

    /**
     * Update brand
     *
     * @param int $id Wallet id
     * @return void
     */
    public function update($id)
    {
        if (!$this->ion_auth_acl->has_permission('tips_system_update') && !$this->ion_auth->is_admin()) {
            // set page title
            $data['title'] = ucwords('access denied');
            $this->load->view('admin_panel/errors/error_403', $data);
        } else {
            $this->form_validation->set_rules('coin_name', 'Coin Name', 'trim|required');
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required');

            if ($this->form_validation->run() == false) {

                $wallet = $this->Crypto_addresses->get($id);

                $data['coin_name'] = $wallet->coin_name;
                $data['wallet_address'] = $wallet->coin_wallet_address;

                // set page title
                $data['title'] = ucwords("Tip System | Update Wallet");

                $this->load->view('admin_panel/pages/tips/update', $data);
            } else {
                $data['coin_name'] = $this->input->post('coin_name');
                $data['coin_wallet_address'] = $this->input->post('wallet_address');

                $update = $this->Crypto_addresses->update($id, $data);

                if ($update) {
                    $this->session->set_flashdata('update_success', 1);
                } else {
                    $this->session->set_flashdata('update_success', 0);
                }
                redirect("admin/tips");
            }
        }
    }
}
