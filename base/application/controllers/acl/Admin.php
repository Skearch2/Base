<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Admin.php
 *
 * @package     CI-ACL
 * @author      Steve Goodwin
 * @copyright   2015 Plumps Creative Limited
 */
class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
            redirect('/myskearch/auth/login');

        if (!$this->ion_auth_acl->has_permission('access_admin'))
            die('You have no Admin Access');
    }

    public function index()
    {
        redirect('/acl/admin/manage');
    }

    public function manage()
    {
        $this->load->view('acl/manage');
    }

    public function permissions()
    {
        $data['permissions']    =   $this->ion_auth_acl->permissions('full');

        $this->load->view('acl/permissions', $data);
    }

    public function add_permission()
    {
        if ($this->input->post() && $this->input->post('cancel'))
            redirect('/acl/admin/permissions', 'refresh');

        $this->form_validation->set_rules('perm_key', 'key', 'required|trim');
        $this->form_validation->set_rules('perm_name', 'name', 'required|trim');

        $this->form_validation->set_message('required', 'Please enter a %s');

        if ($this->form_validation->run() === FALSE) {
            $data['message'] = ($this->ion_auth_acl->errors() ? $this->ion_auth_acl->errors() : $this->session->flashdata('message'));

            $this->load->view('acl/add_permission', $data);
        } else {
            $new_permission_id = $this->ion_auth_acl->create_permission($this->input->post('perm_key'), $this->input->post('perm_name'));
            if ($new_permission_id) {
                // check to see if we are creating the permission
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("/acl/admin/permissions", 'refresh');
            }
        }
    }

    public function update_permission()
    {
        if ($this->input->post() && $this->input->post('cancel'))
            redirect('acl/admin/permissions', 'refresh');

        $permission_id  =   $this->uri->segment(4);

        if (!$permission_id) {
            $this->session->set_flashdata('message', "No permission ID passed");
            redirect("acl/admin/permissions", 'refresh');
        }

        $permission =   $this->ion_auth_acl->permission($permission_id);

        $this->form_validation->set_rules('perm_key', 'key', 'required|trim');
        $this->form_validation->set_rules('perm_name', 'name', 'required|trim');

        $this->form_validation->set_message('required', 'Please enter a %s');

        if ($this->form_validation->run() === FALSE) {
            $data['message']    = ($this->ion_auth_acl->errors() ? $this->ion_auth_acl->errors() : $this->session->flashdata('message'));
            $data['permission'] = $permission;

            $this->load->view('acl/edit_permission', $data);
        } else {
            $additional_data    =   array(
                'perm_name' =>  $this->input->post('perm_name')
            );

            $update_permission = $this->ion_auth_acl->update_permission($permission_id, $this->input->post('perm_key'), $additional_data);
            if ($update_permission) {
                // check to see if we are creating the permission
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("/acl/admin/permissions", 'refresh');
            }
        }
    }

    public function delete_permission()
    {
        if ($this->input->post() && $this->input->post('cancel'))
            redirect('/acl/admin/permissions', 'refresh');

        $permission_id  =   $this->uri->segment(4);

        if (!$permission_id) {
            $this->session->set_flashdata('message', "No permission ID passed");
            redirect("acl/admin/permissions", 'refresh');
        }

        if ($this->input->post() && $this->input->post('delete')) {
            if ($this->ion_auth_acl->remove_permission($permission_id)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("acl/admin/permissions", 'refresh');
            } else {
                echo $this->ion_auth_acl->messages();
            }
        } else {
            $data['message'] = ($this->ion_auth_acl->errors() ? $this->ion_auth_acl->errors() : $this->session->flashdata('message'));

            $this->load->view('/acl/delete_permission', $data);
        }
    }

    public function groups()
    {
        $data['groups'] = $this->ion_auth->groups()->result();

        $this->load->view('/acl/groups', $data);
    }

    public function group_permissions()
    {
        if ($this->input->post() && $this->input->post('cancel'))
            redirect('/acl/admin/groups', 'refresh');

        $group_id  =   $this->uri->segment(4);

        if (!$group_id) {
            $this->session->set_flashdata('message', "No group ID passed");
            redirect("acl/admin/groups", 'refresh');
        }

        if ($this->input->post() && $this->input->post('save')) {

            foreach ($this->input->post() as $k => $v) {
                if (substr($k, 0, 5) == 'perm_') {
                    $permission_id  =   str_replace("perm_", "", $k);

                    if ($v == "X")
                        $this->ion_auth_acl->remove_permission_from_group($group_id, $permission_id);
                    else
                        $this->ion_auth_acl->add_permission_to_group($group_id, $permission_id, $v);
                }
            }

            redirect('/acl/admin/groups', 'refresh');
        }

        $data['permissions']            =   $this->ion_auth_acl->permissions('full', 'perm_key');
        $data['group_permissions']      =   $this->ion_auth_acl->get_group_permissions($group_id);

        // echo "<pre>";
        // print_r($data['permissions']);
        // print_r($data['group_permissions']);
        // echo "</pre>";

        $this->load->view('/acl/group_permissions', $data);
    }

    public function users()
    {
        $data['users']  =   $this->ion_auth->users()->result();

        $this->load->view('/acl/users', $data);
    }

    public function manage_user()
    {
        $user_id  =   $this->uri->segment(4);

        if (!$user_id) {
            $this->session->set_flashdata('message', "No user ID passed");
            redirect("acl/admins/users", 'refresh');
        }

        $data['user']               =   $this->ion_auth->user($user_id)->row();
        $data['user_groups']        =   $this->ion_auth->get_users_groups($user_id)->result();
        $data['user_acl']           =   $this->ion_auth_acl->build_acl($user_id);

        $this->load->view('/acl/manage_user', $data);
    }

    public function user_permissions()
    {
        $user_id  =   $this->uri->segment(4);

        if (!$user_id) {
            $this->session->set_flashdata('message', "No user ID passed");
            redirect("acl/admin/users", 'refresh');
        }

        if ($this->input->post() && $this->input->post('cancel'))
            redirect("/acl/admin/manage-user/{$user_id}", 'refresh');


        if ($this->input->post() && $this->input->post('save')) {
            print_r($this->input->post());

            foreach ($this->input->post() as $k => $v) {
                if (substr($k, 0, 5) == 'perm_') {
                    $permission_id  =   str_replace("perm_", "", $k);

                    if ($v == "X")
                        $this->ion_auth_acl->remove_permission_from_user($user_id, $permission_id);
                    else {
                        $this->ion_auth_acl->add_permission_to_user($user_id, $permission_id, $v);
                        // echo $p;
                    }
                }
            }

            // die();

            redirect("/acl/admin/manage-user/{$user_id}", 'refresh');
        }

        $user_groups    =   $this->ion_auth_acl->get_user_groups($user_id);

        $data['user_id']                =   $user_id;
        $data['permissions']            =   $this->ion_auth_acl->permissions('full', 'perm_key');
        $data['group_permissions']      =   $this->ion_auth_acl->get_group_permissions($user_groups);
        $data['users_permissions']      =   $this->ion_auth_acl->build_acl($user_id);
        // print_r($data['users_permissions']);

        $this->load->view('/acl/user_permissions', $data);
    }
}
