<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transporter extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Transporters';
        $this->load->model('user_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/transporter");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/transporter/index';
        $this->data['user_data'] = $this->user_model->getAllUser('Transporter');
        $this->load->view('admin/admin_master', $this->data);
    }

    function generate_user_id($length) {
        $id = generateRandomString($length);
        if ($this->db->get_where('user', ["login_id" => $id])->num_rows() == 0) {
            return $id;
        } else {
            return $this->generate_user_id($length);
        }
    }

    public function edit($id) {

        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Transporter';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/transporter/edit';

        if ($this->input->post()) {

            $user_id = trim($this->input->post('user_id'));

            $this->form_validation->set_rules("name", "Name", "required", array('required' => 'Name cannot be empty'));
            $this->form_validation->set_rules("email", "Email", "required|valid_email", array('required' => 'Email cannot be empty'));
            $this->form_validation->set_rules("mobile", "Mobile", "required", array('required' => 'Mobile cannot be empty'));
            $this->form_validation->set_rules("login_id", "User Id", "required", array('required' => 'User Id cannot be empty'));

            if ($user_id == 0) {
                $this->form_validation->set_rules("password", "Password", "required", array('required' => 'Password cannot be empty'));
                $this->form_validation->set_rules("cpassword", "Confirm password", "required|matches[password]", array('required' => 'Confirm password cannot be empty'));
            }

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('login_id', 'name', 'email', 'mobile', 'password', 'cpassword');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/transporter");
            }

            $login_id = trim($this->input->post('login_id'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $mobile = trim($this->input->post('mobile'));
            $password = trim($this->input->post('password'));
            $address = trim($this->input->post('address'));
            $status = trim($this->input->post('status'));
            $user_type = trim($this->input->post('user_type'));
            $employment_type = trim($this->input->post('employment_type'));

            $msg = '';
            if ($email && $this->user_model->checkUserExist($email, 'email', $user_id, $user_type)) {
                $msg = 'Email id already exists';
            }
            if ($this->user_model->checkUserExist($mobile, 'mobile', $user_id, $user_type)) {
                $msg = 'Mobile number already exists';
            }

            if ($msg != '') {
                $this->session->set_flashdata('error', $msg);
                redirect("admin/transporter");
            }

            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            $data['mobile'] = $mobile;
            $data['address'] = $address;
            $data['status'] = $status;
            $data['user_type'] = $user_type;
            $data['employment_type'] = $employment_type;
            $data['login_id'] = $login_id; //$this->generate_user_id(8);
            if ($user_id == 0) {
                $data['mobile_verified'] = 1;
                $data['password'] = md5($password);
            }

            if ($user_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->user_model->updateUser($user_id, $data);
                $this->session->set_flashdata('success', "Transporter updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $user_id = $this->user_model->addUser($data);
                $this->session->set_flashdata('success', "Transporter added successfully!");

                $message_data = array();
                $message_data['name'] = $name;
                $message_data['email'] = $email;
                $message_data['mobile'] = $mobile;
                $message_data['username'] = $login_id;
                $message_data['password'] = $password;

                $message = '<table style="width:100%; border : 1px solid #ddd">';
                foreach ($message_data as $key => $value) {
                    $message .= '<tr><td>' . ucfirst($key) . ' </td><td> ' . $value . '</td></tr>';
                }
                $message .= '</table>';

                $subject = "Welcome to " . PROJECT_NAME;
                if ($email != '') {
                    $this->common_model->send_mail($message, $email, $subject);
                }
            }

            //Documents
            $user_document = array();
            $user_document['user_id'] = $user_id;
            $user_document['document_type'] = trim($this->input->post('document_type'));
            $user_document['document_number'] = trim($this->input->post('document_number'));

            //Front Side Photo
            if (isset($_FILES['front_photo']) && $_FILES['front_photo']['name'] && $_FILES['front_photo']['error'] == 0) {

                if (!file_exists(USER_DOCUMENTS))
                    mkdir(USER_DOCUMENTS);

                $ext = pathinfo($_FILES['front_photo']['name'], PATHINFO_EXTENSION);
                $_front_photo = 'front_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['front_photo']['tmp_name'], USER_DOCUMENTS . $_front_photo)) {
                    $user_document['front_photo'] = $_front_photo;
                }
            }
            $this->user_model->updateUserDocumentsByUserId($user_id, $user_document);

            redirect("admin/transporter");
        }

        $this->data['documents'] = $this->user_model->getUserDocuments($id);
        $this->data['user_type'] = 'Transporter';
        $this->data['user_data'] = $this->user_model->getUserById($id, 0);
        $this->data['user_id'] = isset($this->data['user_data']) && $this->data['user_data']->user_id ? $this->data['user_data']->user_id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }

    public function check_user_exists() {

        $user_id = trim($this->input->post('id'));
        $value = trim($this->input->post('val'));
        $type = trim($this->input->post('type'));
        $user_type = trim($this->input->post('user_type'));

        $success = 'true';
        if ($this->user_model->checkUserExist($value, $type, $user_id, $user_type)) {
            $success = 'false';
        }
        echo $success;
    }

    public function export_csv() {
        $filename = 'export_volunteer_' . date('Ymd') . time();
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$filename.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, array('Sr', 'Transporter Name', 'Gender', 'Email', 'Mobile', 'Verified', 'Company', 'Date of Birth', 'Address', 'Created Date', 'Status'));

        $user_data = $this->user_model->getAllUser('Transporter');
        $i = 0;
        foreach ($user_data as $value) {
            $i++;
            $verified = $value->mobile_verified == 1 ? 'Yes' : 'No';
            $user_list = array($i, $value->name, $value->gender, $value->email, $value->mobile, $verified, $value->company, $value->birth_date, $value->address, $value->creation_datetime, ($value->status ? 'Active' : 'Inactive'));
            fputcsv($output, $user_list);
        }
        fclose($output);
    }

    public function delete($id) {

        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {

            $where_related = array(
                'is_order' => 1,
                'transporter_id' => $id,
            );
            $check = $this->common_model->check_delete_data('cart_orders', $where_related);

            if (!$check) {
                $this->user_model->deleteUser($id);
                $this->session->set_flashdata('success', 'Transporter deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Transporter have found in orders, you can not delete this transporter!');
            }
        }
        redirect("admin/transporter");
    }

    public function documents() {
        $id = $this->input->post('user_id');
        $data['documents'] = $this->user_model->getUserDocuments($id);
        $view = $this->load->view('admin/transporter/documents', $data, true);

        echo json_encode(array('view' => $view));
        exit;
    }

    public function delete_document($id) {

        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->user_model->updateUserDocumentsByUserId($id, array('front_photo' => NULL));
            $this->session->set_flashdata('success', 'Document deleted successfully!');
        }
        redirect("admin/transporter/edit/" . $id);
    }

    public function availability() {
        $this->data['title'] = 'Transporters Not Available';
        $this->data['view'] = 'admin/transporter/availability';

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

        $this->data['user_data'] = $this->user_model->getAllUser('Transporter');
        $this->data['not_available_data'] = $this->user_model->getTransporterAvailability($user_id, $from_date, $to_date);
        $this->load->view('admin/admin_master', $this->data);
    }

}
