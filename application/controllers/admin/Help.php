<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

    private $admin_id;
    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Help & Supports';
        $this->load->model('help_model'); 
        
        $this->admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';
    }

    public function index() {
        
        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/help");
        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->data['view'] = 'admin/help/index'; 
        $this->data['help_data'] = $this->help_model->getAllHelp();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {

        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/help");
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Help & Support';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/help/edit';

        if ($this->input->post()) {
            
            $this->form_validation->set_rules("question", "Question", "required", array('required' => 'Question cannot be empty'));
            $this->form_validation->set_rules("answer", "Answer", "required", array('required' => 'Answer cannot be empty'));
            $this->form_validation->set_rules("display_order", "Display Order", "required", array('required' => 'Display order cannot be empty'));

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('question', 'answer', 'display_order');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/help");
            }

            $help_id = trim($this->input->post('help_id'));
            $question = trim($this->input->post('question'));
            $answer = trim($this->input->post('answer'));
            $display_order = trim($this->input->post('display_order'));
            
            $data = array();
            $data['question'] = $question;
            $data['answer'] = $answer;
            $data['display_order'] = $display_order;

            if ($help_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->help_model->updateHelp($help_id, $data);
                $this->session->set_flashdata('success', "Help and support updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $help_id = $this->help_model->addHelp($data);
                $this->session->set_flashdata('success', "Help and support added successfully!");
            }
            redirect("admin/help");
        }

        $this->data['help_data'] = $this->help_model->getHelpById($id, 1);
        $this->data['last_display_order'] = $this->common_model->getLastDisplayOrder('help_support');
        $this->data['help_id'] = isset($this->data['help_data']) && $this->data['help_data']->id ? $this->data['help_data']->id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }
    
    public function delete($id) {

        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/help");
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->help_model->deleteHelp($id);
            $this->session->set_flashdata('success', 'Help and support deleted successfully!');
        }
        redirect("admin/help");
    }

    public function ticket() {
        
        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/help/ticket");
        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->data['title'] = 'Raised Ticket';
        $this->data['view'] = 'admin/help/ticket'; 
        $this->data['help_data'] = $this->help_model->getAllHelpTicket();
        $this->load->view('admin/admin_master', $this->data);
    }
    
    public function ticket_edit($id) {

        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/help/ticket");
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Raised Ticket';
        $this->data['page'] = "Edit " . $this->data['title'];
        $this->data['view'] = 'admin/help/ticket_edit';

        if ($this->input->post()) {
            
            $help_id = trim($this->input->post('help_id'));
            
            $data = array();
            $data['status'] = trim($this->input->post('status'));

            if ($help_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->help_model->updateHelpTicket($help_id, $data);
                  
                //Help Ticket Notification
                $this->common_model->send_ticket_notification($help_id);
                
                $this->session->set_flashdata('success', "Raised ticket status updated successfully!");
            } else {
                $this->session->set_flashdata('success', "Raised ticket status not updated!");
            }
            redirect("admin/help/ticket");
        }

        $this->data['help_data'] = $this->help_model->getHelpTicketById($id);
        $this->data['help_id'] = isset($this->data['help_data']) && $this->data['help_data']->id ? $this->data['help_data']->id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }
}
