<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement extends CI_Controller {

    private $privilege_error;
    private $admin_id;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Advertisements';
        $this->load->model('advertisement_model');

        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';
        $this->admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/advertisement");
        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/advertisement/index';
        $this->data['ads_data'] = $this->advertisement_model->getAllAdvertisement();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->data['title'] = 'Advertisement';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/advertisement/edit';

        if ($this->input->post()) {

            $this->form_validation->set_rules("title", "Title", "required", array('required' => 'Title cannot be empty'));
            $this->form_validation->set_rules("display_order", "Display Order", "required", array('required' => 'Display order cannot be empty'));

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('title', 'display_order');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/advertisement");
            }

            $ads_id = trim($this->input->post('ads_id'));
            $title = trim($this->input->post('title'));
            $description = trim($this->input->post('description'));
            $display_order = trim($this->input->post('display_order'));
            $advertisement_type = trim($this->input->post('advertisement_type'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['title'] = $title;
            $data['description'] = $description;
            $data['display_order'] = $display_order;
            $data['advertisement_type'] = $advertisement_type;
            $data['status'] = $status;

            if (!empty($_FILES['ads_image'])) {

                if (!file_exists(ADVERTISEMENT))
                    mkdir(ADVERTISEMENT);

                $ext = pathinfo($_FILES['ads_image']['name'], PATHINFO_EXTENSION);
                $ads_image = 'ads_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['ads_image']['tmp_name'], ADVERTISEMENT . $ads_image)) {
                    $data['image'] = $ads_image;
                }
            }

            if ($ads_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->advertisement_model->updateAdvertisement($ads_id, $data);
                $this->session->set_flashdata('success', "Advertisement updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $ads_id = $this->advertisement_model->addAdvertisement($data);
                $this->session->set_flashdata('success', "Advertisement added successfully!");
            }
            redirect("admin/advertisement");
        }

        $this->data['ads_data'] = $this->advertisement_model->getAdvertisementById($id);
        $this->data['last_display_order'] = $this->common_model->getLastDisplayOrder('advertisement');
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        if ($id > 0) {
            $this->advertisement_model->deleteAdvertisement($id);
            $this->session->set_flashdata('success', 'Advertisement deleted successfully!');
        }
        redirect("admin/advertisement");
    }

}
