<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_admin extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Sub Admin';
        $this->load->model('admin_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/sub_admin");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';
        
        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/sub_admin/index';
        $this->data['sub_admin_data'] = $this->admin_model->getALLSubAdmin();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $this->data['page'] = $id ? "Edit Sub Admin" : "Add Sub Admin";
        $this->data['view'] = 'admin/sub_admin/edit';

        if ($this->input->post()) {
            //echo '<pre>';print_r($_POST);die;
            $sub_admin_id = trim($this->input->post('sub_admin_id'));
            $full_name = trim($this->input->post('full_name'));
            $role_id = trim($this->input->post('role_id'));
            if (!$sub_admin_id) {
                $email_id = trim($this->input->post('email_id'));
                $password = trim($this->input->post('password'));
            }
            $status = trim($this->input->post('status'));

            $this->form_validation->set_rules("full_name", "Sub Admin Name", "required", array('required' => 'Sub Admin name cannot be empty'));
            $this->form_validation->set_rules('role_id', 'Role', 'required', array('required' => 'Please select role'));
            if (!$sub_admin_id) {
                $this->form_validation->set_rules('email_id', 'Email', 'required|is_unique[admin.email_id]', array('is_unique' => 'Email Address Must be Unique...'));
                $this->form_validation->set_rules('password', 'Password', 'required');
            }
            if ($this->form_validation->run() == FALSE) {
                $single_line_message = "";
                if (form_error("full_name")) {
                    $single_line_message .= strip_tags(form_error("full_name"));
                }
                if (form_error("role_id")) {
                    $single_line_message .= $single_line_message ? form_error("role_id") : strip_tags(form_error("role_id"));
                }
                if (!$sub_admin_id) {
                    if (form_error("email_id")) {
                        $single_line_message .= $single_line_message ? form_error("email_id") : strip_tags(form_error("email_id"));
                    }
                    if (form_error("password")) {
                        $single_line_message .= $single_line_message ? form_error("password") : strip_tags(form_error("password"));
                    }
                }
                $this->session->set_flashdata('error', $single_line_message);
                redirect("admin/sub_admin");
            }

            $data = array();
            $data['full_name'] = $full_name;
            $data['role_id'] = $role_id;
            $data['status'] = $status;
            if (!$sub_admin_id) {
                $data['email_id'] = $email_id;
                $data['password'] = md5($password);
            }

            //echo '<pre>';print_r($_POST);print_r($data);die;
            if ($sub_admin_id > 0) {
                $data['updation_datetime'] = DATETIME;
                $this->admin_model->updateAdmin($sub_admin_id, $data);
                $this->session->set_flashdata('success', "Sub Admin updated successfully!");
            } else {
                $data['creation_datetime'] = DATETIME;
                $sub_admin_id = $this->admin_model->addAdmin($data);
                $this->session->set_flashdata('success', "Sub Admin added successfully!");
            }

            //Sub Admin Rights
            if ($mpriv = $this->input->post('mpriv')) {
                foreach ($mpriv as $val) { 
                    # code...
                    $data = array();
                    $data["admin_id"] = $sub_admin_id;
                    $data["menu_type"] = $val["menu_type"];
                    $data["menu_id"] = $val["menu_id"];
                    $data["menu_name"] = $val["menu_name"];
                    $data["menu_url"] = $val["menu_url"];
                    $data["list_p"] = isset($val["list_p"]) && $val["list_p"] ? 1 : 0;
                    $data["add_p"] = isset($val["add_p"]) && $val["add_p"] ? 1 : 0;
                    $data["edit_p"] = isset($val["edit_p"]) && $val["edit_p"] ? 1 : 0;
                    $data["delete_p"] = isset($val["delete_p"]) && $val["delete_p"] ? 1 : 0;
                    $this->admin_model->addPrivilege($data, $val["id"]);
                }
            }

            if ($spriv = $this->input->post('spriv')) {
                foreach ($spriv as $val) {
                    # code...
                    $data = array();
                    $data["admin_id"] = $sub_admin_id;
                    $data["menu_type"] = $val["menu_type"];
                    $data["menu_id"] = $val["menu_id"];
                    $data["menu_name"] = $val["menu_name"];
                    $data["menu_url"] = $val["menu_url"];
                    $data["list_p"] = isset($val["list_p"]) && $val["list_p"] ? 1 : 0;
                    $data["add_p"] = isset($val["add_p"]) && $val["add_p"] ? 1 : 0;
                    $data["edit_p"] = isset($val["edit_p"]) && $val["edit_p"] ? 1 : 0;
                    $data["delete_p"] = isset($val["delete_p"]) && $val["delete_p"] ? 1 : 0;
                    $this->admin_model->addPrivilege($data, $val["id"]);
                }
            }
            redirect("admin/sub_admin");
        }

        $sub_admin = $this->admin_model->getAdminById($id);
        if($sub_admin && $sub_admin->is_super_admin){
            $this->data['role_data'] = $this->data["item_details"] = array();            
        }else{
            $this->data['role_data'] = $this->admin_model->getAllRole();
            $this->data['admin_details'] = $this->admin_model->getAdminById($id);
            $this->data["menu_items"] = $this->common_model->get_menu_details($id);
        }
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->admin_model->deleteSubAdmin($id);
            $this->session->set_flashdata('success', 'Sub Admin deleted successfully!');
        }
        redirect('admin/sub_admin');
    }

}
