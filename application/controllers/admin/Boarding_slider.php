<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Boarding_slider extends CI_Controller {

    private $privilege_error;
    private $admin_id;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Boarding Sliders';
        $this->load->model('slider_model');

        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';
        $this->admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/boarding_slider");
        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/slider/boarding/index';
        $this->data['slider_data'] = $this->slider_model->getAllBoardingSlider();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->data['title'] = 'Boarding Slider';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/slider/boarding/edit';

        if ($this->input->post()) {

            $this->form_validation->set_rules("title", "Title", "required", array('required' => 'Title cannot be empty'));
            $this->form_validation->set_rules("display_order", "Display Order", "required", array('required' => 'Display order cannot be empty'));

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('title', 'display_order');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/boarding_slider");
            }

            $slider_id = trim($this->input->post('slider_id'));
            $title = trim($this->input->post('title'));
            $description = trim($this->input->post('description'));
            $display_order = trim($this->input->post('display_order'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['title'] = $title;
            $data['description'] = $description;
            $data['display_order'] = $display_order;
            $data['status'] = $status;

            if (!empty($_FILES['slider_image'])) {

                if (!file_exists(BOARDING_SLIDER_IMG))
                    mkdir(BOARDING_SLIDER_IMG);

                $ext = pathinfo($_FILES['slider_image']['name'], PATHINFO_EXTENSION);
                $slider_image = 'slider_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['slider_image']['tmp_name'], BOARDING_SLIDER_IMG . $slider_image)) {
                    $data['image'] = $slider_image;
                }
            }

            if ($slider_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->slider_model->updateBoardingSlider($slider_id, $data);
                $this->session->set_flashdata('success', "Boarding slider updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $slider_id = $this->slider_model->addBoardingSlider($data);
                $this->session->set_flashdata('success', "Boarding slider added successfully!");
            }
            redirect("admin/boarding_slider");
        }

        $this->data['slider_data'] = $this->slider_model->getBoardingSliderById($id);
        $this->data['last_display_order'] = $this->common_model->getLastDisplayOrder('boarding_sliders');
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        if ($id > 0) {
            $this->slider_model->deleteBoardingSlider($id);
            $this->session->set_flashdata('success', 'Boarding slider deleted successfully!');
        }
        redirect("admin/boarding_slider");
    }

}
