<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Vendors';
        $this->load->model('vendor_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/vendor");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/vendor/index';
        $this->data['vendor_data'] = $this->vendor_model->getAllVendor();
        $this->load->view('admin/admin_master', $this->data);
    }
    
    public function edit($id) {

        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Vendor';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/vendor/edit';

        if ($this->input->post()) {
            
            $vendor_id = trim($this->input->post('vendor_id'));

            $this->form_validation->set_rules("name", "Name", "required", array('required' => 'Name cannot be empty'));
            $this->form_validation->set_rules("email", "Email", "required|valid_email", array('required' => 'Email cannot be empty'));
            $this->form_validation->set_rules("mobile", "Mobile", "required", array('required' => 'Mobile cannot be empty'));

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('name', 'email', 'mobile');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/vendor");
            }

            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $mobile = trim($this->input->post('mobile'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));
            $address = trim($this->input->post('address'));
            $status = trim($this->input->post('status'));

            $msg = '';
            if ($email && $this->vendor_model->checkVendorExist($email, 'email', $vendor_id)) {
                $msg = 'Email id already exists';
            }
            if ($this->vendor_model->checkVendorExist($mobile, 'mobile', $vendor_id)) {
                $msg = 'Mobile number already exists';
            }

            if ($msg != '') {
                $this->session->set_flashdata('error', $msg);
                redirect("admin/vendor");
            }

            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            $data['mobile'] = $mobile;
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;
            $data['address'] = $address;
            $data['status'] = $status;

            if ($vendor_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->vendor_model->updateVendor($vendor_id, $data);
                $this->session->set_flashdata('success', "Vendor updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $vendor_id = $this->vendor_model->addVendor($data);
                $this->session->set_flashdata('success', "Vendor added successfully!");
            }
            redirect("admin/vendor");
        }

        $this->data['vendor_data'] = $this->vendor_model->getVendorById($id, 0);
        $this->data['vendor_id'] = isset($this->data['vendor_data']) && $this->data['vendor_data']->vendor_id ? $this->data['vendor_data']->vendor_id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }

    public function check_vendor_exists() {

        $vendor_id = trim($this->input->post('id'));
        $value = trim($this->input->post('val'));
        $type = trim($this->input->post('type'));

        $success = 'true';
        if ($this->vendor_model->checkVendorExist($value, $type, $vendor_id)) {
            $success = 'false';
        }
        echo $success;
    }

    public function export_csv() {
        $filename = 'export_volunteer_' . date('Ymd') . time();
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$filename.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, array('Sr', 'Vendor Name', 'Gender', 'Email', 'Mobile', 'Verified', 'Company', 'Date of Birth', 'Address', 'Created Date', 'Status'));

        $vendor_data = $this->vendor_model->getAllVendor();
        $i = 0;
        foreach ($vendor_data as $value) {
            $i++;
            $verified = $value->mobile_verified == 1 ? 'Yes' : 'No';
            $vendor_list = array($i, $value->name, $value->gender, $value->email, $value->mobile, $verified, $value->company, $value->birth_date, $value->address, $value->creation_datetime, ($value->status ? 'Active' : 'Inactive'));
            fputcsv($output, $vendor_list);
        }
        fclose($output);
    }

    public function delete($id) {

        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->vendor_model->deleteVendor($id);
            $this->session->set_flashdata('success', 'Vendor deleted successfully!');
        }
        redirect("admin/vendor");
    }
}
