<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedbacks extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct(); 
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Feedbacks';
        $this->load->model('feedback_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/feedbacks");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/feedback/index';
        
        $from_date = $to_date = '';
        if ($this->input->post()) {

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
        
        $this->data['feedback_data'] = $this->feedback_model->getAllFeedback($from_date, $to_date);
        $this->load->view('admin/admin_master', $this->data);
    }

    /*public function edit($id) {
        $this->data['title'] = 'Feedback';
        $this->data['page'] = 'Edit ' . $this->data['title'];
        $this->data['view'] = 'admin/feedback/edit';

        if ($this->input->post()) {
            
            $feedback_id = trim($this->input->post('feedback_id'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['status'] = $status;
            $data['updated_date'] = DATETIME;
            
            if ($feedback_id > 0) {
                $this->feedback_model->updateFeedback($feedback_id, $data);
                $this->session->set_flashdata('success', "Feedback updated successfully!");
            } else {
                $this->session->set_flashdata('error', "Feedback not updated!");
            }
            redirect("admin/feedbacks");
        }
        
        $this->data['feedback_data'] = $this->feedback_model->getFeedbackById($id);
        $this->load->view('admin/admin_master', $this->data);
    }*/

    public function export_csv() {
        
        $from_date = $to_date = '';
        if ($this->input->post()) {

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
        
        $filename = 'export_feedback_' . date('Ymd') . time();
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$filename.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, array('Sr', 'Name', 'Rating', 'Description', 'Quick Feedback', 'Created Date'));

        $feedback_data = $this->feedback_model->getAllFeedback($from_date, $to_date);
        $i = 0;
        foreach ($feedback_data as $value) {
            $i++;
            $feedback_list = array($i, $value->name, $value->rating, $value->description, $value->quick_feedback, $value->created_date);
            fputcsv($output, $feedback_list);
        }
        fclose($output);
    }
}
