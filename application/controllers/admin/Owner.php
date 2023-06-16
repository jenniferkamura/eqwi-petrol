<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Owners';
        $this->load->model('user_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/owner");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/owner/index';
        $this->data['user_data'] = $this->user_model->getAllUser('Owner');
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

        $this->data['title'] = 'Owner';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/owner/edit';

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
                redirect("admin/owner");
            }

            $login_id = trim($this->input->post('login_id'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $mobile = trim($this->input->post('mobile'));
            $password = trim($this->input->post('password'));
            $address = trim($this->input->post('address'));
            $status = trim($this->input->post('status'));
            $payment_option = trim($this->input->post('payment_option'));
            $user_type = trim($this->input->post('user_type'));

            $msg = '';
            if ($email && $this->user_model->checkUserExist($email, 'email', $user_id, $user_type)) {
                $msg = 'Email id already exists';
            }
            if ($this->user_model->checkUserExist($mobile, 'mobile', $user_id, $user_type)) {
                $msg = 'Mobile number already exists';
            }

            if ($msg != '') {
                $this->session->set_flashdata('error', $msg);
                redirect("admin/owner");
            }

            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            $data['mobile'] = $mobile;
            $data['address'] = $address;
            $data['status'] = $status;
            $data['payment_option'] = $payment_option;
            $data['user_type'] = $user_type;
            $data['login_id'] = $login_id; //$this->generate_user_id(8);
            $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');

            if ($user_id == 0) {
                $data['mobile_verified'] = 1;
                $data['password'] = md5($password);
            }

            if ($user_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->user_model->updateUser($user_id, $data);
                $this->session->set_flashdata('success', "Owner updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $user_id = $this->user_model->addUser($data);
                $this->session->set_flashdata('success', "Owner added successfully!");

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

            /* if (!empty($_FILES['profile_pic'])) {

              if (!file_exists(PROFILEPIC))
              mkdir(PROFILEPIC);

              $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
              $profile_pic = $user_id . '.' . $ext;

              if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], PROFILEPIC . $profile_pic)) {
              $this->user_model->updateUser($user_id, array('profile_pic' => $profile_pic));
              }
              } */

            redirect("admin/owner");
        }

        $this->data['user_type'] = 'Owner';
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
        fputcsv($output, array('Sr', 'Owner Name', 'Gender', 'Email', 'Mobile', 'Verified', 'Company', 'Date of Birth', 'Address', 'Created Date', 'Status'));

        $user_data = $this->user_model->getAllUser('Owner');
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
                'is_approve' => 1,
                'owner_id' => $id,
            );
            $check = $this->common_model->check_delete_data('cart_orders', $where_related);
            
            if (!$check) {
                $where_related = array(
                    'status' => 1,
                    'user_id' => $id,
                );
                $check = $this->common_model->check_delete_data('transaction', $where_related);
            }
            
            if (!$check) {
                $this->user_model->deleteUser($id);
                $this->session->set_flashdata('success', 'Owner deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Owner have found in orders or transactions, you can not delete this owner!');
            }
        }
        redirect("admin/owner");
    }

    public function sendOrderSMS($name, $order_id, $order_status, $mobile, $device_id) {
        $message = "Dear $name, your order $order_id is $order_status. \n Regards \n " . PROJECT_NAME;
        $template_id = '1407164967500773284';
        //send_message($message, $mobile, $template_id);

        $data = array();
        $data['device_id'] = $device_id;
        $data['title'] = $order_status;
        $data['message'] = $message;
        $data['order_id'] = $order_id;
        $this->send_push_notification($data);
    }

    public function send_push_notification($data) {
        //Send Notification to Customer
        $cdata = array(
            "to" => $data['device_id'],
            "notification" => array(
                "title" => $data['title'],
                "body" => $data['message'],
                'image' => SITE_LOGO,
                'sound' => 'notification_sound',
                'vibrate' => 1
            ),
            "data" => [
                "title" => $data['title'],
                "message" => $data['message'],
                "order_id" => $data['order_id'],
            ]
        );

        $this->common_model->send_push_notification($cdata);
    }

    public function logs() {

        $this->data['page'] = 'Logs';
        $this->data['title'] = 'Logs';
        $this->data['view'] = 'admin/user/logs';
        $this->data['logs_data'] = $this->admin_model->getAllLogs();
        $this->load->view('admin/admin_master', $this->data);
    }

}
