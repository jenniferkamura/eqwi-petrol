<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Roles';
        $this->load->model('admin_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/role");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/role/index';
        $this->data['role_data'] = $this->admin_model->getAllRole();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $this->data['page'] = $id ? "Edit Role" : "Add Role";
        $this->data['view'] = 'admin/role/edit';
        if ($this->input->post()) {

            $role_id = trim($this->input->post('role_id'));
            $role_name = trim($this->input->post('role_name'));
            $status = trim($this->input->post('status'));

            $this->form_validation->set_rules("role_name", "Role Name", "required", array('required' => 'Role name cannot be empty'));
            if ($this->form_validation->run() == FALSE) {
                $single_line_message = "";
                if (form_error("role_name")) {
                    $single_line_message .= strip_tags(form_error("role_name"));
                }
                $this->session->set_flashdata('error', $single_line_message);
                redirect("admin/role");
            }
            
            $data = array();
            $data['role_name'] = $role_name;
            $data['status'] = $status;

            if ($role_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->admin_model->updateRole($role_id, $data);
                $this->session->set_flashdata('success', "Role updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $this->admin_model->addRole($data);
                $this->session->set_flashdata('success', "Role added successfully!");
            }
            redirect("admin/role");
        }
        $this->data['role_data'] = $this->admin_model->getRoleById($id, 0);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->admin_model->deleteRole($id);
            $this->session->set_flashdata('success', 'Role deleted successfully!');
        }
        redirect('admin/role');
    }
}
