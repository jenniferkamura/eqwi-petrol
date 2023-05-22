<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
    }

    public function index() {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pwd', 'Password', 'required');
        $this->form_validation->set_error_delimiters('', '');
        $data['msg'] = '';
        if ($this->form_validation->run() == TRUE) {
            $email = $this->input->post('email');
            $password = md5($this->input->post('pwd'));
            $data['msg'] = 'Emailid or Password did not matched.';
            if ($r_data = $this->login_model->getAdminLogin($email, $password)) {
                $logs = array('admin_id' => $r_data->admin_id, 'type' => 'Login', 'date_time' => DATETIME);
                $this->login_model->addLogs($logs);
                $this->session->set_userdata('admin_id', $r_data->admin_id);
                $this->session->set_userdata(PROJECT_NAME . '_user_data', $r_data);
                redirect('admin/home');
            }
        }
        $this->load->view('admin/login', $data);
    }
}
