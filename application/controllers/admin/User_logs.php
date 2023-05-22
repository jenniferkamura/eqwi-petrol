<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_logs extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct(); 
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'User Logs';
        $this->load->model('user_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/user_logs");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        
        $this->data['page'] = 'Logs';
        $this->data['view'] = 'admin/user/logs';
        $this->data['logs_data'] = $this->user_model->getAllLogs();
        
        $this->load->view('admin/admin_master', $this->data);
    }
}
