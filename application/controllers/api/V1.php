<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require(APPPATH . '/libraries/RestController.php');

use chriskacerguis\RestServer\RestController;

class V1 extends RestController {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('api_model');
        $this->data['status'] = 'error';
        $this->data['message'] = 'Something went wrong!';
        //$this->data['data'] = array();

        $new_orders = $this->common_model->getNewOrders();
        if ($new_orders) {
            foreach ($new_orders as $order) {
                $no_invoice = $this->api_model->getTableById('transaction', 'order_id', $order->id, ['is_invoice' => 0]);
                if ($no_invoice) {
                    $this->api_model->updateTable('cart_orders', 'id', $order->id, ['order_status' => 'Pending']);

                    if ($assign = $this->api_model->getAssignOrder($order->id)) {
                        $this->api_model->updateTable('assign_orders', 'id', $assign->id, ['assign_status' => 'Pending']);
                    }
                }
            }
        }
        
        //Send new order notifications
        $this->common_model->sendNewOrderNotifications();
    }

    // index function
    public function index() {
        echo "Method is not defined.";
    }

    public function checkUserStatus($mobile) {
        if ($user = $this->api_model->checkUserStatus($mobile)) {
            if ($user->status == 0) {
                $this->data['message'] = 'Your account is inactive';
                $this->response($this->data, 200);
            } else {
                return $user->user_id;
            }
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'Mobile number is not registered';
            $this->response($this->data, 200);
        }
    }

    public function check_user_token($user_token, $user_id = 0) {
        if ($user = $this->api_model->checkUserToken($user_id, $user_token)) {
            $this->checkUserStatus($user->mobile);
            return $user->user_id;
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'User token expired!';
            $this->response($this->data, 200);
        }
    }

    public function get_code($mobile = '') {
        $code = rand(1111, 9999);
        //$code = 1234;
        if ($mobile != '') {
            $this->api_model->sendOTPSMS($code, $mobile);
        }
        return $code;
    }

    // login function
    public function login_post() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $form_data = array('email', 'password');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $data = array();
            $data['email'] = trim($this->input->post('email'));
            $data['password'] = trim($this->input->post('password'));
            $device_id = trim($this->input->post('device_id'));
            $platform_type = trim($this->input->post('platform_type'));
            $check_login = $this->api_model->checkVerifyLogin($data);
            if ($check_login) {

                if ($this->api_model->checkVerifyMobile($check_login->user_id)) {

                    if ($check_login->status) {

                        $user_token = generateRandomString();
                        $update_data = array();
                        $update_data['device_id'] = $device_id;
                        $update_data['platform_type'] = $platform_type;
                        $update_data['user_token'] = $user_token;
                        $this->user_model->updateUser($check_login->user_id, $update_data);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Login successfully';
                        $this->data['data'] = $this->api_model->getUserById($check_login->user_id, 1);
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'You are inactive . Please contact admin';
                    }
                } else {

                    $user = $this->api_model->getUserById($check_login->user_id);

                    $user_token = generateRandomString();
                    $data = array();
                    $data['otp_code'] = $this->get_code($user->mobile);
                    $data['user_token'] = $user_token;
                    $this->user_model->updateUser($check_login->user_id, $data);

                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Mobile number is not verified';
                    $this->data['data'] = array('mobile_verified' => 0, 'mobile' => $user->mobile, 'token' => $user_token, 'otp_code' => $data['otp_code']);
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Id and password does not match';
            }
        }
        $this->response($this->data, 200);
    }

    public function verify_mobile_post() {
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $form_data = array('mobile');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $mobile = trim($this->input->post('mobile'));

            // This is for only social login
            $token = trim($this->input->post('token'));
            if ($token) {

                $this->db->where('status', 1);
                $this->db->where('mobile_verified', 0);
                $this->db->where('forgot_token', $token);
                $user = $this->db->get('user')->row();

                if ($user) {

                    $signup_mobile = $this->user_model->check_user_data('mobile', $mobile, $user->user_id);
                    if (!$signup_mobile) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Mobile number already exist.';
                        $this->response($this->data, 200);
                    }

                    $this->db->where('user_id', $user->user_id);
                    $this->db->update('user', array('mobile' => $mobile, 'forgot_token' => ''));
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Token expired!';
                    $this->response($this->data, 200);
                }
            }

            $user_id = $this->checkUserStatus($mobile);
            if ($user_id) {

                $user_token = generateRandomString();
                $otp_code = $this->get_code($mobile);
                $data = array();
                $data['otp_code'] = $otp_code;
                $data['user_token'] = $user_token;
                $this->user_model->updateUser($user_id, $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'OTP sent successfully';
                $this->data['data'] = array('token' => $user_token, 'otp_code' => $otp_code);
            }
        }
        $this->response($this->data, 200);
    }

    public function boarding_slider_get() {
        $sliders = $this->api_model->getAllBoardingSlider();
        if ($sliders) {
            $this->data['status'] = 'success';
            $this->data['message'] = 'Slider found';
            $this->data['data'] = $sliders;
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'Slider not found';
        }
        $this->response($this->data, 200);
    }

    // signup function
    public function signup_post() {

        $this->form_validation->set_rules('login_id', 'Login Id', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[5]|max_length[15]');
        //$this->form_validation->set_rules('address', 'Address', 'trim|required');
        //echo '<pre>';print_r($_POST);die;
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('login_id', 'name', 'email', 'password', 'confirm_password', 'mobile');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_id = trim($this->input->post('user_id')) + 0;
            $login_id = trim($this->input->post('login_id'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $password = trim($this->input->post('password'));
            $mobile = trim($this->input->post('mobile'));
            $address = trim($this->input->post('address'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $signup_login = $signup_email = $signup_mobile = 0;
                if ($user_id > 0) {
                    if ($user = $this->api_model->getUserById($user_id)) {
                        if ($user->mobile_verified == '0') {

                            $signup_login = $this->user_model->check_user_data('login_id', $login_id, $user->user_id);
                            $signup_email = $this->user_model->check_user_data('email', $email, $user->user_id);
                            $signup_mobile = $this->user_model->check_user_data('mobile', $mobile, $user->user_id);
                        } else {
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'You cannot change details, something went wrong.';
                            $this->response($this->data, 200);
                        }
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'User not found.';
                        $this->response($this->data, 200);
                    }
                } else {
                    $signup_login = $this->user_model->check_user_data('login_id', $login_id);
                    $signup_email = $this->user_model->check_user_data('email', $email);
                    $signup_mobile = $this->user_model->check_user_data('mobile', $mobile);
                }

                if ($signup_login && $signup_email && $signup_mobile) {

                    $user_token = generateRandomString();
                    $otp_code = $this->get_code($mobile);
                    $data = array();
                    $data['login_id'] = $login_id;
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['mobile'] = $mobile;
                    $data['password'] = md5($password);
                    $data['user_type'] = 'Owner';
                    $data['address'] = $address;
                    $data['latitude'] = $latitude;
                    $data['longitude'] = $longitude;
                    $data['payment_option'] = 1;
                    $data['otp_code'] = $otp_code;
                    $data['user_token'] = $user_token;
                    $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');

                    if ($user_id > 0) {
                        $data['updated_date'] = DATETIME;
                        $this->user_model->updateUser($user_id, $data);
                    } else {
                        $data['created_date'] = DATETIME;
                        $user_id = $this->user_model->addUser($data);
                    }

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Owner successfully registered.';
                    $this->data['data'] = $this->api_model->getUserById($user_id, 0);

                    $message_data = array();
                    //$message_data['name'] = $name;
                    $message_data['email'] = $email;
                    //$message_data['mobile'] = $mobile;
                    $message_data['username'] = $login_id;
                    //$message_data['password'] = $password; 

                    $message = '<table style="width:100%; border : 1px solid #ddd">';
                    foreach ($message_data as $key => $value) {
                        $message .= '<tr><td>' . ucfirst($key) . ' </td><td> ' . $value . '</td></tr>';
                    }
                    $message .= '</table>';

                    $subject = "Welcome to " . PROJECT_NAME;
                    if ($email != '') {
                        $this->common_model->send_mail($message, $email, $subject);
                    }
                } else {
                    if (!$signup_email) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Email already exist.';
                    }
                    if (!$signup_mobile) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Mobile number already exist.';
                    }
                    if (!$signup_login) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Username already exist.';
                    }
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Please enter valid email';
            }
        }
        $this->response($this->data, 200);
    }

    public function verify_code_post() {

        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('token', 'otp');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $token = trim($this->input->post('token'));
            $otp = trim($this->input->post('otp')) + 0;

            $device_id = trim($this->input->post('device_id'));
            $platform_type = trim($this->input->post('platform_type'));

            if ($otp) {
                $user = $this->api_model->check_token($token, 'register');

                if (!$user) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'User token expired!';
                    $this->response($this->data, 200);
                }

                if ($user) {

                    if ($user->status == 0) {
                        $this->data['message'] = 'Your account is inactive';
                        $this->response($this->data, 200);
                    }
                    if ($user->otp_code == $otp) {

                        $data = array(
                            'user_token' => generateRandomString(),
                            'device_id' => $device_id,
                            'platform_type' => $platform_type,
                            'mobile_verified' => '1',
                            'otp_code' => ''
                        );
                        $this->user_model->updateUser($user->user_id, $data);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'OTP Verified Successfully';
                        $this->data['data'] = $this->api_model->getUserById($user->user_id, 1);
                    } else {

                        $this->data['message'] = 'Invalid OTP';
                        $this->data['data'] = false;
                        $this->response($this->data, 200);
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'User not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Please enter valid otp';
            }
        }
        $this->response($this->data, 200);
    }

    public function resend_code_post() {
        $this->form_validation->set_rules('token', 'Token', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $form_data = array('token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $token = trim($this->input->post('token'));
            $user = $this->api_model->check_token($token, 'register');

            if (!$user) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User token expired!';
                $this->response($this->data, 200);
            }
            if ($user && $user->status == 0) {
                $this->data['message'] = 'Your account is inactive';
                $this->response($this->data, 200);
            }

            if ($user) {
                $otp_code = $this->get_code($user->mobile);
                $data = array();
                $data['otp_code'] = $otp_code;
                $this->user_model->updateUser($user->user_id, $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'OTP resend successfully';
                $this->data['data'] = $data;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function category_prices_get() {
        $data = $this->api_model->getCategoryPrices();
        if ($data) {
            $this->data['status'] = 'success';
            $this->data['message'] = 'Category Prices';
            $this->data['data'] = $data;
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'No data found';
        }
        $this->response($this->data, 200);
    }

    // profile update function
    public function profile_update_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[5]|max_length[15]');
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
        //$this->form_validation->set_rules('address', 'Address', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'name', 'email', 'mobile', "latitude", "longitude");
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $mobile = trim($this->input->post('mobile'));
            $address = trim($this->input->post('address'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));

            $user_id = $this->check_user_token($user_token);

            $check_email = $this->user_model->check_user_data('email', $email, $user_id);
            if (!$check_email) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Email already exist.';
                $this->response($this->data, 200);
            }
            $check_mobile = $this->user_model->check_user_data('mobile', $mobile, $user_id);
            if (!$check_mobile) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Mobile number already exist.';
                $this->response($this->data, 200);
            }

            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            $data['mobile'] = $mobile;
            $data['address'] = $address;
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;

            if ($user_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->user_model->updateUser($user_id, $data);
                $this->data['status'] = 'success';
                $this->data['message'] = 'Profile successfully updated.';
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Invalid User id';
            }
        }

        $this->response($this->data, 200);
    }

    function profile_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {
                $data = $this->api_model->getUserById($user_id, 1);
                $this->data['status'] = 'success';
                $this->data['message'] = 'Profile Info';
                $this->data['data'] = $data;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function stations_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);

            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));
            if ($user_id > 0) {

                $station_id = 0;
                $user_data = $this->user_model->getUserById($user_id);
                if ($user_data && $user_data->owner_id) {
                    $station_id = $user_data->station_id;
                }
                $owner_id = $user_data && $user_data->owner_id ? $user_data->owner_id : $user_data->user_id;

                //$page = trim($this->input->post('page'));
                $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';

                //$limit = 10;
                $table = 'station';
                $select = 'station_id, station_name, contact_person, contact_number, alternate_number, country, state, city, pincode, landmark, address, latitude, longitude';
                $order_key = '';
                $order_by = '';
                $search_key = array('station_name');
                if ($station_id) {
                    $where = array('station_id' => $station_id);
                } else {
                    $where = array('owner_id' => $owner_id);
                }
                if ($stations = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search)) {

                    /* $total_records_count = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search, $limit, $page, 1);
                      $pages_count = (int) ceil(($total_records_count / $limit));

                      $data['pages_count'] = $pages_count;
                      $data['total_records_count'] = $total_records_count;
                      $data['result'] = $users; */

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Stations list found';
                    $this->data['data'] = $stations;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Stations list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function forgot_password_post() {
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[5]|max_length[15]');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('mobile');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $mobile = trim($this->input->post('mobile'));

            if ($user_id = $this->checkUserStatus($mobile)) {

                $otp_code = $this->get_code($mobile);
                $forgot_token = generateRandomString();
                $data = array();
                $data['otp_code'] = $otp_code;
                $data['forgot_token'] = $forgot_token;

                $this->user_model->updateUser($user_id, $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'OTP sent successfully';
                $this->data['data'] = array('token' => $forgot_token, 'otp_code' => $otp_code);
            }
        }
        $this->response($this->data, 200);
    }

    public function verify_otp_post() {

        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('token', 'otp');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $token = trim($this->input->post('token'));
            $otp = trim($this->input->post('otp')) + 0;

            $device_id = trim($this->input->post('device_id'));
            $platform_type = trim($this->input->post('platform_type'));

            if ($otp) {
                $user = $this->api_model->check_token($token, 'forgot');

                if (!$user) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'User token expired!';
                    $this->response($this->data, 200);
                }

                if ($user) {

                    if ($user->status == 0) {
                        $this->data['message'] = 'Your account is inactive';
                        $this->response($this->data, 200);
                    }
                    if ($user->otp_code == $otp) {
                        $data = array(
                            'device_id' => $device_id,
                            'platform_type' => $platform_type,
                            'mobile_verified' => '1',
                            'otp_code' => ''
                        );
                        $this->user_model->updateUser($user->user_id, $data);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'OTP Verified Successfully';
                        $this->data['data'] = true;
                    } else {

                        $this->data['message'] = 'Invalid OTP';
                        $this->data['data'] = false;
                        $this->response($this->data, 200);
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'User not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Please enter valid otp';
            }
        }
        $this->response($this->data, 200);
    }

    public function resend_otp_post() {
        $this->form_validation->set_rules('token', 'Token', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $form_data = array('token', 'otp');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $token = trim($this->input->post('token'));
            $user = $this->api_model->check_token($token, 'forgot');

            if (!$user) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User token expired!';
                $this->response($this->data, 200);
            }
            if ($user && $user->status == 0) {
                $this->data['message'] = 'Your account is inactive';
                $this->response($this->data, 200);
            }

            if ($user) {
                $otp_code = $this->get_code($user->mobile);
                $data = array();
                $data['otp_code'] = $otp_code;
                $this->user_model->updateUser($user->user_id, $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'OTP resend successfully';
                $this->data['data'] = $data;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function update_password_post() {
        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $form_data = array('token', 'password', 'confirm_password');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $token = trim($this->input->post('token'));
            $password = trim($this->input->post('password'));
            $user = $this->api_model->check_token($token, 'forgot');

            if (!$user) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User token expired!';
                $this->response($this->data, 200);
            }
            if ($user && $user->status == 0) {
                $this->data['message'] = 'Your account is inactive';
                $this->response($this->data, 200);
            }

            if ($user) {
                $data = array();
                $data['password'] = md5($password);
                $data['forgot_token'] = '';
                $this->user_model->updateUser($user->user_id, $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'Password updated successfully';
                $this->data['data'] = true;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // add manager function
    public function add_manager_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('station_id', 'Station Id', 'trim|required');
        $this->form_validation->set_rules('login_id', 'Login Id', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[5]|max_length[15]');
        //$this->form_validation->set_rules('address', 'Address', 'trim|required');
        //echo '<pre>';print_r($_POST);die;
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'station_id', 'login_id', 'name', 'email', 'password', 'confirm_password', 'mobile');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $station_id = trim($this->input->post('station_id'));
            $login_id = trim($this->input->post('login_id'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $password = trim($this->input->post('password'));
            $mobile = trim($this->input->post('mobile'));
            $address = trim($this->input->post('address'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));
            $user_type = trim($this->input->post('user_type'));

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $user = $this->api_model->getUserById($user_id);

                $signup_login = $signup_email = $signup_mobile = 0;
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You have no rights to add manager.';
                    $this->response($this->data, 200);
                } else {

                    $signup_login = $this->user_model->check_user_data('login_id', $login_id);
                    $signup_email = $this->user_model->check_user_data('email', $email);
                    $signup_mobile = $this->user_model->check_user_data('mobile', $mobile);
                }

                if ($signup_login && $signup_email && $signup_mobile) {

                    $owners = $this->user_model->getStationOwnerId($station_id);

                    $data = array();
                    $data['login_id'] = $login_id;
                    $data['owner_id'] = $owners ? $owners->owner_id : 0;
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['mobile'] = $mobile;
                    $data['station_id'] = $station_id;
                    $data['password'] = md5($password);
                    $data['user_type'] = $user_type == 'Attendant' ? 'Attendant' : 'Manager';
                    $data['address'] = $address;
                    $data['latitude'] = $latitude;
                    $data['longitude'] = $longitude;
                    $data['created_date'] = DATETIME;
                    $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');

                    $new_user_id = $this->user_model->addUser($data);

                    $this->data['status'] = 'success';
                    $this->data['message'] = "$user_type added successfully.";
                    $this->data['data'] = $this->api_model->getUserById($new_user_id);

                    $message_data = array();
                    //$message_data['name'] = $name;
                    $message_data['email'] = $email;
                    //$message_data['mobile'] = $mobile;
                    $message_data['username'] = $login_id;
                    //$message_data['password'] = $password; 

                    $message = '<table style="width:100%; border : 1px solid #ddd">';
                    foreach ($message_data as $key => $value) {
                        $message .= '<tr><td>' . ucfirst($key) . ' </td><td> ' . $value . '</td></tr>';
                    }
                    $message .= '</table>';

                    $subject = "Welcome to " . PROJECT_NAME;
                    if ($email != '') {
                        $this->common_model->send_mail($message, $email, $subject);
                    }
                } else {
                    if (!$signup_login) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Username already exist.';
                    }
                    if (!$signup_email) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Email already exist.';
                    }
                    if (!$signup_mobile) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Mobile number already exist.';
                    }
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // update manager function
    public function update_manager_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('manager_id', 'Manager/Attendant Id', 'trim|required');
        $this->form_validation->set_rules('station_id', 'Station Id', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        //$this->form_validation->set_rules('password', 'Password', 'trim|required');
        //$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[5]|max_length[15]');
        //$this->form_validation->set_rules('address', 'Address', 'trim|required');
        //echo '<pre>';print_r($_POST);die;
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'manager_id', 'station_id', 'name', 'email', 'password', 'confirm_password', 'mobile');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $manager_id = trim($this->input->post('manager_id'));
            $station_id = trim($this->input->post('station_id'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            //$password = trim($this->input->post('password'));
            $mobile = trim($this->input->post('mobile'));
            $address = trim($this->input->post('address'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));
            $user_type = trim($this->input->post('user_type'));

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $user = $this->api_model->getUserById($user_id);

                $signup_email = $signup_mobile = 0;
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You have no rights to update manager.';
                    $this->response($this->data, 200);
                } else {

                    $signup_email = $this->user_model->check_user_data('email', $email, $manager_id);
                    $signup_mobile = $this->user_model->check_user_data('mobile', $mobile, $manager_id);
                }

                if ($signup_email && $signup_mobile) {

                    $owners = $this->user_model->getStationOwnerId($station_id);

                    $data = array();
                    $data['owner_id'] = $owners ? $owners->owner_id : 0;
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['mobile'] = $mobile;
                    $data['station_id'] = $station_id;
                    //$data['password'] = md5($password);
                    $data['user_type'] = $user_type == 'Attendant' ? 'Attendant' : 'Manager';
                    $data['address'] = $address;
                    $data['latitude'] = $latitude;
                    $data['longitude'] = $longitude;
                    $data['updated_date'] = DATETIME;
                    $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');

                    $this->user_model->updateUser($manager_id, $data);

                    $this->data['status'] = 'success';
                    $this->data['message'] = "$user_type updated successfully.";
                } else {
                    if (!$signup_email) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Email already exist.';
                    }
                    if (!$signup_mobile) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Mobile number already exist.';
                    }
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // delete manager function
    public function delete_manager_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('manager_id', 'Manager/Attendant Id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'manager_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $manager_id = trim($this->input->post('manager_id'));

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $user = $this->api_model->getUserById($user_id);
                if ($user && $user->user_type == 'Owner') {

                    $check_manager = $this->api_model->getUserById($manager_id);
                    if ($check_manager && ($check_manager->user_type == 'Manager' || $check_manager->user_type == 'Attendant')) {
                        $this->user_model->deleteUser($manager_id);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Manager or Attendant deleted successfully.';
                        $this->data['data'] = true;
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Manager or Attendant not found.';
                        $this->response($this->data, 200);
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You have no rights to delete manager.';
                    $this->response($this->data, 200);
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // add station function
    public function add_station_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('station_name', 'Station Name', 'trim|required');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Phone Number', 'trim|required|min_length[5]|max_length[15]');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        //$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        //echo '<pre>';print_r($_POST);die;
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'station_name', 'contact_person', 'contact_number',
                'country', 'state', 'city', 'address');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
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

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $user = $this->api_model->getUserById($user_id);

                //if ($user && $user->user_type == 'Transporter') {
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You have no rights to add stations.';
                    $this->response($this->data, 200);
                }

                $data = array();
                $data['owner_id'] = $user_id;
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
                $data['created_date'] = DATETIME;

                $station_id = $this->api_model->addTable('station', $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'Station added successfully.';
                $this->data['data'] = $this->api_model->getTableById('station', 'station_id', $station_id);
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // update station function
    public function update_station_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('station_id', 'Station Id', 'trim|required');
        $this->form_validation->set_rules('station_name', 'Station Name', 'trim|required');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Phone Number', 'trim|required|min_length[5]|max_length[15]');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        //$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        //echo '<pre>';print_r($_POST);die;
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'station_id', 'station_name', 'contact_person', 'contact_number',
                'country', 'state', 'city', 'address');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $station_id = trim($this->input->post('station_id'));
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

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if (!$this->api_model->getTableById('station', 'station_id', $station_id)) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Station not found.';
                    $this->response($this->data, 200);
                }

                $user = $this->api_model->getUserById($user_id);
                //if ($user && $user->user_type == 'Transporter') {
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You have no rights to update stations.';
                    $this->response($this->data, 200);
                }

                $data = array();
                $data['owner_id'] = $user_id;
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
                $data['updated_date'] = DATETIME;

                $this->api_model->updateTable('station', 'station_id', $station_id, $data);

                $this->data['status'] = 'success';
                $this->data['message'] = 'Station updated successfully.';
                $this->data['data'] = $this->api_model->getTableById('station', 'station_id', $station_id);
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // delete station function
    public function delete_station_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('station_id', 'Station Id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'station_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $station_id = trim($this->input->post('station_id'));

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if (!$this->api_model->getTableById('station', 'station_id', $station_id)) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Station not found.';
                    $this->response($this->data, 200);
                }

                $user = $this->api_model->getUserById($user_id);
                if ($user && $user->user_type == 'Transporter') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You have no rights to delete stations.';
                    $this->response($this->data, 200);
                }

                $this->api_model->deleteTable('station', 'station_id', $station_id);

                $this->data['status'] = 'success';
                $this->data['message'] = 'Station deleted successfully.';
                $this->data['data'] = true;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // manager list function
    public function manager_list_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $user_type = trim($this->input->post('user_type'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $page = trim($this->input->post('page'));
                $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';

                $limit = 10;
                $table = 'user';
                $select = 'user_id, name, email, mobile, address, profile_pic';
                $order_key = '';
                $order_by = '';
                $search_key = array('name');
                $where = ['owner_id' => $user_id, 'user_type' => $user_type];
                if ($users = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search, $limit, $page)) {

                    foreach ($users as $user) {
                        $user->profile_pic_url = getImage('user', $user->profile_pic);
                    }

                    $total_records_count = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $users;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Managers data found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Managers data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // get user function
    public function get_user_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'user_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $get_user_id = trim($this->input->post('user_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if ($user = $this->api_model->getUserById($get_user_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'User data found';
                    $this->data['data'] = $user;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'User data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // get station function
    public function get_station_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('station_id', 'Station Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'station_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $station_id = trim($this->input->post('station_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if ($station = $this->api_model->getTableById('station', 'station_id', $station_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Staion data found';
                    $this->data['data'] = $station;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Staion data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // get product
    public function get_product_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'category_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $category_id = trim($this->input->post('category_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if ($category = $this->api_model->getCategoryPrice($category_id)) {
                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Product data found';
                    $this->data['data'] = $category;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Product data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    //check product
    public function check_product_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'category_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $category_id = trim($this->input->post('category_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {


                if ($cart_data = $this->api_model->getCartByCategoryId($user_id, $category_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Product found successfully';
                    $this->data['data'] = $this->api_model->getTableById('carts', 'cart_id', $cart_data->cart_id, 0, 'product_image', 'image');
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Product not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // add to cart
    public function add_to_cart_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Category Id', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'category_id', 'quantity');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $category_id = trim($this->input->post('category_id'));
            $quantity = trim($this->input->post('quantity')) + 0;
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if (!$quantity) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Quantity required';
                    $this->response($this->data, 200);
                }

                if ($category = $this->api_model->getCategoryPrice($category_id)) {

                    if ($category->minimum_order_qty > $quantity) {

                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Please enter minimum quantity ' . $category->minimum_order_qty;
                    } else {

                        $product = $this->api_model->getTableById('category', 'category_id', $category_id);
                        $product_inactive = $product ? 0 : 1;

                        if ($product_inactive) {
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'Product is inactive';
                            $this->response($this->data, 200);
                        }

                        $cart_data = $this->api_model->getCartByCategoryId($user_id, $category_id);
                        if ($cart_data) {

                            $data = array();
                            $data['qty'] = $quantity;
                            $data['total_price'] = round($quantity * $category->price, 2);
                            $data['updated_date'] = DATETIME;

                            $this->api_model->updateTable('carts', 'cart_id', $cart_data->cart_id, $data);

                            $this->data['status'] = 'success';
                            $this->data['message'] = 'Cart updated successfully';
                            $this->data['data'] = $this->api_model->getTableById('carts', 'cart_id', $cart_data->cart_id, 0, 'product_image', 'image');
                        } else {

                            $data = array();
                            $data['user_id'] = $user_id;
                            $data['category_id'] = $category_id;
                            $data['qty'] = $quantity;
                            $data['name'] = $category->name;
                            $data['type'] = $category->type;
                            $data['image'] = $category->image;
                            $data['measurement'] = $category->measurement;
                            $data['currency'] = $category->currency;
                            $data['price'] = $category->price;
                            $data['total_price'] = round($quantity * $category->price, 2);
                            $data['created_date'] = DATETIME;

                            $cart_id = $this->api_model->addTable('carts', $data);

                            $this->data['status'] = 'success';
                            $this->data['message'] = 'Added to cart successfully';
                            $this->data['data'] = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0, 'product_image', 'image');
                        }
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Cart not added';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // update cart
    public function update_cart_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('cart_id', 'Cart Id', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'cart_id', 'quantity');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $cart_id = trim($this->input->post('cart_id'));
            $quantity = trim($this->input->post('quantity')) + 0;
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if (!$quantity) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Quantity required';
                    $this->response($this->data, 200);
                }

                if ($cart_data = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0)) {

                    $category = $this->api_model->getTableById('category', 'category_id', $cart_data->category_id, 1);
                    if ($category->minimum_order_qty > $quantity) {

                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Please enter minimum quantity ' . $category->minimum_order_qty;
                    } else {

                        $product_inactive = 0;
                        if ($cart = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0)) {
                            $product = $this->api_model->getTableById('category', 'category_id', $cart->category_id);
                            if (!$product) {
                                $product_inactive = 1;
                            }
                        }

                        if ($product_inactive) {
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'Product is inactive';
                            $this->response($this->data, 200);
                        }

                        $data = array();
                        $data['qty'] = $quantity;
                        $data['total_price'] = round($quantity * $cart_data->price, 2);
                        $data['updated_date'] = DATETIME;

                        $this->api_model->updateTable('carts', 'cart_id', $cart_id, $data);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Cart updated successfully';
                        $this->data['data'] = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0, 'product_image', 'image');
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Cart data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // delete cart
    public function delete_cart_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('cart_id', 'Cart Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'cart_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $cart_id = trim($this->input->post('cart_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if ($cart_data = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0)) {

                    if ($this->api_model->deleteTable('carts', 'cart_id', $cart_id)) {

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Cart deleted successfully';
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Cart not deleted';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Cart data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // cart list
    public function cart_list_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $station_id = trim($this->input->post('station_id'));
            $coupon_code = trim($this->input->post('coupon_code'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $cart_data = $this->api_model->getCartData($user_id);
                if ($cart_data && $cart_data['cart']) {

                    $shipping_charge = $this->common_model->getSiteSettingByTitle('shipping_charge');
                    $shipping_rate_per_km = $this->common_model->getShippingCharge($station_id, $shipping_charge);

                    $data = array();
                    $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
                    //$data['shipping_charge'] = $this->common_model->getSiteSettingByTitle('shipping_charge');
                    $data['shipping_charge'] = $shipping_rate_per_km;
                    //$data['tax'] = $this->common_model->getSiteSettingByTitle('tax');
                    $tax = $this->common_model->getSiteSettingByTitle('tax');

                    $tamount = $amount = $cart_data['amount'];

                    $discount = 0;
                    $coupon = $this->api_model->getCoupon($coupon_code);
                    if ($coupon) {
                        $discount = $coupon->discount;

                        $amount = round($amount - $discount, 2);
                    }

                    $tax_amount = 0;
                    if ($tax) {
                        $tax_amount = round(($amount * $tax) / 100);
                    }
                    
                    $data['tax'] = (string) $tax_amount;

                    $data['amount'] = $tamount;
                    $data['discount'] = $discount;
                    $data['total_amount'] = round($data['shipping_charge'] + $data['tax'] + $amount, 2);
                    $data['final_total_amount'] = round($data['shipping_charge'] + $data['tax'] + $tamount, 2);
                    $data['cart_data'] = $cart_data['cart'];

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Cart data found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Cart data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // place order
    public function place_order_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('station_id', 'Station Id', 'trim|required');
        $this->form_validation->set_rules('cart_ids', 'Cart Ids', 'trim|required');
        $this->form_validation->set_rules('shipping_charge', 'Shipping Charge', 'trim|required');
        $this->form_validation->set_rules('tax', 'Tax', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required');
        $this->form_validation->set_rules('is_schedule_delivery', 'Is Schedule Delivery', 'trim|required');
        //$this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'station_id', 'cart_ids', 'shipping_charge', 'tax',
                'amount', 'total_amount', 'is_schedule_delivery');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $station_id = trim($this->input->post('station_id'));
            $cart_ids = trim($this->input->post('cart_ids'));
            $shipping_charge = trim($this->input->post('shipping_charge'));
            $tax = trim($this->input->post('tax'));
            $amount = trim($this->input->post('amount'));
            $total_amount = trim($this->input->post('total_amount'));
            $is_schedule_delivery = trim($this->input->post('is_schedule_delivery'));
            $delivery_date = trim($this->input->post('delivery_date'));
            $delivery_time = trim($this->input->post('delivery_time'));
            $payment_type = trim($this->input->post('payment_type'));
            $coupon_code = trim($this->input->post('coupon_code'));
            $is_invoice = trim($this->input->post('is_invoice'));

            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $user = $this->user_model->getUserById($user_id);

                if ($station_id == 0) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Station id required';
                    $this->response($this->data, 200);
                }

                if ($user->user_type == 'Owner' && $payment_type == '') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Payment type required';
                    $this->response($this->data, 200);
                }

                if ($decode_cart_ids = json_decode($cart_ids)) {

                    $product_inactive = 0;
                    foreach ($decode_cart_ids as $cart_id) {

                        if ($cart = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0)) {
                            $product = $this->api_model->getTableById('category', 'category_id', $cart->category_id);
                            if (!$product) {
                                $product_inactive = 1;
                            }
                        }
                    }

                    if ($product_inactive) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Product is inactive';
                        $this->response($this->data, 200);
                    }

                    $data = array();
                    $discount = 0;
                    $coupon = $this->api_model->getCoupon($coupon_code);
                    if ($coupon) {
                        $discount = $coupon->discount;

                        $total_amount = round($total_amount - $discount, 2);
                    }

                    $data['user_id'] = $user_id;
                    $data['station_id'] = $station_id;
                    $data['shipping_charge'] = $shipping_charge;
                    $data['tax'] = $tax;
                    $data['amount'] = $amount;
                    $data['total_amount'] = $total_amount;
                    $data['is_schedule_delivery'] = $is_schedule_delivery;
                    $data['order_date'] = date('Y-m-d');
                    $data['delivery_date'] = $is_schedule_delivery ? $delivery_date : date('Y-m-d');
                    $data['delivery_time'] = $delivery_time;
                    $data['coupon_code'] = $coupon_code;
                    $data['coupon_id'] = $coupon ? $coupon->coupon_id : 0;
                    $data['discount'] = $discount;
                    $is_approve = 1;

                    if ($user->owner_id) {
                        //$owner = $this->user_model->getUserById($user->owner_id);
                        //$payment_type = $owner ? ($owner->payment_type == 1 ? 'Upfront' : '50 Advance') : 'None';
                        $payment_type = 'None';

                        $is_approve = 0;
                    }
                    $data['is_approve'] = $is_approve;
                    $data['payment_type'] = $payment_type;
                    $data['created_date'] = DATETIME;
                    $data['updated_date'] = DATETIME;
                    $data['is_owner'] = $user->user_type == 'Owner' ? 1 : 0;
                    $data['owner_id'] = $user->user_type == 'Owner' ? $user->user_id : $user->owner_id;
                    $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');

                    $transporter_accept_time = $this->common_model->getSiteSettingByTitle('transporter_accept_time');
                    $data['time_left_to_accept'] = date('Y-m-d H:i:s', strtotime("+$transporter_accept_time minutes", strtotime(DATETIME)));

                    $cart_order_id = $this->api_model->addTable('cart_orders', $data);

                    $is_order = 0;
                    foreach ($decode_cart_ids as $cart_id) {

                        if ($cart = $this->api_model->getTableById('carts', 'cart_id', $cart_id, 0)) {

                            $detail = array();
                            $detail['cart_order_id'] = $cart_order_id;
                            $detail['cart_user_id'] = $cart->user_id;
                            $detail['category_id'] = $cart->category_id;
                            $detail['qty'] = $cart->qty;
                            $detail['name'] = $cart->name;
                            $detail['type'] = $cart->type;
                            $detail['image'] = $cart->image;
                            $detail['measurement'] = $cart->measurement;
                            $detail['currency'] = $cart->currency;
                            $detail['price'] = $cart->price;
                            $detail['cart_created'] = $cart->created_date;
                            $detail['cart_updated'] = $cart->updated_date;
                            $detail['total_price'] = round($cart->qty * $cart->price, 2);

                            if ($this->api_model->addTable('cart_order_details', $detail)) {
                                if ($is_approve == 0) {
                                    $this->api_model->deleteTable('carts', 'cart_id', $cart->cart_id);
                                }
                                $is_order = 1;
                            }
                        }
                    }

                    if ($is_order) {

                        $cart_order = array();
                        $cart_order['order_id'] = $this->api_model->generate_order_id($cart_order_id, 'O');
                        $cart_order['is_order'] = 1;
                        $this->api_model->updateTable('cart_orders', 'id', $cart_order_id, $cart_order);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Order placed successfully';
                        $this->data['data'] = array('id' => $cart_order_id, 'order_id' => $cart_order['order_id']);
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Order not placed';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Cart Ids not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // transporter availability
    public function transporter_available_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('available', 'Available', 'trim|required');
        //$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        //$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'available');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $available = trim($this->input->post('available'));
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));
            $list_date = $this->input->post('list_date');
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $data = array();
                $data['transporter_available'] = $available;
                $data['latitude'] = $latitude;
                $data['longitude'] = $longitude;

                if ($available) {
                    $this->db->where('user_id', $user_id);
                    $this->db->where('set_date', date('Y-m-d'));
                    $today_transporter_not_available = $this->db->get('transporter_not_available')->row();
                    if ($today_transporter_not_available) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Please delete your leave date to activate your profile';
                        $this->response($this->data, 200);
                    }
                    $this->api_model->updateTable('user', 'user_id', $user_id, $data);
                } else {

                    $check_delivery = 0;
                    if ($decode_list_date = json_decode($list_date)) {
                        foreach ($decode_list_date as $date) {

                            $set_date = $date != '' ? date('Y-m-d', strtotime($date)) : NULL;
                            if ($set_date) {

                                $this->db->where('is_order', 1);
                                $this->db->where('delivery_date', $set_date);
                                $this->db->where('transporter_id', $user_id);
                                $this->db->limit(1);
                                $order = $this->db->get('cart_orders')->row();

                                if ($order) {
                                    $check_delivery = $order->delivery_date;
                                }
                            }
                        }
                    }

                    if ($check_delivery) {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Please check your order delivery date ' . $check_delivery;
                        $this->response($this->data, 200);
                    }

                    if ($decode_list_date = json_decode($list_date)) {
                        foreach ($decode_list_date as $date) {

                            $set_date = $date != '' ? date('Y-m-d', strtotime($date)) : NULL;
                            if ($set_date) {

                                $availability = array();
                                $availability['user_id'] = $user_id;
                                $availability['set_date'] = $set_date;

                                $this->db->where('user_id', $user_id);
                                $this->db->where('set_date', $set_date);
                                $transporter_not_available = $this->db->get('transporter_not_available')->row();
                                /* if($transporter_not_available){
                                  if($available){
                                  $this->api_model->deleteTable('transporter_not_available', 'id', $transporter_not_available->id);
                                  }else{
                                  $this->api_model->updateTable('transporter_not_available', 'id', $transporter_not_available->id, $availability);
                                  }
                                  }else{
                                  $availability['created_date'] = DATETIME;
                                  $this->api_model->addTable('transporter_not_available', $availability);
                                  } */

                                if (!$transporter_not_available) {
                                    $availability['created_date'] = DATETIME;
                                    $this->api_model->addTable('transporter_not_available', $availability);
                                }
                            }
                        }
                    }
                }

                $this->data['status'] = 'success';
                $this->data['message'] = 'Transporter availability updated successfully';
                $this->data['data'] = $this->api_model->getUserById($user_id);
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // update profile pic
    public function update_profile_pic_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if (!empty($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != '' && $_FILES['profile_pic']['error'] == 0) {

                    if (!file_exists(PROFILEPIC))
                        mkdir(PROFILEPIC);

                    $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                    $profile_pic = 'pic_' . rand(111, 999) . time() . '.' . $ext;

                    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], PROFILEPIC . $profile_pic)) {

                        $data = array();
                        $data['profile_pic'] = $profile_pic;
                        $data['updated_date'] = DATETIME;
                        $this->user_model->updateUser($user_id, $data);

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Profile pic updated';
                        $this->data['data'] = $this->api_model->getUserById($user_id);
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Please select file';
                    }
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function home_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {
                $data = $this->api_model->getUserById($user_id, 1);

                $data->unread_notifications = $this->api_model->getUnreadNotificationCounts($user_id);
                $data->cart_count = $this->api_model->countCartData($user_id);

                $advertisement_type = '';
                $display_advertisement = $this->common_model->getSiteSettingByTitle('display_advertisement');
                if (!$display_advertisement || $display_advertisement != 'None') {
                    if ($data && $data->user_type == 'Owner') {
                        if ($display_advertisement == 'Both') {
                            $advertisement_type = 'Owner';
                        } else {
                            $advertisement_type = $data->user_type == $display_advertisement ? $data->user_type : '';
                        }
                    }
                    if ($data && $data->user_type == 'Transporter') {
                        if ($display_advertisement == 'Both') {
                            $advertisement_type = 'Transporter';
                        } else {
                            $advertisement_type = $data->user_type == $display_advertisement ? $data->user_type : '';
                        }
                        $data->rating = $this->common_model->getTransporterRating($user_id);
                    }
                }
                $data->display_advertisement = $advertisement_type;
                $data->service_available_radius = $this->common_model->getSiteSettingByTitle('service_available_radius');
                $data->invoice_amount = $this->common_model->getSiteSettingByTitle('invoice_amount');

                $this->data['status'] = 'success';
                $this->data['message'] = 'Home screen data found';
                $this->data['data'] = $data;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function current_order_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $is_manager = 1;
                $user_ids = (array) $user_id;
                $user_data = $this->user_model->getUserById($user_id);
                if ($user_data && $user_data->owner_id == 0) {
                    if ($users = $this->api_model->getManagerIds($user_id)) {
                        $manager_ids = explode(',', $users->user_ids);
                        if ($manager_ids) {
                            $user_ids = array_merge($user_ids, $manager_ids);
                        }
                        $is_manager = 0;
                    }
                }
                $user_ids = array_filter($user_ids);

                if ($orders = $this->api_model->getCurrentOrders($user_ids, $is_manager)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Current orders data found';
                    $this->data['data'] = $orders;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Current orders data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function order_list_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_status', 'Order Status', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_status');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $order_status = trim($this->input->post('order_status'));
            $from_date = trim($this->input->post('from_date'));
            $to_date = trim($this->input->post('to_date'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $page = trim($this->input->post('page'));
                $limit = 10;
                if ($orders = $this->api_model->getOrders($user_id, $order_status, $from_date, $to_date, $limit, $page)) {

                    $total_records_count = $this->api_model->getOrders($user_id, $order_status, $from_date, $to_date, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $orders;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Orders list found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Orders list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function requested_orders_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_type = trim($this->input->post('user_type'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $page = trim($this->input->post('page'));
                $limit = 10;
                if ($orders = $this->api_model->getManagerOrders($user_id, $user_type, $limit, $page)) {

                    $total_records_count = $this->api_model->getManagerOrders($user_id, $user_type, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $orders;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Orders list found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Orders list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function order_details_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $order_id = trim($this->input->post('order_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($orders = $this->api_model->getOrderById($order_id)) {

                    $transporter_id = 0;
                    $transporter_name = $transporter_mobile = $vehicle_number = '';
                    if ($assign_orders = $this->api_model->getAssignOrder($order_id)) {
                        $transporter_id = $assign_orders->transporter_id;

                        if ($transporter = $this->db->where('status', 1)->where('user_id', $transporter_id)->get('user')->row()) {
                            $transporter_name = $transporter->name;
                            $transporter_mobile = $transporter->mobile;

                            if ($vehicle = $this->db->where('status', 1)->where('vehicle_id', $transporter->vehicle_id)->get('vehicle')->row()) {
                                $vehicle_number = $vehicle->vehicle_number;
                            }
                        }
                    }
                    $orders->transporter_id = $transporter_id;
                    $orders->transporter_name = $transporter_name;
                    $orders->transporter_mobile = $transporter_mobile;
                    $orders->vehicle_number = $vehicle_number;

                    $orders->order_details = $this->api_model->getOrderDetails($order_id);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Order details found';
                    $this->data['data'] = $orders;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order details not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function transporter_order_list_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_status', 'Order Status', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_status');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $order_status = trim($this->input->post('order_status'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $page = trim($this->input->post('page'));
                $limit = 10;
                if ($orders = $this->api_model->transporterOrders($user_id, $order_status, $limit, $page)) {

                    $total_records_count = $this->api_model->transporterOrders($user_id, $order_status, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $orders;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Orders list found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Orders list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function transporter_order_details_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $order_id = trim($this->input->post('order_id'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($orders = $this->api_model->transporterOrdersDetails($order_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Order data found';
                    $this->data['data'] = $orders;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function transporter_order_action_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('assign_order_id', 'Assign Order Id', 'trim|required');
        $this->form_validation->set_rules('order_status', 'Order Status', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id', 'assign_order_id', 'order_status');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $order_id = trim($this->input->post('order_id'));
            $assign_order_id = trim($this->input->post('assign_order_id'));
            //$order_detail_id = trim($this->input->post('order_detail_id'));
            $order_status = trim($this->input->post('order_status'));
            $reason_id = trim($this->input->post('reason_id'));
            $reason_description = trim($this->input->post('reason_description'));
            $otp = trim($this->input->post('otp'));
            $signature_file = trim($this->input->post('signature_file'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($orders = $this->api_model->getAssignOrder($order_id)) {

                    $check_staus = 0;
                    if ($order_status != 'Reject' && $this->api_model->getAssignOrderDetailByAssignId($assign_order_id, $order_status)) {
                        $check_staus = 1;
                    }

                    if ($check_staus) {
                        $message = 'Order status already exists';
                        if ($order_status == 'Accept') {
                            $message = 'Sorry!!! This order has been taken by another transporter. Thank you for your support. Please check for new orders.';
                        }
                        $this->data['status'] = 'error';
                        $this->data['message'] = $message;
                        $this->response($this->data, 200);
                    }

                    $order_data = $this->api_model->getTableById('cart_orders', 'id', $order_id, 0);
                    if ($order_data && $order_data->order_status == 'Cancelled') {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Order is cancelled by admin';
                        $this->response($this->data, 200);
                    }

                    //Reject order
                    if ($order_status == 'Reject') {

                        if ($reason_id == '') {
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'Reason Id required';
                            $this->response($this->data, 200);
                        }

                        $reject_reason = $this->api_model->getTableById('reject_reason', 'id', $reason_id);
                        $reason_title = $reject_reason ? $reject_reason->title : '';

                        $reject_data = array(
                            'order_id' => $order_id,
                            'assign_order_id' => $assign_order_id,
                            'order_status' => $order_status,
                            'reason_id' => $reason_id,
                            'reason_title' => $reason_title,
                            'reason_description' => $reason_description,
                            'reject_user_id' => $user_id,
                            'date_time' => DATETIME
                        );

                        if ($this->api_model->addAssignOrderDetails($reject_data)) {

                            $this->api_model->updateAssignOrder($assign_order_id, $order_id, array('assign_status' => 'Reject'));

                            $this->api_model->updateTable('cart_orders', 'id', $order_id, array('order_status' => 'Rejected'));

                            $this->data['status'] = 'success';
                            $this->data['message'] = 'Order Rejected';
                            $this->data['data'] = array('order_id' => $order_id, 'type' => $order_status);
                        }
                    } else {

                        //Delivered order
                        if ($order_status == 'Delivered') {

                            $result = array();
                            $result['payment_pending'] = 0;
                            $result['signature_pending'] = 0;
                            $result['invalid_otp'] = 0;

                            $payment = $this->api_model->checkPaidTransactionAmount($order_id);
                            if ($payment) {

                                $result['payment_pending'] = 1;
                                $result['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
                                $result['pending_amount'] = $payment;
                                $this->data['status'] = 'error';
                                $this->data['message'] = 'Payment pending';
                                $this->data['data'] = $result;
                                $this->response($this->data, 200);
                            }

                            //Upload Signature
                            if (isset($_FILES['signature']) && $_FILES['signature']['name'] && $_FILES['signature']['error'] == 0) {

                                if (!file_exists(SIGNATURE))
                                    mkdir(SIGNATURE);

                                $ext = pathinfo($_FILES['signature']['name'], PATHINFO_EXTENSION);
                                $signature = 'sign_' . rand(111, 999) . time() . '.' . $ext;

                                if (move_uploaded_file($_FILES['signature']['tmp_name'], SIGNATURE . $signature)) {
                                    $signature_file = $signature;
                                }
                            }

                            if ($signature_file == '') {

                                $result['signature_pending'] = 1;
                                $this->data['status'] = 'error';
                                $this->data['message'] = 'Signature is required';
                                $this->data['data'] = $result;
                                $this->response($this->data, 200);
                            }

                            $order_data = $this->api_model->getTableById('cart_orders', 'id', $order_id, 0);
                            if ($order_data && $order_data->otp_code != $otp) {

                                $result['invalid_otp'] = 1;
                                $this->data['status'] = 'error';
                                $this->data['message'] = 'Invalid OTP';
                                $this->data['data'] = $result;
                                $this->response($this->data, 200);
                            }
                        }

                        //Accept Order
                        if ($order_status == 'Accept') {

                            $no_vehicle = 1;
                            $this->db->where('user_id', $user_id);
                            $vehicle = $this->db->get('vehicle')->row();

                            if ($vehicle && $vehicle->status) {
                                $no_vehicle = 0;
                            }

                            if ($no_vehicle) {
                                $this->data['status'] = 'error';
                                $this->data['message'] = 'Vehicle status is inactive or not found';
                                $this->response($this->data, 200);
                            }

                            if ($card_detail = $this->db->select('SUM(qty) as total_qty')->where('cart_order_id', $order_id)->get('cart_order_details')->row()) {
                                $capacity = $card_detail->total_qty;

                                $this->db->where('u.user_id', $user_id);
                                $this->db->where('u.status', '1');
                                $this->db->where('u.user_type', 'Transporter');
                                $this->db->where("u.vehicle_id != 0");
                                $this->db->where("v.vehicle_capacity >= $capacity");
                                $this->db->join('vehicle v', 'v.vehicle_id = u.vehicle_id', 'LEFT');
                                $this->db->limit(1);
                                $vehicle_capacity = $this->db->get('user u')->row();

                                if (!$vehicle_capacity) {
                                    $this->data['status'] = 'error';
                                    $this->data['message'] = 'Transporter vehicle capacity is over';
                                    $this->response($this->data, 200);
                                }
                            }

                            $delivery_date = date('Y-m-d');
                            if ($order = $this->db->where('is_order', 1)->where('id', $order_id)->limit(1)->get('cart_orders')->row()) {
                                $delivery_date = $order->delivery_date;
                            }

                            $this->db->where('set_date', $delivery_date);
                            $this->db->where('user_id', $user_id);
                            $not_available = $this->db->get('transporter_not_available')->row();

                            if ($not_available) {
                                $this->data['status'] = 'error';
                                $this->data['message'] = 'Transporter not available on this delivery date';
                                $this->response($this->data, 200);
                            }
                        }

                        $accept_data = array(
                            'order_id' => $order_id,
                            'assign_order_id' => $assign_order_id,
                            'order_status' => $order_status,
                            'date_time' => DATETIME
                        );

                        if ($assign_order_detail_id = $this->api_model->addAssignOrderDetails($accept_data)) {

                            //Delivered Order
                            if ($order_status == 'Delivered') {
                                $this->api_model->updateAssignOrder($assign_order_id, $order_id, array('assign_status' => 'Delivered'));

                                $update_order = array(
                                    'otp_code' => '',
                                    'signature_file' => $signature_file,
                                    'order_status' => 'Completed',
                                    'delivered_datetime' => DATETIME
                                );
                                $this->api_model->updateTable('cart_orders', 'id', $order_id, $update_order);

                                //Owner push notification
                                $order = $this->api_model->getOrderById($order_id);
                                $this->common_model->send_nearby_notification($order_id, 'Owner', 'Completed', $order->owner_id);

                                //Owner Send SMS
                                $this->common_model->sendOrderMessage($order_id, $order->owner_id);
                            }

                            //Accept Order
                            if ($order_status == 'Accept') {
                                $this->api_model->updateAssignOrder($assign_order_id, $order_id, array('transporter_id' => $user_id, 'assign_status' => 'Accept'));
                                $this->api_model->updateTable('cart_orders', 'id', $order_id, array('transporter_id' => $user_id, 'order_status' => 'Accepted'));

                                //Owner push notification
                                $order = $this->api_model->getOrderById($order_id);
                                $this->common_model->send_nearby_notification($order_id, 'Owner', 'Accepted', $order->owner_id);
                            }

                            //Reach or Loaded order
                            if ($order_status == 'Reach' || $order_status == 'Loaded') {

                                $update_order = array('order_status' => 'Processing');

                                if ($order_status == 'Loaded') {

                                    $mobile = '';
                                    if ($order_row = $this->api_model->getTableById('cart_orders', 'id', $order_id, 0)) {
                                        $user = $this->api_model->getTableById('user', 'user_id', $order_row->owner_id);
                                        $mobile = $user ? $user->mobile : '';
                                    }

                                    $update_order['otp_code'] = $this->get_code($mobile);
                                }
                                $this->api_model->updateTable('cart_orders', 'id', $order_id, $update_order);

                                //Owner push notification
                                $order = $this->api_model->getOrderById($order_id);
                                $this->common_model->send_nearby_notification($order_id, 'Owner', $order_status, $order->owner_id);
                            }
                            $this->data['status'] = 'success';
                            $this->data['message'] = 'Order ' . $order_status;
                            if ($order_status == 'Reach') {
                                $this->data['message'] = 'Transporter reached depot';
                            }
                            if ($order_status == 'Loaded') {
                                $this->data['message'] = 'Transporter collected fuel';
                            }
                            $this->data['data'] = array('order_id' => $order_id, 'type' => $order_status);
                        }
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function reject_reason_list_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                //$page = trim($this->input->post('page'));
                //$search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';
                //$limit = 10;
                $table = 'reject_reason';
                $select = 'id, title';
                $order_key = 'display_order';
                $order_by = 'asc';
                //$search_key = array('title');
                //$where = [];
                if ($reject_reason = $this->api_model->getTablePagination($table, $select, $order_key, $order_by)) {

                    /* $total_records_count = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search, $limit, $page, 1);
                      $pages_count = (int) ceil(($total_records_count / $limit));

                      $data['pages_count'] = $pages_count;
                      $data['total_records_count'] = $total_records_count;
                      $data['result'] = $reject_reason; */

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Reject reason list found';
                    $this->data['data'] = $reject_reason;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Reject reason list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function transporter_update_profile_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|min_length[5]|max_length[15]');
        //$this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('vehicle_number', 'Vehicle Number', 'trim|required');
        $this->form_validation->set_rules('vehicle_capacity', 'Vehicle Capacity', 'trim|required');
        $this->form_validation->set_rules('front_vehicle_photo', 'Front Vehicle Photo', 'trim|required');
        $this->form_validation->set_rules('back_vehicle_photo', 'Back Vehicle Photo', 'trim|required');
        $this->form_validation->set_rules('left_vehicle_photo', 'Left Vehicle Photo', 'trim|required');
        $this->form_validation->set_rules('right_vehicle_photo', 'Right Vehicle Photo', 'trim|required');
        $this->form_validation->set_rules('vehicle_document', 'Vehicle Document', 'trim|required');
        $this->form_validation->set_rules('no_of_compartment', 'No of Compartment', 'trim|required');
        $this->form_validation->set_rules('compartment_detail', 'Compartment Detail', 'trim|required');
        $this->form_validation->set_rules('document_number', 'Document Number', 'trim|required');
        $this->form_validation->set_rules('driving_license', 'Driving License', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'name', 'email', 'mobile', 'vehicle_number', 'vehicle_capacity',
                'front_vehicle_photo', 'back_vehicle_photo', 'left_vehicle_photo', 'right_vehicle_photo',
                'vehicle_document', 'no_of_compartment', 'compartment_detail',
                'document_number', 'driving_license');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $mobile = trim($this->input->post('mobile'));
            $address = trim($this->input->post('address'));

            $user_id = $this->check_user_token($user_token);
            $check_email = $this->user_model->check_user_data('email', $email, $user_id);
            if (!$check_email) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Email already exist.';
                $this->response($this->data, 200);
            }
            $check_mobile = $this->user_model->check_user_data('mobile', $mobile, $user_id);
            if (!$check_mobile) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Mobile number already exist.';
                $this->response($this->data, 200);
            }

            $total_compartment_capacity = 0;
            $compartment_detail = $this->input->post('compartment_detail');
            if ($compartment_details = json_decode($compartment_detail)) {

                foreach ($compartment_details as $compartment) {
                    $total_compartment_capacity += $compartment->compartment_capacity;
                }
            }

            $vehicle_capacity = trim($this->input->post('vehicle_capacity'));
            if ($vehicle_capacity != $total_compartment_capacity) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Vehicle capacity and total compartment capacity mismatch, please check it.';
                $this->response($this->data, 200);
            } 
            
            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            $data['mobile'] = $mobile;
            if ($address != '') {
                $data['address'] = $address;
            }
            if ($user_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->user_model->updateUser($user_id, $data);

                $this->load->model('vehicle_model');
                $vehicle_id = trim($this->input->post('vehicle_id'));
                $vehicle_number = trim($this->input->post('vehicle_number'));
                $vehicle_capacity = trim($this->input->post('vehicle_capacity'));
                $front_vehicle_photo = trim($this->input->post('front_vehicle_photo'));
                $back_vehicle_photo = trim($this->input->post('back_vehicle_photo'));
                $left_vehicle_photo = trim($this->input->post('left_vehicle_photo'));
                $right_vehicle_photo = trim($this->input->post('right_vehicle_photo'));
                $vehicle_document = trim($this->input->post('vehicle_document'));
                $no_of_compartment = trim($this->input->post('no_of_compartment'));

                $compartment_detail = $this->input->post('compartment_detail');
                $document_number = trim($this->input->post('document_number'));
                $driving_license = trim($this->input->post('driving_license'));

                $vehicle_data = array(
                    'user_id' => $user_id,
                    'vehicle_number' => $vehicle_number,
                    'measurement' => 'Litr',
                    'vehicle_capacity' => $vehicle_capacity,
                    'front_vehicle_photo' => $front_vehicle_photo,
                    'back_vehicle_photo' => $back_vehicle_photo,
                    'left_vehicle_photo' => $left_vehicle_photo,
                    'right_vehicle_photo' => $right_vehicle_photo,
                    'vehicle_document' => $vehicle_document,
                    'no_of_compartment' => $no_of_compartment
                );

                if ($vehicle_id && $this->vehicle_model->getVehicleById($vehicle_id)) {
                    $vehicle_data['updated_date'] = DATETIME;
                    $this->vehicle_model->updateVehicle($vehicle_id, $vehicle_data);
                } else {
                    $vehicle_data['created_date'] = DATETIME;
                    $vehicle_id = $this->vehicle_model->addVehicle($vehicle_data);
                }

                if ($vehicle_id) {

                    $this->user_model->updateUser($user_id, array('vehicle_id' => $vehicle_id));
                    if ($compartment_details = json_decode($compartment_detail)) {

                        $this->vehicle_model->deleteVehicleDetail($vehicle_id);
                        foreach ($compartment_details as $compartment) {

                            $vehicle_detail = array(
                                'vehicle_id' => $vehicle_id,
                                'compartment_no' => $compartment->compartment_no,
                                'compartment_capacity' => $compartment->compartment_capacity
                            );
                            $this->vehicle_model->addVehicleDetail($vehicle_detail);
                        }
                    }

                    $user_document = array(
                        'user_id' => $user_id,
                        'document_type' => 'Driving License',
                        'document_number' => $document_number,
                        'front_photo' => $driving_license
                    );

                    if ($document = $this->user_model->getUserDocuments($user_id)) {
                        $user_document['updated_date'] = DATETIME;
                        $this->user_model->updateUserDocuments($document->id, $user_document);
                    } else {
                        $user_document['created_date'] = DATETIME;
                        $vehicle_id = $this->user_model->addUserDocuments($user_document);
                    }
                }

                $this->data['status'] = 'success';
                $this->data['message'] = 'Profile successfully updated.';
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Invalid User id';
            }
        }

        $this->response($this->data, 200);
    }

    //for transporter
    public function upload_documents_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('document_type', 'Document Type', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'document_type');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $document_type = trim($this->input->post('document_type'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $front_photo = $directory = '';
                if ($document_type == 'Driving License') {

                    if (isset($_FILES['front_photo']) && $_FILES['front_photo']['name'] && $_FILES['front_photo']['error'] == 0) {

                        if (!file_exists(USER_DOCUMENTS))
                            mkdir(USER_DOCUMENTS);

                        $ext = pathinfo($_FILES['front_photo']['name'], PATHINFO_EXTENSION);
                        $_front_photo = 'front_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['front_photo']['tmp_name'], USER_DOCUMENTS . $_front_photo)) {
                            $front_photo = $_front_photo;
                        }
                    }
                    $directory = USER_DOCUMENTS;
                }

                if ($document_type == 'Vehicle Document') {

                    if (isset($_FILES['front_photo']) && $_FILES['front_photo']['name'] && $_FILES['front_photo']['error'] == 0) {

                        if (!file_exists(VEHICLE_IMG))
                            mkdir(VEHICLE_IMG);

                        $ext = pathinfo($_FILES['front_photo']['name'], PATHINFO_EXTENSION);
                        $_front_photo = 'document_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['front_photo']['tmp_name'], VEHICLE_IMG . $_front_photo)) {
                            $front_photo = $_front_photo;
                        }
                    }
                    $directory = VEHICLE_IMG;
                }

                if ($document_type == 'Vehicle Photo') {

                    //Front Vehicle Photo
                    if (isset($_FILES['front_photo']) && $_FILES['front_photo']['name'] && $_FILES['front_photo']['error'] == 0) {

                        if (!file_exists(VEHICLE_IMG))
                            mkdir(VEHICLE_IMG);

                        $ext = pathinfo($_FILES['front_photo']['name'], PATHINFO_EXTENSION);
                        $_front_photo = 'front_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['front_photo']['tmp_name'], VEHICLE_IMG . $_front_photo)) {
                            $front_photo = $_front_photo;
                        }
                    }

                    //Back Vehicle Photo
                    if (isset($_FILES['back_photo']) && $_FILES['back_photo']['name'] && $_FILES['back_photo']['error'] == 0) {

                        if (!file_exists(VEHICLE_IMG))
                            mkdir(VEHICLE_IMG);

                        $ext = pathinfo($_FILES['back_photo']['name'], PATHINFO_EXTENSION);
                        $_back_photo = 'back_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['back_photo']['tmp_name'], VEHICLE_IMG . $_back_photo)) {
                            $front_photo = $_back_photo;
                        }
                    }

                    //Left Vehicle Photo
                    if (isset($_FILES['left_photo']) && $_FILES['left_photo']['name'] && $_FILES['left_photo']['error'] == 0) {

                        if (!file_exists(VEHICLE_IMG))
                            mkdir(VEHICLE_IMG);

                        $ext = pathinfo($_FILES['left_photo']['name'], PATHINFO_EXTENSION);
                        $_left_photo = 'left_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['left_photo']['tmp_name'], VEHICLE_IMG . $_left_photo)) {
                            $front_photo = $_left_photo;
                        }
                    }

                    //Right Vehicle Photo
                    if (isset($_FILES['right_photo']) && $_FILES['right_photo']['name'] && $_FILES['right_photo']['error'] == 0) {

                        if (!file_exists(VEHICLE_IMG))
                            mkdir(VEHICLE_IMG);

                        $ext = pathinfo($_FILES['right_photo']['name'], PATHINFO_EXTENSION);
                        $_right_photo = 'right_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['right_photo']['tmp_name'], VEHICLE_IMG . $_right_photo)) {
                            $front_photo = $_right_photo;
                        }
                    }
                    $directory = VEHICLE_IMG;
                }

                if ($document_type == 'Signature') {

                    if (isset($_FILES['front_photo']) && $_FILES['front_photo']['name'] && $_FILES['front_photo']['error'] == 0) {

                        if (!file_exists(SIGNATURE))
                            mkdir(SIGNATURE);

                        $ext = pathinfo($_FILES['front_photo']['name'], PATHINFO_EXTENSION);
                        $_front_photo = 'sign_' . rand(111, 999) . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['front_photo']['tmp_name'], SIGNATURE . $_front_photo)) {
                            $front_photo = $_front_photo;
                        }
                    }
                    $directory = SIGNATURE;
                }

                $data = array();
                if ($front_photo != '') {
                    $data['image'] = $front_photo;
                    $data['image_path'] = base_url() . $directory . $front_photo;
                }

                if ($data) {
                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Documents uploaded successfully!';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Please select file';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function nearby_stations_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $user_data = $this->user_model->getUserById($user_id);
                $owner_id = $user_data && $user_data->owner_id ? $user_data->owner_id : $user_data->user_id;

                if ($stations = $this->api_model->get_nearby_stations($owner_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Nearby stations found';
                    $this->data['data'] = $stations;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Nearby stations not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function cms_pages_post() {

        $cms_page = $this->input->post('cms_page');
        $cms_pages = $this->common_model->getSiteSettingByTitle($cms_page);

        if ($cms_pages != '') {
            $this->data['status'] = 'success';
            $this->data['message'] = 'CMS data fetched successfully!';
            $this->data['data'] = strip_tags($cms_pages);
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'CMS data not found';
        }

        $this->response($this->data, 200);
    }

    public function receive_order_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        //$this->form_validation->set_rules('order_detail_id', 'Order Detail Id', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('quality_of_product', 'Quality of Product', 'trim|required');
        $this->form_validation->set_rules('quantity_of_product', 'Quantity of Product', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id', 'quantity_of_product', 'quantity_of_product');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            //$order_detail_id = trim($this->input->post('order_detail_id'));
            $order_id = trim($this->input->post('order_id'));
            $quality_of_product = trim($this->input->post('quality_of_product'));
            $quantity_of_product = trim($this->input->post('quantity_of_product'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($order = $this->api_model->getOrderById($order_id)) {

                    /* $data = array();
                      $data['quality_of_product'] = $quality_of_product;
                      $data['receive_qty'] = $quantity_of_product;
                      $data['receive_status'] = 1;
                      $data['receive_datetime'] = DATETIME;

                      $this->api_model->updateTable('cart_order_details', 'id', $order_detail_id, $data);

                      $all_product_received = $this->api_model->checkOrderDetails($user_id, $order_detail->id);
                      if ($all_product_received) {
                      $this->api_model->updateTable('cart_orders', 'id', $order_detail->id, array('order_status' => 'Delivered'));
                      } */

                    $data = array();
                    $data['quality_of_product'] = $quality_of_product;
                    $data['receive_qty'] = $quantity_of_product;
                    $data['receive_status'] = 1;
                    $data['status'] = 1;
                    $data['order_status'] = 'Completed';
                    $data['receive_datetime'] = DATETIME;
                    $this->api_model->updateTable('cart_orders', 'id', $order_id, $data);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Order Received Successfully';
                    $this->data['data'] = true;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function make_payment_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        //$this->form_validation->set_rules('is_wallet_used', 'Is Wallet Used', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id', 'amount');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $order_id = trim($this->input->post('order_id'));
            $amount = trim($this->input->post('amount'));
            $is_wallet_used = trim($this->input->post('is_wallet_used'));
            $wallet_amount = trim($this->input->post('wallet_amount'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($is_wallet_used && ($wallet_amount == 0 || $wallet_amount == '')) {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Wallet amount required';
                    $this->response($this->data, 200);
                }

                if ($order_data = $this->api_model->getOrderById($order_id)) {

                    $payment_success = $is_online = 0;

                    //Wallet Payment
                    if ($is_wallet_used) {

                        $data = array();
                        $data['user_id'] = $user_id;
                        $data['order_id'] = $order_id;
                        $data['order_no'] = $order_data->order_id;
                        $data['currency'] = $order_data->currency;
                        $data['station_id'] = $order_data->station_id;
                        $data['amount'] = $wallet_amount;
                        $data['payment_ref_id'] = $this->api_model->generate_auto_id('transaction', 'payment_ref_id');
                        $data['payment_status'] = 'Paid';
                        $data['payment_type'] = 'Purchase';
                        $data['transaction_type'] = 'Wallet';
                        $data['status'] = 1;
                        $data['payment_date'] = DATETIME;
                        $data['created_date'] = DATETIME;
                        if ($payment_id = $this->api_model->addTable('transaction', $data)) {
                            $this->common_model->updateWallet($user_id);
                            $payment_success = 1;

                            if ($cart_data = $this->api_model->getCartData($user_id)) {
                                if (isset($cart_data['cart']) && $cart_data['cart']) {
                                    foreach ($cart_data['cart'] as $cart) {

                                        $this->api_model->deleteTable('carts', 'cart_id', $cart->cart_id);
                                    }
                                }
                            }

                            $payment_data = $this->db->where('order_id', $order_id)->where("transaction_id != $payment_id")->get('transaction')->row();
                            if (!$payment_data) {

                                //Assign new order
                                $pickup_data = array(
                                    'address' => $this->common_model->getSiteSettingByTitle('site_address'),
                                    'contact_no' => $this->common_model->getSiteSettingByTitle('site_contact_no'),
                                    'latitude' => $this->common_model->getSiteSettingByTitle('latitude'),
                                    'longitude' => $this->common_model->getSiteSettingByTitle('longitude')
                                );

                                $station_data = array();
                                if ($stations = $this->api_model->getStationById($order_data->station_id)) {
                                    $station_data = $stations;
                                }

                                $assign_order = array(
                                    'order_id' => $order_id,
                                    'station_id' => $order_data->station_id,
                                    'pickup_data' => json_encode($pickup_data),
                                    'station_data' => json_encode($station_data),
                                    'assign_datetime' => DATETIME
                                );

                                if ($assign_order_id = $this->api_model->addAssignOrder($assign_order)) {

                                    //Add assign order details
                                    $assign_data = array(
                                        'order_id' => $order_id,
                                        'assign_order_id' => $assign_order_id,
                                        'order_status' => 'New',
                                        'date_time' => DATETIME
                                    );
                                    $this->api_model->addAssignOrderDetails($assign_data);
                                }
                                $this->common_model->send_nearby_notification($order_id, 'Transporter');
                            }
                        }
                    }

                    //Online Payment
                    $payment_ref_id = '';
                    if ($amount) {
                        $data = array();
                        $data['user_id'] = $user_id;
                        $data['order_id'] = $order_id;
                        $data['order_no'] = $order_data->order_id;
                        $data['currency'] = $order_data->currency;
                        $data['station_id'] = $order_data->station_id;
                        $data['amount'] = $amount;
                        $data['payment_ref_id'] = $this->api_model->generate_auto_id('transaction', 'payment_ref_id');
                        $data['payment_status'] = 'Pending';
                        $data['payment_type'] = 'Purchase';
                        $data['transaction_type'] = 'Debit';
                        $data['status'] = 1;
                        $data['payment_date'] = DATETIME;
                        $data['created_date'] = DATETIME;
                        if ($payment_id = $this->api_model->addTable('transaction', $data)) {
                            $payment_success = 1;
                            $is_online = $payment_id; //$data['payment_ref_id'];
                            $payment_ref_id = $data['payment_ref_id'];

                            $payment_data = $this->db->where('order_id', $order_id)->where("transaction_id != $payment_id")->get('transaction')->row();
                            if (!$payment_data) {
                                $this->api_model->updateTable('cart_orders', 'id', $order_id, array('is_order' => 0));
                            }
                        }
                    }

                    if ($payment_success) {

                        $result = array();
                        $result['order_id'] = $order_id;
                        $result['order_no'] = $order_data->order_id;
                        //$result['payment_initiate_url'] = $is_online ? base_url('payment/pay/' . $payment_ref_id) : '';
                        $result['payment_ref_id'] = $payment_ref_id;
                        $result['transaction_id'] = $is_online;

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Transaction Added Successfully';
                        $this->data['data'] = $result;
                    } else {

                        //Update cart data 
                        $this->api_model->updateTable('cart_orders', 'id', $order_id, array('is_order' => 0));

                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Transaction Failed';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function track_order_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $order_id = trim($this->input->post('order_id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($orders = $this->api_model->getAssignOrdersDetails($order_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Order data found';
                    $this->data['data'] = $orders;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function add_feedback_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('rating', 'Rating', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'rating');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $rating = trim($this->input->post('rating'));
            $description = trim($this->input->post('description'));
            $quick_feedback = trim($this->input->post('quick_feedback'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $data = array();
                $data['user_id'] = $user_id;
                $data['rating'] = $rating;
                $data['description'] = $description;
                $data['quick_feedback'] = $quick_feedback;
                $data['created_date'] = DATETIME;

                if ($feedback_id = $this->api_model->addTable('feedback', $data)) {

                    //Feedback Notification
                    $this->common_model->send_feedback_notification($feedback_id);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Feedback added successfully';
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Feedback not added';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function add_order_review_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('rating', 'Rating', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id', 'rating');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $order_id = trim($this->input->post('order_id'));
            $rating = trim($this->input->post('rating'));
            $review = trim($this->input->post('review'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($order = $this->api_model->getOrderById($order_id)) {

                    if ($order->rating) {

                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Review already added';
                    } else {

                        $data = array();
                        $data['user_id'] = $user_id;
                        $data['rating'] = $rating;
                        $data['review'] = $review;
                        $data['review_date'] = DATETIME;

                        if ($assign_order = $this->api_model->getAssignOrder($order_id)) {
                            $data['transporter_id'] = $assign_order->transporter_id;
                        }

                        if ($this->api_model->updateTable('cart_orders', 'id', $order_id, $data)) {

                            $this->data['status'] = 'success';
                            $this->data['message'] = 'Review added successfully';
                        } else {
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'Review not added';
                        }
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function add_wallet_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'amount');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $amount = trim($this->input->post('amount'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $user = $this->api_model->getUserById($user_id);
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You are not Owner';
                    $this->response($this->data, 200);
                }

                if ($amount > 0) {

                    //Online Payment
                    $is_online = 0;
                    $payment_ref_id = '';

                    $data = array();
                    $data['user_id'] = $user_id;
                    $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
                    $data['amount'] = $amount;
                    $data['payment_ref_id'] = $this->api_model->generate_auto_id('transaction', 'payment_ref_id');
                    $data['payment_status'] = 'Pending';
                    $data['payment_type'] = 'Wallet';
                    $data['transaction_type'] = 'Credit';
                    $data['status'] = 1;
                    $data['payment_date'] = DATETIME;
                    $data['created_date'] = DATETIME;
                    if ($payment_id = $this->api_model->addTable('transaction', $data)) {
                        $is_online = $payment_id;
                        $payment_ref_id = $data['payment_ref_id'];
                    }

                    if ($is_online) {

                        $order_no = $this->api_model->generate_order_id($is_online, 'W');
                        $this->api_model->updateTable('transaction', 'transaction_id', $is_online, array('order_no' => $order_no));

                        $result = array();
                        $result['payment_initiate_url'] = $is_online ? base_url('payment/pay/' . $payment_ref_id) : '';
                        $result['transaction_id'] = $is_online;

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Money Added Successfully';
                        $this->data['data'] = $result; //$this->common_model->updateWallet($user_id);
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Transaction Failed';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Amount cannot be 0';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function payment_option_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $user = $this->api_model->getUserById($user_id);
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You are not Owner';
                    $this->response($this->data, 200);
                }

                if ($user) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Payment option found';
                    $this->data['data'] = $user->payment_option;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Payment option not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function current_balance_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $user = $this->api_model->getUserById($user_id);
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You are not Owner';
                    $this->response($this->data, 200);
                }

                if ($user->wallet_balance) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Current wallet balance';
                    $this->data['data'] = $user->wallet_balance;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Current wallet balance not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function transaction_list_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $user = $this->api_model->getUserById($user_id);
                if ($user && $user->user_type != 'Owner') {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You are not Owner';
                    $this->response($this->data, 200);
                }

                $page = trim($this->input->post('page'));
                $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';

                $limit = 10;
                if ($transaction_data = $this->api_model->getAllTransactions($user_id, $search, $limit, $page)) {

                    $total_records_count = $this->api_model->getAllTransactions($user_id, $search, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['wallet_balance'] = $user->wallet_balance;
                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $transaction_data;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Transaction list found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Transaction list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function get_notification_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $page = trim($this->input->post('page'));
                $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';

                $limit = 10;
                if ($notification_data = $this->api_model->getAllNotifications($user_id, $search, $limit, $page)) {

                    $total_records_count = $this->api_model->getAllNotifications($user_id, $search, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $notification_data;

                    //$this->api_model->updateNotification(0, array('is_read' => 1), $user_id, 1);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Notification data found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Notification data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function get_notification_details_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('notification_id', 'Notification Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'notification_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $notification_id = $this->input->post('notification_id');
                if ($notification_data = $this->api_model->getNotificationDetails($notification_id)) {

                    $this->api_model->updateNotification($notification_id, array('is_read' => 1));

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Notification details found';
                    $this->data['data'] = $notification_data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Notification details not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function delete_notification_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('notification_id', 'Notification Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'notification_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $notification_id = $this->input->post('notification_id');
                if ($this->api_model->getNotificationDetails($notification_id)) {

                    $this->api_model->deleteNotification($notification_id);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Notification deleted successfully';
                    $this->data['data'] = true;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Notification details not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function delete_all_notification_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $this->api_model->deleteAllNotification($user_id);

                $this->data['status'] = 'success';
                $this->data['message'] = 'Notification deleted successfully';
                $this->data['data'] = true;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function logout_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            //if ($user_id > 0) {

            $this->user_model->updateUser($user_id, array('user_token' => '', 'device_id' => ''));
            $this->data['status'] = 'success';
            $this->data['message'] = 'User Logged out';
            $this->data['data'] = true;
            /* } else {
              $this->data['status'] = 'error';
              $this->data['message'] = 'User not found';
              } */
        }
        $this->response($this->data, 200);
    }

    //help & support api
    function help_support_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);

            if ($user_id > 0) {

                //$page = trim($this->input->post('page'));
                $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';

                //$limit = 10;
                $table = 'help_support';
                $select = 'id, question, answer, display_order';
                $order_key = 'display_order';
                $order_by = 'asc';
                $search_key = array('question');
                $where = array('status' => 1);
                if ($help_support = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Help & support found';
                    $this->data['data'] = $help_support;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Help & support not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    //Advertisement api
    function advertisement_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);

            if ($user_id > 0) {

                $display_advertisement = $this->common_model->getSiteSettingByTitle('display_advertisement');

                if (!$display_advertisement || $display_advertisement != 'None') {

                    $advertisement_type = '';
                    $user = $this->api_model->getUserById($user_id);
                    if ($user && $user->user_type == 'Owner') {
                        if ($display_advertisement == 'Both') {
                            $advertisement_type = 'Owner';
                        } else {
                            $advertisement_type = $user->user_type == $display_advertisement ? $user->user_type : '';
                        }
                    }
                    if ($user && $user->user_type == 'Transporter') {
                        if ($display_advertisement == 'Both') {
                            $advertisement_type = 'Transporter';
                        } else {
                            $advertisement_type = $user->user_type == $display_advertisement ? $user->user_type : '';
                        }
                    }

                    if ($advertisement = $this->api_model->getAllAdvertisements($advertisement_type)) {

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Advertisement found';
                        $this->data['data'] = $advertisement;
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Advertisement not found';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Advertisement feature is disabled';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    //Raised Ticket
    function raised_ticket_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('query_detail', 'Query Detail', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'query_detail');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $query_detail = trim($this->input->post('query_detail'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);

            if ($user_id > 0) {

                $user = $this->api_model->getUserById($user_id);

                $data = array();
                $data['user_id'] = $user_id;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['mobile'] = $user->mobile;
                $data['query_detail'] = $query_detail;
                $data['created_date'] = DATETIME;

                if ($help_id = $this->api_model->addTable('help_ticket', $data)) {

                    $ticket_id = $this->api_model->generate_order_id($help_id, 'TK');
                    $this->api_model->updateTable('help_ticket', 'id', $help_id, array('ticket_id' => $ticket_id));

                    //Help Ticket Notification
                    $this->common_model->send_ticket_notification($help_id);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Your query is sent to admin successfully';
                    $this->data['data'] = $ticket_id;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Your query is not sent';
                    $this->data['data'] = false;
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    //Contact Us
    public function contact_us_get() {

        $setting_data = $this->common_model->getSettings('contact_us');
        if ($setting_data) {

            $contact_website_url = $contact_address = $contact_description = $contact_landline_no = $contact_email = $contact_mobile_no = '';
            foreach ($setting_data as $setting) {
                if ($setting->title == 'contact_website_url') {
                    $contact_website_url = $setting->value;
                }
                if ($setting->title == 'contact_address') {
                    $contact_address = $setting->value;
                }
                if ($setting->title == 'contact_description') {
                    $contact_description = $setting->value;
                }
                if ($setting->title == 'contact_landline_no') {
                    $contact_landline_no = $setting->value;
                }
                if ($setting->title == 'contact_email') {
                    $contact_email = $setting->value;
                }
                if ($setting->title == 'contact_mobile_no') {
                    $contact_mobile_no = $setting->value;
                }
            }

            $contact_us['contact_website_url'] = $contact_website_url;
            $contact_us['contact_address'] = $contact_address;
            $contact_us['contact_description'] = $contact_description;
            $contact_us['contact_landline_no'] = $contact_landline_no;
            $contact_us['contact_email'] = $contact_email;
            $contact_us['contact_mobile_no'] = $contact_mobile_no;

            $this->data['status'] = 'success';
            $this->data['message'] = 'Contact us data found!';
            $this->data['data'] = $contact_us;
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'Contact us data not found';
        }
        $this->response($this->data, 200);
    }

    //Verify Coupon 
    function verify_coupon_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'coupon_code');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $amount = trim($this->input->post('amount'));
            $coupon_code = trim($this->input->post('coupon_code'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);

            if ($user_id > 0) {

                if ($coupon = $this->api_model->getCoupon($coupon_code)) {

                    if ($amount >= $coupon->on_amount) {

                        $start_date = $coupon->start_date;
                        $end_date = $coupon->end_date;
                        $today = date('Y-m-d');

                        if ($start_date <= $today && $end_date >= $today) {

                            $this->data['status'] = 'success';
                            $this->data['message'] = 'Congratulations coupon applied successfully';
                            $this->data['data'] = true;
                        } else {
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'Coupon code does not exist / expired';
                            $this->data['data'] = false;
                        }
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Amount should be greater then or equal to ' . $coupon->on_amount;
                        $this->data['data'] = false;
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Coupon code not found';
                    $this->data['data'] = false;
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    //Approve requested by manager order
    function approve_order_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|required');
        $this->form_validation->set_rules('order_action', 'Order Action', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'order_id', 'payment_type', 'order_action');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $order_id = trim($this->input->post('order_id'));
            $payment_type = trim($this->input->post('payment_type'));
            $order_action = trim($this->input->post('order_action'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);

            if ($user_id > 0) {

                if ($order = $this->api_model->getOrderById($order_id)) {

                    $data = array();
                    $data['payment_type'] = $payment_type;
                    $data['is_approve'] = $order_action;
                    $data['updated_date'] = DATETIME;

                    $transporter_accept_time = $this->common_model->getSiteSettingByTitle('transporter_accept_time');
                    $data['time_left_to_accept'] = date('Y-m-d H:i:s', strtotime("+$transporter_accept_time minutes", strtotime(DATETIME)));

                    $this->api_model->updateTable('cart_orders', 'id', $order_id, $data);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Order successfully updated';
                    $this->data['data'] = array('id' => $order_id, 'order_id' => $order->order_id);
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function app_version_get() {

        if ($app_version = $this->common_model->getSettings('app_version')) {

            $android_app_version = $ios_app_version = '';
            foreach ($app_version as $setting) {
                if ($setting->title == 'android_app_version') {
                    $android_app_version = $setting->value;
                }
                if ($setting->title == 'ios_app_version') {
                    $ios_app_version = $setting->value;
                }
            }
            $this->data['status'] = 'success';
            $this->data['message'] = 'App version found';
            $this->data['data'] = array(
                'android_app_version' => $android_app_version,
                'ios_app_version' => $ios_app_version,
            );
        } else {
            $this->data['status'] = 'error';
            $this->data['message'] = 'App version not found';
        }
        $this->response($this->data, 200);
    }

    public function search_order_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $search = trim($this->input->post('search'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $user_ids = (array) $user_id;
                $user_data = $this->user_model->getUserById($user_id);
                if ($user_data && $user_data->owner_id == 0) {
                    if ($users = $this->api_model->getManagerIds($user_id)) {
                        $manager_ids = explode(',', $users->user_ids);
                        if ($manager_ids) {
                            $user_ids = array_merge($user_ids, $manager_ids);
                        }
                    }
                }
                $user_ids = array_filter($user_ids);

                if ($orders = $this->api_model->getSearchOrders($user_ids, $search)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Order data found';
                    $this->data['data'] = $orders;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function get_vehicle_detail_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('vehicle_id', 'Vehicle Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'vehicle_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $vehicle_id = trim($this->input->post('vehicle_id'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $this->load->model('vehicle_model');
                if ($vehicle = $this->vehicle_model->getVehicleById($vehicle_id)) {

                    $vehicle->vehicle_detail = $this->vehicle_model->getVehicleDetailById($vehicle_id);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Vehicle data found';
                    $this->data['data'] = $vehicle;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Vehicle data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    public function check_service_available_post() {
        $this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('latitude', 'longitude');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $latitude = trim($this->input->post('latitude'));
            $longitude = trim($this->input->post('longitude'));

            $service = $this->common_model->checkServiceAvailable($latitude, $longitude);
            if ($service) {

                $this->data['status'] = 'success';
                $this->data['message'] = 'Service available';
                $this->data['data'] = $service;
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'Service not available';
                $this->data['data'] = $service;
            }
        }
        $this->response($this->data, 200);
    }

    public function generate_bill_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        //$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $order_id = trim($this->input->post('order_id'));
            //$amount = trim($this->input->post('amount'));
            //$is_wallet_used = trim($this->input->post('is_wallet_used'));
            //$wallet_amount = trim($this->input->post('wallet_amount'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($order_data = $this->api_model->getOrderById($order_id)) {

                    $payment_success = $is_online = 0;

                    //Generate Bill
                    $invoice_no = $this->api_model->generate_auto_id('transaction', 'payment_ref_id');

                    $data = array();
                    $data['user_id'] = $user_id;
                    $data['order_id'] = $order_id;
                    $data['order_no'] = $order_data->order_id;
                    $data['currency'] = $order_data->currency;
                    $data['station_id'] = $order_data->station_id;
                    $data['amount'] = $order_data->total_amount;
                    $data['payment_ref_id'] = $invoice_no;
                    $data['payment_status'] = 'Pending';
                    $data['payment_type'] = 'Purchase';
                    $data['transaction_type'] = 'Invoice';
                    $data['status'] = 1;
                    $data['payment_date'] = DATETIME;
                    $data['created_date'] = DATETIME;
                    if ($payment_id = $this->api_model->addTable('transaction', $data)) {
                        $payment_success = 1;
                        $is_online = $payment_id;
                    }

                    if ($payment_success) {

                        $result = array();
                        $result['order_id'] = $order_id;
                        $result['order_no'] = $order_data->order_id;

                        if ($is_online) {

                            $customer_data = array();
                            $customer = $this->user_model->getUserById($user_id);
                            $customer_data['PhoneNumber'] = $customer->mobile;
                            $customer_data['Email'] = $customer->email;
                            $customer_data['Names'] = $customer->name;

                            /*
                            $product_data = array();
                            if ($products = $this->api_model->getOrderDetailById($order_id)) {
                                foreach ($products as $k => $product) {
                                    $product_data[$k]['itemCode'] = $product->category_id;
                                    $product_data[$k]['itemName'] = $product->name;
                                    $product_data[$k]['quantity'] = $product->qty;
                                    $product_data[$k]['unitPrice'] = $product->price;
                                }
                                $k++;
                                $product_data[$k]['itemCode'] = 'SHIPPING';
                                $product_data[$k]['itemName'] = 'Shipping Charge';
                                $product_data[$k]['quantity'] = 1;
                                $product_data[$k]['unitPrice'] = $order_data->shipping_charge;

                                $k++;
                                $product_data[$k]['itemCode'] = 'TAX';
                                $product_data[$k]['itemName'] = 'Tax';
                                $product_data[$k]['quantity'] = 1;
                                $product_data[$k]['unitPrice'] = $order_data->tax;
                            }

                            $partial = $customer->payment_option == 2 ? 'true' : 'false';
                            $bill = $this->api_model->generateBill($customer_data, $product_data, $invoice_no, $partial);
                            */
                            
                            $this->load->model('order_model');
                            $orders = $this->order_model->getOrderById($order_id);
                            $bill = $this->api_model->generateBillKCB($customer_data, $orders);
                            
                            if ($bill && $response = json_decode($bill)) {
                                
                                $receipt_no = '';
                                $data = array();
                                $data['invoice_detail'] = $bill;
                                $data['is_invoice'] = 1;
                                if($response->code == 200){
                                    $receipt_no = $response->response->billRefNo;
                                } 
                                $data['receipt_no'] = $receipt_no;
                                $this->api_model->updateTable('transaction', 'transaction_id', $is_online, $data);

                                $this->api_model->updateTable('cart_orders', 'id', $order_id, array('payment_type' => 'Generate Bill'));

                                //delete cart data
                                if ($cart_data = $this->api_model->getCartData($user_id)) {
                                    if (isset($cart_data['cart']) && $cart_data['cart']) {
                                        foreach ($cart_data['cart'] as $cart) {

                                            $this->api_model->deleteTable('carts', 'cart_id', $cart->cart_id);
                                        }
                                    }
                                }

                                $message = "Dear " . $customer->name . ",<br/><br/>";
                                $message .= "Invoice generated from " . PROJECT_NAME . ", Order Number " . $order_data->order_id . "<br/><br/>";

                                $email_id = $customer->email;
                                $subject = 'Invoice';

                                //$this->load->model('order_model');
                                //$rdata['order_data'] = $this->order_model->getOrderById($order_id);
                                $rdata['order_data'] = $orders;
                                $address_data = array();
                                /* if ($assign_order = $this->order_model->getAssignOrder($order_id)) {
                                  $address_data['billing_info'] = $assign_order->pickup_data ? json_decode($assign_order->pickup_data) : array();
                                  $address_data['shipping_info'] = $assign_order->station_data ? json_decode($assign_order->station_data) : array();
                                  } */

                                $address_data['billing_info'] = (object) array(
                                            'address' => $this->common_model->getSiteSettingByTitle('site_address'),
                                            'contact_no' => $this->common_model->getSiteSettingByTitle('site_contact_no'),
                                            'latitude' => $this->common_model->getSiteSettingByTitle('latitude'),
                                            'longitude' => $this->common_model->getSiteSettingByTitle('longitude')
                                );

                                $address_data['shipping_info'] = array();
                                if ($stations = $this->order_model->getStationById($order_data->station_id)) {
                                    $address_data['shipping_info'] = $stations;
                                }
                                $rdata['address_data'] = $address_data;

                                /*$invoice_detail = array();
                                $transaction = $this->order_model->getPaymentDetails($order_id);
                                if (isset($transaction[0]->invoice_detail) && $transaction[0]->invoice_detail) {
                                    $invoice_detail = json_decode($transaction[0]->invoice_detail);
                                }*/
                                
                                $invoice_detail = $this->db->where('cart_order_id', $order_id)->get('cart_order_details')->result();
                                $rdata['invoice_detail'] = $invoice_detail;
                                
                                $rdata['transaction'] = $this->api_model->getTableById('transaction', 'transaction_id', $is_online);
                                $message .= $this->load->view('admin/orders/print_invoice_pdf', $rdata, true);

                                $this->common_model->send_mail($message, $email_id, $subject);
                            }
                        }
                        
                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Transaction Added Successfully';
                        $this->data['data'] = $result;
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Transaction Failed';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function scheduled_order_list_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('is_scheduled', 'Is Scheduled', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'is_scheduled');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $is_scheduled = trim($this->input->post('is_scheduled'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                $page = trim($this->input->post('page'));
                $limit = 10;
                if ($orders = $this->api_model->transporterScheduledOrders($user_id, $is_scheduled, $limit, $page)) {

                    $total_records_count = $this->api_model->transporterScheduledOrders($user_id, $is_scheduled, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $orders;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Orders list found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Orders list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // transporter my availability
    public function my_availability_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'available');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $today = date('Y-m-d');
                $page = trim($this->input->post('page'));
                $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : '';

                $limit = 10;
                $table = 'transporter_not_available';
                $select = 'id, set_date';
                $order_key = 'set_date';
                $order_by = 'ASC';
                $search_key = array();
                $where = ['user_id' => $user_id, 'set_date >= ' => $today];
                if ($users = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search, $limit, $page)) {

                    $total_records_count = $this->api_model->getTablePagination($table, $select, $order_key, $order_by, $where, $search_key, $search, $limit, $page, 1);
                    $pages_count = (int) ceil(($total_records_count / $limit));

                    $data['pages_count'] = $pages_count;
                    $data['total_records_count'] = $total_records_count;
                    $data['result'] = $users;

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Transporter not availability data found';
                    $this->data['data'] = $data;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Transporter not availability data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // delete transporter availability
    public function delete_transporter_available_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('id', 'Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $user_token = trim($this->input->post('user_token'));
            $id = trim($this->input->post('id'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                if ($id) {
                    $this->db->where('user_id', $user_id);
                    $this->db->where('id', $id);
                    $transporter_not_available = $this->db->get('transporter_not_available')->row();
                    if ($transporter_not_available) {

                        $this->api_model->deleteTable('transporter_not_available', 'id', $transporter_not_available->id);
                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Data deleted successfully';
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Data not found';
                    }
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    //Reorder
    public function reorder_post() {

        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $form_data = array('user_token', 'order_id');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $order_id = trim($this->input->post('order_id'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id) {

                $cart_data = $this->api_model->getCartData($user_id);
                if ($cart_data && empty($cart_data['cart'])) {

                    if ($cart_detail = $this->db->get_where('cart_order_details', ['cart_order_id' => $order_id])->result()) {

                        foreach ($cart_detail as $value) {

                            if ($category = $this->api_model->getCategoryPrice($value->category_id)) {

                                $data = array();
                                $data['user_id'] = $user_id;
                                $data['category_id'] = $value->category_id;
                                $data['qty'] = $value->qty;
                                $data['name'] = $category->name;
                                $data['type'] = $category->type;
                                $data['image'] = $category->image;
                                $data['measurement'] = $category->measurement;
                                $data['currency'] = $category->currency;
                                $data['price'] = $category->price;
                                $data['total_price'] = round($value->qty * $category->price, 2);
                                $data['created_date'] = DATETIME;

                                $this->api_model->addTable('carts', $data);
                            }
                        }

                        $this->data['status'] = 'success';
                        $this->data['message'] = 'Reorder Successed';
                    } else {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Order data not found';
                    }
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Cart is not empty, please clear the cart';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function today_order_list_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_status');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($orders = $this->api_model->todayTransporterOrders($user_id)) {

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Today order list found';
                    $this->data['data'] = $orders;
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Today order list not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }

    function generate_login_id() {
        $id = generateRandomString(8);
        if ($this->db->get_where('user', ['login_id' => $id])->num_rows() == 0) {
            return $id;
        } else {
            return $this->generate_login_id();
        }
    }

    public function social_login_post() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('auth_id', 'Auth Id', 'trim|required');
        $this->form_validation->set_rules('auth_provider', 'Auth Provider', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $form_data = array('name', 'email', 'auth_id', 'auth_provider');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {

            $name = trim($this->input->post('name'));
            $email = trim($this->input->post('email'));
            $auth_id = trim($this->input->post('auth_id'));
            $auth_provider = trim($this->input->post('auth_provider'));
            $photourl = trim($this->input->post('photourl'));
            $device_id = trim($this->input->post('device_id'));
            $platform_type = trim($this->input->post('platform_type'));

            $data = array();
            $data['email'] = $email;
            $data['auth_id'] = $auth_id;
            $check_login = $this->api_model->checkSocialLogin($data, $auth_provider);
            if ($check_login) {

                $mobile_verify = $this->api_model->checkVerifyMobile($check_login->user_id);
                if (!$mobile_verify) {

                    $token = generateRandomString();
                    $this->user_model->updateUser($check_login->user_id, array('forgot_token' => $token));

                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Mobile number missing';
                    $this->data['data'] = array('mobile_verified' => 0, 'token' => $token);
                    $this->response($this->data, 200);
                }

                if ($check_login->status) {

                    $user_token = generateRandomString();
                    $update_data = array();
                    $update_data['device_id'] = $device_id;
                    $update_data['platform_type'] = $platform_type;
                    $update_data['user_token'] = $user_token;
                    $update_data['auth_provider'] = $auth_provider;
                    $this->user_model->updateUser($check_login->user_id, $update_data);

                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Login successfully';
                    $this->data['data'] = $this->api_model->getUserById($check_login->user_id, 1);
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'You are inactive . Please contact admin';
                }
            } else {

                $token = generateRandomString();

                $data = array();
                $data['login_id'] = $this->generate_login_id();
                $data['name'] = $name;
                $data['email'] = $email;
                $data['device_id'] = $device_id;
                $data['platform_type'] = $platform_type;
                $data['forgot_token'] = $token;
                if ($auth_provider == 'Google') {
                    $data['google_auth_id'] = $auth_id;
                }
                if ($auth_provider == 'Facebbok') {
                    $data['facebook_auth_id'] = $auth_id;
                }
                $data['auth_provider'] = $auth_provider;

                //upload photo
                if ($photourl != '' && $photo = file_get_contents($photourl)) {
                    $profile_pic = 'pic_' . rand(111, 999) . time() . '.jpg';

                    $file_path = PROFILEPIC . $profile_pic;
                    file_put_contents($file_path, $photo);
                    $data['profile_pic'] = $profile_pic;
                }

                $data['user_type'] = 'Owner';
                $data['payment_option'] = 1;
                $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
                $data['created_date'] = DATETIME;

                $this->user_model->addUser($data);

                $this->data['status'] = 'error';
                $this->data['message'] = 'Mobile number missing';
                $this->data['data'] = array('mobile_verified' => 0, 'token' => $token);
            }
        }
        $this->response($this->data, 200);
    }

    // for transporter
    public function add_fuel_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
        $this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
        $this->form_validation->set_rules('compartment_data', 'Compartment Data', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token', 'order_id', 'product_id', 'compartment_data');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            $order_id = trim($this->input->post('order_id'));
            $product_id = trim($this->input->post('product_id'));
            $compartment_data = trim($this->input->post('compartment_data'));
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {

                if ($orders = $this->api_model->getAssignOrder($order_id)) {

                    $order_data = $this->api_model->getTableById('cart_orders', 'id', $order_id, 0);
                    if ($order_data && $order_data->order_status == 'Cancelled') {
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Order is cancelled by admin';
                        $this->response($this->data, 200);
                    }
                    
                    $capacity = 0;
                    if ($card_detail = $this->db->select('SUM(qty) as total_qty')->where('cart_order_id', $order_id)->get('cart_order_details')->row()) {
                        $capacity = $card_detail->total_qty;
                    }

                    $vehicle = $this->api_model->getTableById('vehicle', 'user_id', $user_id);
                    if($vehicle && $vehicle->vehicle_capacity >= $capacity){
                                                
                        if($compartment_data && $compartment_details = json_decode($compartment_data)){
                            
                            $product = $this->db->where('cart_order_id', $order_id)->where('category_id', $product_id)->get('cart_order_details')->row();
                            
                            if($product && $product->qty){
                                
                                $compartment_values = $compartments = array();
                                
                                $this->db->where('is_order', 1);
                                $this->db->where("order_status IN('Assigned','Accepted','Processing')");
                                $this->db->where('transporter_id', $user_id);
                                $this->db->where('delivery_date', $order_data->delivery_date);
                                $orders_data = $this->db->get('cart_orders')->result();
                                
                                if($orders_data){
                                    foreach ($orders_data as $row) { 
                                        if($products = $this->db->where('cart_order_id', $row->id)->get('cart_order_details')->result()){
                                            foreach ($products as $item) {
                                                if($item->compartment_data){
                                                    $compartment_values[] = json_decode($item->compartment_data);
                                                }
                                            }
                                            if($compartment_values){
                                                foreach ($compartment_values as $values) {
                                                    if($values){
                                                        foreach ($values as $value) {
                                                            $compartments[] = $value->compartment_no;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                //echo '<pre>';print_r($compartments);die;
                                $product_qty = $exist_compartment = 0;
                                foreach ($compartment_details as $compartment_no) {

                                    if(!in_array($compartment_no, $compartments)){
                                    
                                        $this->db->where('vehicle_id', $vehicle->vehicle_id);
                                        $this->db->where('compartment_no', $compartment_no);
                                        $compartment = $this->db->get('vehicle_detail')->row();
                                        $product_qty += $compartment->compartment_capacity;
                                    }else{
                                        $exist_compartment = 1;
                                    }
                                }
                                //print_r($exist_compartment);die;
                                if($exist_compartment || $product_qty == 0 || $product_qty < $product->qty){
                                    $this->data['status'] = 'error';
                                    $this->data['message'] = 'Your selected compartment filled with some order, please check it.';
                                    $this->response($this->data, 200);
                                }

                                $compartment_json = array();
                                foreach ($compartment_details as $compartment_no) {
                                    
                                    $this->db->where('vehicle_id', $vehicle->vehicle_id);
                                    $this->db->where('compartment_no', $compartment_no);
                                    $compartment = $this->db->get('vehicle_detail')->row();
                                    if($compartment){
                                        
                                        $compartment_detail = array();
                                        $compartment_detail['compartment_no'] = $compartment->compartment_no;
                                        $compartment_detail['compartment_capacity'] = $compartment->compartment_capacity;
                                        $compartment_json[] = $compartment_detail;
                                    }
                                }
                                
                                if($compartment_json){
                                    
                                    $this->db->where('cart_order_id', $order_id);
                                    $this->db->where('category_id', $product_id);
                                    $this->db->update('cart_order_details', array('compartment_data' => json_encode($compartment_json)));

                                    $this->data['status'] = 'success';
                                    $this->data['message'] = 'Fuel added successfully';
                                    $this->data['data'] = true;
                                }else{
                                    
                                    $this->data['status'] = 'error';
                                    $this->data['message'] = 'Fuel not added';
                                    $this->response($this->data, 200);
                                }
                                
                            }else{
                                $this->data['status'] = 'error';
                                $this->data['message'] = 'Product not found';
                                $this->response($this->data, 200);
                            }
                            
                        }else{
                            
                            $this->data['status'] = 'error';
                            $this->data['message'] = 'Compartment data not found';
                            $this->response($this->data, 200);
                        }
                        
                    }else{
                        
                        $this->data['status'] = 'error';
                        $this->data['message'] = 'Vehicle capacity is less for this order';
                        $this->response($this->data, 200);
                    }
                    
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Order data not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }
    
    function get_vehicle_post() {
        $this->form_validation->set_rules('user_token', 'User Token', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $form_data = array('user_token');
            $error_messages = $this->common_model->form_validation_message($form_data);
            $this->data['status'] = 'error';
            $this->data['message'] = $error_messages;
        } else {
            
            $user_token = trim($this->input->post('user_token'));
            $user_id = $this->check_user_token($user_token);
            if ($user_id > 0) {
                
                if($vehicle = $this->db->get_where('vehicle', ['user_id' => $user_id])->row()){
                    
                    $this->db->select('compartment_no, compartment_capacity');
                    $this->db->where('vehicle_id', $vehicle->vehicle_id);
                    $vehicle_details = $this->db->get('vehicle_detail')->result();
                    
                    $this->data['status'] = 'success';
                    $this->data['message'] = 'Vehicle details found';
                    $this->data['data'] = $vehicle_details;
                    
                } else {
                    $this->data['status'] = 'error';
                    $this->data['message'] = 'Vehicle details not found';
                }
            } else {
                $this->data['status'] = 'error';
                $this->data['message'] = 'User not found';
            }
        }
        $this->response($this->data, 200);
    }
}
