<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Home';
        $this->load->model('admin_model');
    }

    public function index() {
        
        //Check transaction status
        //$this->common_model->check_transaction_status();
        
        $this->data['title'] = 'Dashboard';
        $this->data['view'] = 'admin/dashboard';

        $this->data['count_owners'] = $this->common_model->getAllUserCount('Owner');
        $this->data['count_managers'] = $this->common_model->getAllUserCount('Manager');
        $this->data['count_attendants'] = $this->common_model->getAllUserCount('Attendant');
        $this->data['count_transporters'] = $this->common_model->getAllUserCount('Transporter');
        $this->data['count_stations'] = $this->common_model->getDashboardCount('station');
        $this->data['count_vehicles'] = $this->common_model->getDashboardCount('vehicle');
        $this->data['count_vendors'] = $this->common_model->getDashboardCount('vendor');
        $this->data['count_products'] = $this->common_model->getDashboardCount('category');
        $this->data['count_feedbacks'] = $this->common_model->getDashboardCount('feedback');
        $this->data['count_orders'] = $this->common_model->getOrderCounts('Completed'); 
        $this->data['count_pending_orders'] = $this->common_model->getOrderCounts('Pending');
        $this->data['count_vendor_purchase'] = $this->common_model->getDashboardCount('vendor_purchase');
        $this->data['count_coupons'] = $this->common_model->getDashboardCount('coupons');
        $this->data['count_pending_transaction'] = $this->common_model->getTransactionCounts('Pending');
        $this->data['count_paid_transaction'] = $this->common_model->getTransactionCounts('Paid');
         
        $this->load->view('admin/admin_master', $this->data);
    }

    public function profile() {
        $this->data['title'] = 'Profile';
        $this->data['view'] = 'admin/profile';
        $id = $this->session->userdata('admin_id');
        if ($this->input->post()) {
            $name = $this->input->post('name');
            $this->admin_model->updateAdmin($id, array('full_name' => $name));
            $this->session->set_flashdata('success', 'Profile update successfully!');
            redirect('admin/home/profile');
        }
        $this->data['data'] = $this->admin_model->getAdminById($id);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function change_password() {
        $this->data['title'] = 'Change Password';
        $this->data['view'] = 'admin/change_password';
        if ($this->input->post()) {

            $password = $this->input->post('password');
            $newpassword = $this->input->post('newpassword');
            $id = $this->session->userdata('admin_id');

            if ($admin = $this->admin_model->getAdminById($id)) {
                if ($admin->password == md5($password)) {
                    $data = array('password' => md5($newpassword));
                    $this->admin_model->updateAdmin($admin->admin_id, $data);
                    $this->session->set_flashdata('success', 'Password changed successfully');
                } else {
                    $this->session->set_flashdata('error', 'Wrong current password');
                }
            }
            redirect('admin/change_password');
        }
        $this->load->view('admin/admin_master', $this->data);
    }

    public function backup() {
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/vendor_purchase");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->load->helper('directory');
        $this->data['page'] = 'Database Backup';
        $this->data['title'] = 'Database Backup';
        $this->data['view'] = 'admin/backup';
        $this->load->view('admin/admin_master', $this->data);
    }

    public function create_backup() {
        $this->admin_model->create_backup();
        $this->session->set_flashdata('success', 'Backup created');
        redirect('admin/backup');
    }

    public function download_backup($file_name) {
        $this->load->helper('download');
        $file = FCPATH . 'db_backup/' . $file_name;
        force_download($file, NULL);
    }

    public function delete_backup($file_name) {
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/backup");
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $path_to_file = 'db_backup/' . $file_name;
        if (unlink($path_to_file)) {
            $this->session->set_flashdata('success', 'Backup deleted');
        } else {
            $this->session->set_flashdata('error', 'File not found');
        }
        redirect('admin/backup');
    }

    public function restore_backup() {
        $this->admin_model->restore_backup();
        $this->session->set_flashdata('success', 'Backup restored');
        redirect('admin/backup');
    }

    public function logs() {
        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->data['login_admin_id'], "admin/home/logs");
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $this->data['page'] = 'Logs';
        $this->data['title'] = 'Logs';
        $this->data['view'] = 'admin/logs';
        $this->data['logs_data'] = $this->admin_model->getAllLogs();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function logout() {
        $admin_id = $this->session->userdata('admin_id');
        $logs = array('admin_id' => $admin_id, 'type' => 'Logout', 'date_time' => DATETIME);
        $this->admin_model->addLogs($logs);
                
        $this->session->sess_destroy();
        redirect('admin/login');
    }

}
