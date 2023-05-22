<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct(); 
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Transactions';
        $this->load->model('transaction_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/transactions");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/transaction/index';
        
        $user_id = $from_date = $to_date = '';
        if ($this->input->post()) {

            $this->data['user_id'] = $user_id = $this->input->post('user_id');
            $this->data['from_date'] = $_from_date = $this->input->post('from_date');
            $this->data['to_date'] = $_to_date = $this->input->post('to_date');
            
            if ($_from_date) {
                $old_from_date = explode('/', $_from_date);
                $from_date = (isset($old_from_date[2]) ? $old_from_date[2] : date('Y')) . '-' . $old_from_date[1] . '-' . $old_from_date[0];
            }
            if ($_to_date) {
                $old_to_date = explode('/', $_to_date);
                $to_date = (isset($old_to_date[2]) ? $old_to_date[2] : date('Y')) . '-' . $old_to_date[1] . '-' . $old_to_date[0];
            }
        }
        
        $this->data['user_data'] = $this->transaction_model->getOwners();
        $this->data['transaction_data'] = $this->transaction_model->getAllTransaction($user_id, $from_date, $to_date);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->data['title'] = 'Transaction';
        $this->data['page'] = 'Edit ' . $this->data['title'];
        $this->data['view'] = 'admin/transaction/edit';

        if ($this->input->post()) {
            
            $transaction_id = trim($this->input->post('transaction_id'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['status'] = $status;
            $data['updated_date'] = DATETIME;
            
            if ($transaction_id > 0) {
                $this->transaction_model->updateTransaction($transaction_id, $data);
                $this->session->set_flashdata('success', "Transaction updated successfully!");
            } else {
                $this->session->set_flashdata('error', "Transaction not updated!");
            }
            redirect("admin/transactions");
        }
        
        $this->data['transaction_data'] = $this->transaction_model->getTransactionById($id);
        $this->load->view('admin/admin_master', $this->data);
    }

}
