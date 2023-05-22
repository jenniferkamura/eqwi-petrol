<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    private $privilege_error;
    private $admin_id;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Settings';
        $this->load->model('setting_model');

        $this->admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';
    }

    public function sms_setting() {

        $this->data['title'] = 'SMS Setting';
        $this->data['page'] = "SMS Gateway";
        $this->data['view'] = 'admin/setting/sms_setting';
        $option_type = 'sms';
        if ($this->input->post()) {
            $sms_url = trim($this->input->post('url'));
            $api_key = trim($this->input->post('api_key'));
            $sender_id = trim($this->input->post('sender_id'));

            $data[] = array('option_type' => $option_type, 'title' => 'sms_url', 'value' => $sms_url, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'api_key', 'value' => $api_key, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'sender_id', 'value' => $sender_id, 'updated_date' => DATETIME);
            $this->setting_model->updateSetting($option_type, $data);
            $this->session->set_flashdata('success', "SMS setting updated successfully!");
            redirect("admin/setting/sms_setting");
        }
        $this->data['setting_data'] = $this->setting_model->getSettings($option_type);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function site_setting() {

        $this->data['title'] = 'Site Setting';
        $this->data['page'] = "Site Setting";
        $this->data['view'] = 'admin/setting/site_setting';
        if ($this->input->post()) {

            //Site Setting
            $option_type = 'site_setting';
            if ($this->input->post('site_setting') == 'Submit') {

                if (isset($_FILES['site_logo']) && $_FILES['site_logo']['name'] != '' && $_FILES['site_logo']['error'] == 0) {

                    if (!file_exists(SITE_LOGO))
                        mkdir(SITE_LOGO);

                    $ext = pathinfo($_FILES['site_logo']['name'], PATHINFO_EXTENSION);
                    $logo = 'logo_' . rand(111, 999) . time() . '.' . $ext;

                    if (move_uploaded_file($_FILES['site_logo']['tmp_name'], SITE_LOGO . $logo)) {
                        $data[] = array('option_type' => $option_type, 'title' => 'site_logo', 'value' => $logo, 'updated_date' => DATETIME);
                    }
                }

                $google_map_api_key = trim($this->input->post('google_map_api_key'));
                $currency_code = trim($this->input->post('currency_code'));
                $currency_symbol = trim($this->input->post('currency_symbol'));
                $push_notification_key = trim($this->input->post('push_notification_key'));
                $shipping_charge = trim($this->input->post('shipping_charge'));
                $tax = trim($this->input->post('tax'));
                $site_address = trim($this->input->post('site_address'));
                $site_contact_no = trim($this->input->post('site_contact_no'));
                $latitude = trim($this->input->post('latitude'));
                $longitude = trim($this->input->post('longitude'));
                $nearby_pickup_radius = trim($this->input->post('nearby_pickup_radius'));
                $transporter_accept_time = trim($this->input->post('transporter_accept_time'));
                $service_available_radius = trim($this->input->post('service_available_radius'));
                $display_advertisement = trim($this->input->post('display_advertisement'));
                $invoice_amount = trim($this->input->post('invoice_amount'));

                if (DEVELOPER_OPTIONS && ALLOW_GOOGLE_MAPS) {
                    $data[] = array('option_type' => $option_type, 'title' => 'google_map_api_key', 'value' => $google_map_api_key, 'updated_date' => DATETIME);
                }
                $data[] = array('option_type' => $option_type, 'title' => 'currency_code', 'value' => $currency_code, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'currency_symbol', 'value' => $currency_symbol, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'shipping_charge', 'value' => $shipping_charge, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'tax', 'value' => $tax, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'site_address', 'value' => $site_address, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'site_contact_no', 'value' => $site_contact_no, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'latitude', 'value' => $latitude, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'longitude', 'value' => $longitude, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'nearby_pickup_radius', 'value' => $nearby_pickup_radius, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'transporter_accept_time', 'value' => $transporter_accept_time, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'service_available_radius', 'value' => $service_available_radius, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'display_advertisement', 'value' => $display_advertisement, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'invoice_amount', 'value' => $invoice_amount, 'updated_date' => DATETIME);

                if (DEVELOPER_OPTIONS) {
                    $data[] = array('option_type' => $option_type, 'title' => 'push_notification_key', 'value' => $push_notification_key, 'updated_date' => DATETIME);
                }
                $this->setting_model->updateSetting($option_type, $data);
                $this->session->set_flashdata('success', "Site setting updated successfully!");
            }
            redirect("admin/setting/site_setting");
        }
        $this->data['setting_data'] = $this->setting_model->getSettings('site_setting');
        $this->load->view('admin/admin_master', $this->data);
    }

    public function cms_pages() {

        $this->data['title'] = 'CMS Pages';
        $this->data['view'] = 'admin/setting/cms_pages';

        $option_type = 'cms_pages';
        if ($this->input->post()) {

            $about_body = trim($this->input->post('about_body'));
            $terms_body = trim($this->input->post('terms_body'));
            $privacy_policy = trim($this->input->post('privacy_policy'));

            $data[] = array('option_type' => $option_type, 'title' => 'about_body', 'value' => $about_body, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'terms_body', 'value' => $terms_body, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'privacy_policy', 'value' => $privacy_policy, 'updated_date' => DATETIME);
            $this->setting_model->updateSetting($option_type, $data);
            $this->session->set_flashdata('success', "Cms pages updated successfully!");
            redirect('admin/setting/cms_pages');
        }

        $this->data['setting_data'] = $this->setting_model->getSettings($option_type);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function contact_us() {

        $this->data['title'] = 'Contact Us';
        $this->data['page'] = "Contact Us";
        $this->data['view'] = 'admin/setting/contact_us';
        if ($this->input->post()) {

            //Site Setting
            $option_type = 'contact_us';
            if ($this->input->post('site_setting') == 'Submit') {

                $contact_website_url = trim($this->input->post('contact_website_url'));
                $contact_address = trim($this->input->post('contact_address'));
                $contact_description = trim($this->input->post('contact_description'));
                $contact_landline_no = trim($this->input->post('contact_landline_no'));
                $contact_email = trim($this->input->post('contact_email'));
                $contact_mobile_no = trim($this->input->post('contact_mobile_no'));

                $data[] = array('option_type' => $option_type, 'title' => 'contact_website_url', 'value' => $contact_website_url, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'contact_address', 'value' => $contact_address, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'contact_description', 'value' => $contact_description, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'contact_landline_no', 'value' => $contact_landline_no, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'contact_email', 'value' => $contact_email, 'updated_date' => DATETIME);
                $data[] = array('option_type' => $option_type, 'title' => 'contact_mobile_no', 'value' => $contact_mobile_no, 'updated_date' => DATETIME);
                $this->setting_model->updateSetting($option_type, $data);
                $this->session->set_flashdata('success', "Conatct us setting updated successfully!");
            }
            redirect("admin/setting/contact_us");
        }
        $this->data['setting_data'] = $this->setting_model->getSettings('contact_us');
        $this->load->view('admin/admin_master', $this->data);
    }

    public function push_notification() {

        $this->data['title'] = 'Send Push Notification';
        $this->data['page'] = "Send Push Notification";
        $this->data['view'] = 'admin/setting/push_notification';

        $this->load->model('user_model');
        if ($this->input->post()) {

            $push_notification_key = $this->common_model->getSiteSettingByTitle('push_notification_key');
            if ($push_notification_key != '') {

                $title = $this->input->post("title");
                $owners = $this->input->post("owners") ? $this->input->post("owners") : array();
                $managers = $this->input->post("managers") ? $this->input->post("managers") : array();
                $attendants = $this->input->post("attendants") ? $this->input->post("attendants") : array();
                $transporters = $this->input->post("transporters") ? $this->input->post("transporters") : array();
                $message = $this->input->post("message");

                $user_ids = array_merge($owners, $managers, $attendants, $transporters);

                if ($user_ids) {
                    $this->db->where('user_id  IN(' . implode(',', $user_ids) . ')');
                    $this->db->distinct();
                    $this->db->select("device_id, user_id");
                    $this->db->where("(device_id IS NOT NULL AND device_id != '')");
                    $this->db->where('status', '1');
                    $devices = $this->db->get('user')->result();

                    $send_notification = 0;
                    $notification_data = array();
                    $a_ids = [];
                    foreach ($devices as $item) {
                        //$a_ids[] = $item->device_id;

                        $notification_arr = array();
                        $notification_arr['user_id'] = $item->user_id;
                        $notification_arr['title'] = $title;
                        $notification_arr['message'] = $message;
                        $notification_arr['date_time'] = DATETIME;
                        $notification_arr['is_admin'] = $this->admin_id;
                        $notification_arr['is_custom'] = 1;
                        $notification_data[] = $notification_arr;

                        $data = array(
                            //"to" => implode(',', $a_ids),
                            "to" => $item->device_id,
                            "notification" => array(
                                "title" => $title,
                                "body" => $message,
                                'image' => SITE_LOGO,
                                'sound' => 'notification_sound',
                                'vibrate' => 1
                            ),
                            "data" => [
                                "title" => $title,
                                "message" => $message,
                                "order_id" => "",
                            ]
                        );

                        $send_notification = $this->common_model->send_push_notification($data);
                    }
                    if ($send_notification) {
                        $this->setting_model->insertPushNotification($notification_data);
                        $this->session->set_flashdata('success', "Push notification send successfully!");
                    } else {
                        $this->session->set_flashdata("error", "Unable to Send Push Notifications");
                    }
                } else {
                    $this->session->set_flashdata("error", "Please select atleast one user");
                }
            } else {
                $this->session->set_flashdata("error", "Push Notification Server Key Not Set");
            }
            redirect("admin/setting/push_notification");
        }
        $this->data['owner_data'] = $this->user_model->getAllUser('Owner', 1);
        $this->data['manager_data'] = $this->user_model->getAllUser('Manager', 1);
        $this->data['attendant_data'] = $this->user_model->getAllUser('Attendant', 1);
        $this->data['transporter_data'] = $this->user_model->getAllUser('Transporter', 1);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function payment_gateway_setting() {
        $this->data['title'] = 'Payment Gateway Setting';
        $this->data['page'] = "Payment Gateway Setting";
        $this->data['view'] = 'admin/setting/payment_gateway_setting';

        $option_type = 'payment_gateway_setting';
        if ($this->input->post()) {
            $test_pg_url = trim($this->input->post('test_pg_url'));
            $live_pg_url = trim($this->input->post('live_pg_url'));
            $client_email = trim($this->input->post('client_email'));
            $pg_client_key = trim($this->input->post('pg_client_key'));
            $pg_checksum_key = trim($this->input->post('pg_checksum_key'));

            $data[] = array('option_type' => $option_type, 'title' => 'test_pg_url', 'value' => $test_pg_url, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'live_pg_url', 'value' => $live_pg_url, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'client_email', 'value' => $client_email, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'pg_client_key', 'value' => $pg_client_key, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'pg_checksum_key', 'value' => $pg_checksum_key, 'updated_date' => DATETIME);
            $this->setting_model->updateSetting($option_type, $data);
            $this->session->set_flashdata('success', "Payment gateway updated successfully!");
            redirect("admin/setting/payment_gateway_setting");
        }
        $this->data['setting_data'] = $this->setting_model->getSettings($option_type);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function email_setting() {

        $this->data['title'] = 'Email Setting';
        $this->data['page'] = "Email Setting";
        $this->data['view'] = 'admin/setting/email_setting';
        $option_type = 'email_setting';
        if ($this->input->post()) {

            $smtp_host = trim($this->input->post('smtp_host'));
            $smtp_user = trim($this->input->post('smtp_user'));
            $smtp_password = trim($this->input->post('smtp_password'));
            $smtp_port = trim($this->input->post('smtp_port'));

            $data[] = array('option_type' => $option_type, 'title' => 'smtp_host', 'value' => $smtp_host, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'smtp_user', 'value' => $smtp_user, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'smtp_password', 'value' => $smtp_password, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'smtp_port', 'value' => $smtp_port, 'updated_date' => DATETIME);
            $this->setting_model->updateSetting($option_type, $data);

            $this->session->set_flashdata('success', "Email setting updated successfully!");
            redirect("admin/setting/email_setting");
        }
        $this->data['setting_data'] = $this->setting_model->getSettings($option_type);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function reject_reason() {

        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/setting/reject_reason");
        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Reject Reason';
        $this->data['view'] = 'admin/setting/reject_reason/index';
        $this->data['reject_reason_data'] = $this->setting_model->getAllRejectReason();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function reject_reason_edit($id) {

        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/setting/reject_reason");
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Reject Reason';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/setting/reject_reason/edit';

        if ($this->input->post()) {

            $reject_reason_id = trim($this->input->post('reject_reason_id'));

            $this->form_validation->set_rules("title", "Title", "required", array('required' => 'Title cannot be empty'));
            if ($this->form_validation->run() == FALSE) {

                $form_data = array('title');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/setting/reject_reason");
            }

            $title = trim($this->input->post('title'));
            $display_order = trim($this->input->post('display_order'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['title'] = $title;
            $data['display_order'] = $display_order;
            $data['status'] = $status;

            if ($reject_reason_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->setting_model->updateRejectReason($reject_reason_id, $data);
                $this->session->set_flashdata('success', "Reject reason updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $this->setting_model->addRejectReason($data);
                $this->session->set_flashdata('success', "Reject reason added successfully!");
            }
            redirect("admin/setting/reject_reason");
        }

        $this->data['reject_reason_data'] = $this->setting_model->getRejectReasonById($id, 0);
        $this->data['last_order'] = $this->common_model->getLastDisplayOrder('reject_reason');
        $this->data['reject_reason_id'] = isset($this->data['reject_reason_data']) && $this->data['reject_reason_data']->id ? $this->data['reject_reason_data']->id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }

    public function reject_reason_delete($id) {

        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/setting/reject_reason");
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->setting_model->deleteRejectReason($id);
            $this->session->set_flashdata('success', 'Reject reason deleted successfully!');
        }
        redirect("admin/setting/reject_reason");
    }

    public function app_version() {

        $this->data['title'] = 'App Version';
        $this->data['page'] = "App Version";
        $this->data['view'] = 'admin/setting/app_version';

        $option_type = 'app_version';
        if ($this->input->post()) {
            $android_app_version = trim($this->input->post('android_app_version'));
            $ios_app_version = trim($this->input->post('ios_app_version'));

            $data[] = array('option_type' => $option_type, 'title' => 'android_app_version', 'value' => $android_app_version, 'updated_date' => DATETIME);
            $data[] = array('option_type' => $option_type, 'title' => 'ios_app_version', 'value' => $ios_app_version, 'updated_date' => DATETIME);

            $this->setting_model->updateSetting($option_type, $data);
            $this->session->set_flashdata('success', "App version updated successfully!");
            redirect("admin/setting/app_version");
        }
        $this->data['setting_data'] = $this->setting_model->getSettings($option_type);
        $this->load->view('admin/admin_master', $this->data);
    }

}
