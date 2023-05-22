<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Station extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct(); 
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Stations';
        $this->load->model('station_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/station");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/station/index';
        $this->data['station_data'] = $this->station_model->getAllStation();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        
        $this->data['title'] = 'Station';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/station/edit';

        if ($this->input->post()) {
            
            $this->form_validation->set_rules("owner_id", "Owner Name", "required", array('required' => 'Owner name cannot be empty'));
            $this->form_validation->set_rules("station_name", "Station Name", "required", array('required' => 'Station name cannot be empty'));
            $this->form_validation->set_rules("contact_person", "Contact Person", "required", array('required' => 'Contact Person cannot be empty'));
            $this->form_validation->set_rules("contact_number", "Phone Number", "required", array('required' => 'Phone Number cannot be empty'));
            $this->form_validation->set_rules("country", "Country", "required", array('required' => 'Country cannot be empty'));
            $this->form_validation->set_rules("state", "State", "required", array('required' => 'State cannot be empty'));
            $this->form_validation->set_rules("city", "City", "required", array('required' => 'City cannot be empty'));
            //$this->form_validation->set_rules("pincode", "Pincode", "required", array('required' => 'Pincode cannot be empty'));
            $this->form_validation->set_rules("address", "Address", "required", array('required' => 'Address cannot be empty'));
            
            if ($this->form_validation->run() == FALSE) {
                $form_data = array('owner_id', 'station_name', 'contact_person', 'contact_number',
                    'country', 'state', 'city', 'address');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/station");
            }
            
            $station_id = trim($this->input->post('station_id'));
            $owner_id = trim($this->input->post('owner_id'));
            $station_name = trim($this->input->post('station_name'));
            $contact_person = trim($this->input->post('contact_person'));
            $contact_number = trim($this->input->post('contact_number'));
            $alternate_number = trim($this->input->post('alternate_number'));
            $country = trim($this->input->post('country'));
            $state = trim($this->input->post('state'));
            $city = trim($this->input->post('city'));
            $pincode = trim($this->input->post('pincode'));
            $landmark = trim($this->input->post('landmark'));
            $address = trim($this->input->post('address'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['owner_id'] = $owner_id;
            $data['station_name'] = $station_name;
            $data['contact_person'] = $contact_person;
            $data['contact_number'] = $contact_number;
            $data['alternate_number'] = $alternate_number;
            $data['country'] = $country;
            $data['state'] = $state;
            $data['city'] = $city;
            $data['pincode'] = $pincode;
            $data['landmark'] = $landmark;
            $data['address'] = $address;
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;
            $data['status'] = $status;
            
            if ($station_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->station_model->updateStation($station_id, $data);
                $this->session->set_flashdata('success', "Station updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $station_id = $this->station_model->addStation($data);
                $this->session->set_flashdata('success', "Station added successfully!");
            }
            redirect("admin/station");
        }
        
        $this->data['owners'] = $this->station_model->getAllOwners();
        $this->data['station_data'] = $this->station_model->getStationById($id);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->station_model->deleteStation($id);
            $this->session->set_flashdata('success', 'Station deleted successfully!');
        }
        redirect("admin/station");
    }

}
