<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Vehicles';
        $this->load->model('vehicle_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/vehicle");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/vehicle/index';
        $this->data['vehicle_data'] = $this->vehicle_model->getAllVehicle();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {

        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Vehicle';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/vehicle/edit';

        if ($this->input->post()) {

            $this->form_validation->set_rules("user_id", "Transporter Name", "required", array('required' => 'Transporter name cannot be empty'));
            $this->form_validation->set_rules("vehicle_number", "Vehicle Number", "required", array('required' => 'Vehicle number cannot be empty'));
            $this->form_validation->set_rules("vehicle_capacity", "Vehicle Capacity", "required", array('required' => 'Vehicle capacity cannot be empty'));
            $this->form_validation->set_rules("measurement", "Measurement", "required", array('required' => 'Measurement cannot be empty'));
            $this->form_validation->set_rules("no_of_compartment", "Number of Compartment", "required", array('required' => 'Number of compartment cannot be empty'));
            $this->form_validation->set_rules("license_number", "License Number", "required", array('required' => 'License number cannot be empty'));

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('user_id', 'vehicle_number', 'vehicle_capacity', 'measurement', 'no_of_compartment', 'license_number');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/vehicle");
            }

            $vehicle_id = trim($this->input->post('vehicle_id'));
            $user_id = trim($this->input->post('user_id'));
            $vehicle_number = trim($this->input->post('vehicle_number'));
            $vehicle_capacity = trim($this->input->post('vehicle_capacity'));
            $measurement = trim($this->input->post('measurement'));
            $no_of_compartment = trim($this->input->post('no_of_compartment'));
            $status = trim($this->input->post('status'));

            $total_compartment_capacity = 0;
            $compartment_capacity = $this->input->post('compartment_capacity');
            if ($compartment_capacity) {

                foreach ($compartment_capacity as $compartment_no => $compartment) {
                    $total_compartment_capacity += $compartment;
                }
            }

            if ($vehicle_capacity != $total_compartment_capacity) {
                $this->session->set_flashdata('error', 'Vehicle capacity and total compartment capacity mismatch, please check it.');
                redirect("admin/vehicle");
            }

            $data = array();
            $data['user_id'] = $user_id;
            $data['vehicle_number'] = $vehicle_number;
            $data['vehicle_capacity'] = $vehicle_capacity;
            $data['measurement'] = $measurement;
            $data['no_of_compartment'] = $no_of_compartment;
            $data['status'] = $status;

            //Front Vehicle Photo
            if (!empty($_FILES['front_vehicle_photo'])) {

                if (!file_exists(VEHICLE_IMG))
                    mkdir(VEHICLE_IMG);

                $ext = pathinfo($_FILES['front_vehicle_photo']['name'], PATHINFO_EXTENSION);
                $vehicle_photo1 = 'front_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['front_vehicle_photo']['tmp_name'], VEHICLE_IMG . $vehicle_photo1)) {
                    $data['front_vehicle_photo'] = $vehicle_photo1;
                }
            }

            //Back Vehicle Photo
            if (!empty($_FILES['back_vehicle_photo'])) {

                if (!file_exists(VEHICLE_IMG))
                    mkdir(VEHICLE_IMG);

                $ext = pathinfo($_FILES['back_vehicle_photo']['name'], PATHINFO_EXTENSION);
                $vehicle_photo2 = 'back_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['back_vehicle_photo']['tmp_name'], VEHICLE_IMG . $vehicle_photo2)) {
                    $data['back_vehicle_photo'] = $vehicle_photo2;
                }
            }

            //Left Vehicle Photo
            if (!empty($_FILES['left_vehicle_photo'])) {

                if (!file_exists(VEHICLE_IMG))
                    mkdir(VEHICLE_IMG);

                $ext = pathinfo($_FILES['left_vehicle_photo']['name'], PATHINFO_EXTENSION);
                $vehicle_photo3 = 'left_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['left_vehicle_photo']['tmp_name'], VEHICLE_IMG . $vehicle_photo3)) {
                    $data['left_vehicle_photo'] = $vehicle_photo3;
                }
            }

            //Right Vehicle Photo
            if (!empty($_FILES['right_vehicle_photo'])) {

                if (!file_exists(VEHICLE_IMG))
                    mkdir(VEHICLE_IMG);

                $ext = pathinfo($_FILES['right_vehicle_photo']['name'], PATHINFO_EXTENSION);
                $vehicle_photo4 = 'right_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['right_vehicle_photo']['tmp_name'], VEHICLE_IMG . $vehicle_photo4)) {
                    $data['right_vehicle_photo'] = $vehicle_photo4;
                }
            }

            if (!empty($_FILES['vehicle_document'])) {

                if (!file_exists(VEHICLE_IMG))
                    mkdir(VEHICLE_IMG);

                $ext = pathinfo($_FILES['vehicle_document']['name'], PATHINFO_EXTENSION);
                $vehicle_document = 'document_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['vehicle_document']['tmp_name'], VEHICLE_IMG . $vehicle_document)) {
                    $data['vehicle_document'] = $vehicle_document;
                }
            }

            $license_img = '';
            if (!empty($_FILES['driving_license'])) {

                if (!file_exists(USER_DOCUMENTS))
                    mkdir(USER_DOCUMENTS);

                $ext = pathinfo($_FILES['driving_license']['name'], PATHINFO_EXTENSION);
                $driving_license = 'front_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['driving_license']['tmp_name'], USER_DOCUMENTS . $driving_license)) {
                    $license_img = $driving_license;
                }
            }

            if ($vehicle_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->vehicle_model->updateVehicle($vehicle_id, $data);
                $this->session->set_flashdata('success', "Vehicle updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $vehicle_id = $this->vehicle_model->addVehicle($data);
                $this->session->set_flashdata('success', "Vehicle added successfully!");
            }

            if ($vehicle_id) {

                $this->db->where('user_id', $user_id);
                $this->db->update('user', array('vehicle_id' => $vehicle_id));

                $compartment_capacity = $this->input->post('compartment_capacity');
                if ($compartment_capacity) {

                    $this->vehicle_model->deleteVehicleDetail($vehicle_id);
                    foreach ($compartment_capacity as $compartment_no => $compartment) {

                        $vehicle_detail = array(
                            'vehicle_id' => $vehicle_id,
                            'compartment_no' => $compartment_no,
                            'compartment_capacity' => $compartment
                        );
                        $this->vehicle_model->addVehicleDetail($vehicle_detail);
                    }
                }

                $user_document = array(
                    'user_id' => $user_id,
                    'document_type' => 'Driving License',
                    'document_number' => trim($this->input->post('license_number'))
                );

                if ($license_img != '') {
                    $user_document['front_photo'] = $license_img;
                }

                if ($document = $this->db->get_where('user_documents', ['user_id' => $user_id])->row()) {
                    $user_document['updated_date'] = DATETIME;

                    $this->db->where('id', $document->id);
                    $this->db->update('user_documents', $user_document);
                } else {
                    $user_document['created_date'] = DATETIME;
                    $this->db->insert('user_documents', $user_document);
                }
            }

            redirect("admin/vehicle");
        }

        $this->data['vehicle_data'] = $vehicle_data = $this->vehicle_model->getVehicleById($id, 0);
        $this->data['vehicle_id'] = $vehicle_data && $vehicle_data->vehicle_id ? $vehicle_data->vehicle_id : 0;

        $user_id = $vehicle_data && $vehicle_data->user_id ? $vehicle_data->user_id : 0;
        $this->data['user_data'] = $this->vehicle_model->getAllTransporters($user_id);
        $this->data['vehicle_detail'] = $this->vehicle_model->getVehicleDetailById($id);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function view($id) {

        if ($id == 0 && $this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Vehicle';
        $this->data['page'] = "View " . $this->data['title'];
        $this->data['view'] = 'admin/vehicle/view';

        $this->data['vehicle_data'] = $vehicle_data = $this->vehicle_model->getVehicleById($id, 0);
        $this->data['vehicle_detail'] = $this->vehicle_model->getVehicleDetailById($id);

        $user_id = $vehicle_data && $vehicle_data->user_id ? $vehicle_data->user_id : 0;
        $this->data['user_data'] = $this->vehicle_model->getAllTransporters($user_id);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function check_vehicle_exists() {

        $vehicle_id = trim($this->input->post('id'));
        $value = trim($this->input->post('val'));
        $type = trim($this->input->post('type'));
        $vehicle_type = trim($this->input->post('vehicle_type'));

        $success = 'true';
        if ($this->vehicle_model->checkVehicleExist($value, $type, $vehicle_id)) {
            $success = 'false';
        }
        echo $success;
    }

    public function export_csv() {
        $filename = 'export_volunteer_' . date('Ymd') . time();
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$filename.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, array('Sr', 'Vehicle Name', 'Gender', 'Email', 'Mobile', 'Verified', 'Company', 'Date of Birth', 'Address', 'Created Date', 'Status'));

        $vehicle_data = $this->vehicle_model->getAllVehicle();
        $i = 0;
        foreach ($vehicle_data as $value) {
            $i++;
            $verified = $value->mobile_verified == 1 ? 'Yes' : 'No';
            $vehicle_list = array($i, $value->name, $value->gender, $value->email, $value->mobile, $verified, $value->company, $value->birth_date, $value->address, $value->creation_datetime, ($value->status ? 'Active' : 'Inactive'));
            fputcsv($output, $vehicle_list);
        }
        fclose($output);
    }

    public function delete($id) {

        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->vehicle_model->deleteVehicle($id);
            $this->session->set_flashdata('success', 'Vehicle deleted successfully!');
        }
        redirect("admin/vehicle");
    }

    public function availability() {
        $this->data['title'] = 'New Orders Availability';
        $this->data['view'] = 'admin/vehicle/availability';

        $user_id = $from_date = $to_date = $status = '';
        if ($this->input->post()) {

            $this->data['user_id'] = $user_id = $this->input->post('user_id');
            $this->data['from_date'] = $_from_date = $this->input->post('from_date');
            $this->data['to_date'] = $_to_date = $this->input->post('to_date');
            $this->data['status'] = $status = $this->input->post('status');

            if ($_from_date) {
                $old_from_date = explode('/', $_from_date);
                $from_date = (isset($old_from_date[2]) ? $old_from_date[2] : date('Y')) . '-' . $old_from_date[1] . '-' . $old_from_date[0];
            }
            if ($_to_date) {
                $old_to_date = explode('/', $_to_date);
                $to_date = (isset($old_to_date[2]) ? $old_to_date[2] : date('Y')) . '-' . $old_to_date[1] . '-' . $old_to_date[0];
            }
        }

        $this->data['user_data'] = $this->vehicle_model->getAllUser('Transporter');
        $this->data['order_data'] = $this->vehicle_model->getOrderDetail($user_id, $from_date, $to_date, $status);
        $this->load->view('admin/admin_master', $this->data);
    }

}
