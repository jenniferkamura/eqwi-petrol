<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Orders';
        $this->load->model('order_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/orders/status");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function status($status = 'New') {
        $this->data['view'] = 'admin/orders/index';

        $search = array();
        $order_id = $from_date = $to_date = '';
        if ($this->input->get()) {

            $this->data['order_id'] = $order_id = $this->input->get('order_id');
            $this->data['from_date'] = $_from_date = $this->input->get('from_date');
            $this->data['to_date'] = $_to_date = $this->input->get('to_date');

            if ($order_id) {
                $search['order_id'] = $order_id;
            }

            if ($_from_date) {
                $old_from_date = explode('/', $_from_date);
                $from_date = (isset($old_from_date[2]) ? $old_from_date[2] : date('Y')) . '-' . $old_from_date[1] . '-' . $old_from_date[0];
                $search['from_date'] = $_from_date;
            }
            if ($_to_date) {
                $old_to_date = explode('/', $_to_date);
                $to_date = (isset($old_to_date[2]) ? $old_to_date[2] : date('Y')) . '-' . $old_to_date[1] . '-' . $old_to_date[0];
                $search['to_date'] = $_to_date;
            }
        }

        $base_url = base_url('admin/orders/status/' . $status) . '?' . http_build_query($search);

        $total_rows = $this->order_model->getAllOrder($status, $order_id, $from_date, $to_date);

        // page
        $config = $this->common_model->pagination();
        $config["base_url"] = $base_url;
        $config["total_rows"] = count($total_rows);
        $config["per_page"] = 15;
        $config["uri_segment"] = 3;
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $this->data['last_row_num'] = $this->uri->segment(3);
        $page = ($this->input->get('per_page') != "" || $this->input->get('per_page') != NULL) ? $this->input->get('per_page') : 0; //($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->data["order_data"] = $this->order_model->getAllOrder($status, $order_id, $from_date, $to_date, $config["per_page"], $page);
        $this->data["links"] = $this->pagination->create_links();
        $this->data['total_rows'] = $config["total_rows"];

        $this->data['order_status'] = $status;
        $this->data['order_new'] = $this->order_model->getOrderCounts('New');
        $this->data['order_pending'] = $this->order_model->getOrderCounts('Pending');
        $this->data['order_assigned'] = $this->order_model->getOrderCounts('Assigned');
        $this->data['order_accepted'] = $this->order_model->getOrderCounts('Accepted');
        $this->data['order_processing'] = $this->order_model->getOrderCounts('Processing');
        $this->data['order_delivered'] = $this->order_model->getOrderCounts('Delivered');
        $this->data['order_rejected'] = $this->order_model->getOrderCounts('Rejected');
        $this->data['order_cancelled'] = $this->order_model->getOrderCounts('Cancelled');
        $this->data['order_completed'] = $this->order_model->getOrderCounts('Completed');
        $this->load->view('admin/admin_master', $this->data);
    }

    public function view() {
        $id = $this->input->post('id');
        $this->data['action_status'] = $this->input->post('order_status');

        $this->data['transporter_data'] = $this->order_model->getAllTransporter();
        $this->data['order_data'] = $this->order_model->getOrderById($id);
        $this->data['order_detail'] = $this->order_model->getOrderDetailById($id);
        $this->data['assign_order'] = $this->order_model->getAssignOrder($id);
        $this->data['assign_order_details'] = $this->order_model->getAssignOrderDetails($id);
        $this->data['payment_details'] = $this->order_model->getPaymentDetails($id);
        $this->data['remaining_payment'] = $this->order_model->checkPaidTransactionAmount($id);
        $this->data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');

        $is_invoice = 0;
        if (isset($this->data['payment_details'][0]->is_invoice) && $this->data['payment_details'][0]->is_invoice) {
            $is_invoice = $this->data['payment_details'][0]->is_invoice;
        }
        $this->data['is_invoice'] = $is_invoice;

        $view = $this->load->view('admin/orders/view', $this->data, true);
        echo json_encode(array('status' => true, 'view' => $view));
        exit;
    }

    /* public function check_transporter_exists() {

      $success = 'false';
      $email_id = trim($this->input->post('email_id'));

      if($user = $this->db->get_where('user', ['email' => $email_id, 'status' => 1, 'user_type' => 'Transporter'])->row()){
      $success = 'true';
      }
      echo $success;
      } */

    public function assign_order() {
        $status = 0;
        if ($this->input->post()) {
            $assign_order_id = trim($this->input->post('assign_order_id'));
            $order_id = trim($this->input->post('order_id'));
            //$transporter_list = trim($this->input->post('transporter_list'));
            $transporter_id = trim($this->input->post('transporter_name'));
            //$email_id = trim($this->input->post('email_id'));
            $station_id = trim($this->input->post('station_id'));

            //$transporter = $this->common_model->getUserById($transporter_id);
            //$check_availability = $transporter && $transporter->transporter_available ? 1 : 0;

            $order_data = $this->order_model->getOrderById($order_id);
            $check_availability = $this->common_model->getTransporterAvailability($transporter_id, $order_data->delivery_date);

            if ($check_availability == 0) {
                $this->session->set_flashdata('error', 'Transporter not available');
                echo json_encode(array('status' => $status));
                exit;
            }

            $no_vehicle = 1;
            $this->db->where('user_id', $transporter_id);
            $vehicle = $this->db->get('vehicle')->row();

            if ($vehicle && $vehicle->status) {
                $no_vehicle = 0;
            }

            if ($no_vehicle) {
                $this->session->set_flashdata('error', 'Vehicle status is inactive or not found');
                echo json_encode(array('status' => $status));
                exit;
            }

            if ($card_detail = $this->db->select('SUM(qty) as total_qty')->where('cart_order_id', $order_id)->get('cart_order_details')->row()) {
                $capacity = $card_detail->total_qty;

                $this->db->where('u.user_id', $transporter_id);
                $this->db->where('u.status', '1');
                $this->db->where('u.user_type', 'Transporter');
                $this->db->where("u.vehicle_id != 0");
                $this->db->where("v.vehicle_capacity >= $capacity");
                $this->db->join('vehicle v', 'v.vehicle_id = u.vehicle_id', 'LEFT');
                $this->db->limit(1);
                $vehicle_capacity = $this->db->get('user u')->row();

                if (!$vehicle_capacity) {
                    $this->session->set_flashdata('error', 'Transporter vehicle capacity is over');
                    echo json_encode(array('status' => $status));
                    exit;
                }
            }

            $pickup_data = array(
                'address' => $this->common_model->getSiteSettingByTitle('site_address'),
                'contact_no' => $this->common_model->getSiteSettingByTitle('site_contact_no'),
                'latitude' => $this->common_model->getSiteSettingByTitle('latitude'),
                'longitude' => $this->common_model->getSiteSettingByTitle('longitude')
            );

            $station_data = array();
            if ($stations = $this->order_model->getStationById($station_id)) {
                $station_data = $stations;
            }

            /* if($transporter_list == 'Email'){
              $user = $this->db->get_where('user', ['email' => $email_id, 'status' => 1, 'user_type' => 'Transporter'])->row();
              $transporter_id = $user ? $user->user_id : 0;
              } */

            $assign_order = array(
                'order_id' => $order_id,
                'transporter_id' => $transporter_id,
                'station_id' => $station_id,
                'pickup_data' => json_encode($pickup_data),
                'station_data' => json_encode($station_data),
                //'assign_status' => 'Pending',
                'assign_status' => 'Accept',
                'assign_datetime' => DATETIME
            );

            if ($this->order_model->assignOrder($assign_order_id, $assign_order)) {
                $status = 1;
                $this->order_model->updateOrder($order_id, array('transporter_id' => $transporter_id, 'order_status' => 'Assigned'));

                //Add assign order details
                $assign_data = array(
                    'order_id' => $order_id,
                    'assign_order_id' => $assign_order_id,
                    'order_status' => 'Pending',
                    'date_time' => DATETIME
                );
                $this->order_model->addAssignOrderDetails($assign_data);

                //Get Previous transporter status
                $this->db->where('order_id', $order_id);
                $this->db->where('assign_order_id', $assign_order_id);
                $this->db->where('order_status', 'Reach');
                $reach_detail = $this->db->get('assign_order_details')->row();

                if ($reach_detail) {
                    //Add assign order details
                    $assign_data = array(
                        'order_id' => $order_id,
                        'assign_order_id' => $assign_order_id,
                        'order_status' => 'Reach',
                        'date_time' => DATETIME
                    );
                    $this->order_model->addAssignOrderDetails($assign_data);
                }

                //Get Previous transporter status
                $this->db->where('order_id', $order_id);
                $this->db->where('assign_order_id', $assign_order_id);
                $this->db->where('order_status', 'Loaded');
                $loaded_detail = $this->db->get('assign_order_details')->row();

                if ($loaded_detail) {
                    //Add assign order details
                    $assign_data = array(
                        'order_id' => $order_id,
                        'assign_order_id' => $assign_order_id,
                        'order_status' => 'Loaded',
                        'date_time' => DATETIME
                    );
                    $this->order_model->addAssignOrderDetails($assign_data);
                }

                //Send Notification
                $this->common_model->send_nearby_notification($order_id, 'Transporter', 'Assigned', $transporter_id);

                $order = $this->db->get_where('cart_orders', ['id' => $order_id])->row();

                //Owner Send SMS
                $this->common_model->sendOrderMessage($order_id, $order->owner_id);

                //Transporter Send SMS
                $this->common_model->sendOrderMessage($order_id, $order->transporter_id);

                $this->session->set_flashdata('success', 'Order assigned successfully!');
            }
        }
        echo json_encode(array('status' => $status));
        exit;
    }

    function generate_auto_id($table, $key) {
        $id = date('y') . rand(111111, 999999) . generateRandomString(4);
        if ($this->db->get_where($table, [$key => $id])->num_rows() == 0) {
            return $id;
        } else {
            return $this->generate_auto_id($table, $key);
        }
    }

    public function cancel_order($id, $status) {

        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {

            $this->db->select('o.owner_id as user_id, o.id as order_id, o.order_id as order_no, SUM(t.amount) as total_amount');
            $this->db->where('t.status', 1);
            $this->db->where('t.payment_status', 'Paid');
            $this->db->where('t.payment_type', 'Purchase');
            $this->db->where('o.id', $id);
            $this->db->where('o.is_order', 1);
            $this->db->join('transaction t', 't.order_id = o.id', 'left');
            $this->db->limit(1);
            $order_data = $this->db->get('cart_orders o')->row();

            $user_id = $order_data ? $order_data->user_id : 0;
            $order_no = $order_data ? $order_data->order_no : '';

            if ($order_data && $order_data->total_amount) {

                $trans_data = array();
                $trans_data['user_id'] = $user_id;
                $trans_data['order_id'] = $order_data->order_id;
                $trans_data['order_no'] = $order_no;
                $trans_data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
                $trans_data['amount'] = $order_data->total_amount;
                $trans_data['payment_ref_id'] = $this->generate_auto_id('transaction', 'payment_ref_id');
                $trans_data['payment_status'] = 'Paid';
                $trans_data['payment_type'] = 'Wallet';
                $trans_data['transaction_type'] = 'Credit';
                $trans_data['status'] = 1;
                $trans_data['payment_date'] = DATETIME;
                $trans_data['created_date'] = DATETIME;
                $this->db->insert('transaction', $trans_data);

                $this->common_model->updateWallet($user_id);
            }

            $data = array();
            $data['order_status'] = 'Cancelled';
            $data['updated_date'] = DATETIME;

            $this->order_model->updateOrder($id, $data);

            //Send Push Notification
            $this->db->where('user_id', $user_id);
            $this->db->distinct();
            $this->db->select("device_id, user_id");
            $this->db->where("(device_id IS NOT NULL AND device_id != '')");
            $this->db->where('status', '1');
            $devices = $this->db->get('user')->row();

            if ($devices) {

                $title = 'Order Cancelled';
                $message = "Order Cancelled : " . $order_no . ". Amount will be credited in your wallet.";

                $notification_arr = array();
                $notification_arr['user_id'] = $user_id;
                $notification_arr['title'] = $title;
                $notification_arr['message'] = $message;
                $notification_arr['date_time'] = DATETIME;

                $notification = array(
                    "to" => $devices->device_id,
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

                $send_notification = $this->common_model->send_push_notification($notification);
                $this->db->insert('notifications', $notification_arr);
            }

            //Owner Send SMS
            $this->common_model->sendOrderMessage($id, $user_id);

            $this->session->set_flashdata('success', 'Order cancelled successfully!');
        }
        redirect("admin/orders/status/$status");
    }

    public function invoice_view() {
        $id = $this->input->post('id');
        /*$payment_details = $this->order_model->getPaymentDetails($id);
        $invoice_detail = array();
        if (isset($payment_details[0]->invoice_detail) && $payment_details[0]->invoice_detail) {
            $invoice_detail = json_decode($payment_details[0]->invoice_detail);
        }
        //echo '<pre>';print_r($invoice_detail);die;
        $this->data['invoice_detail'] = $this->common_model->jsonToTable($invoice_detail);*/
        
        $this->data['invoice_detail'] = $this->order_model->getOrderDetailById($id);
        $this->data['order_id'] = $id;
        $view = $this->load->view('admin/orders/invoice_detail', $this->data, true);
        echo json_encode(array('status' => true, 'view' => $view));
        exit;
    }

    public function print_invoice() {
        $id = $this->input->post('id');
        $this->data['order_data'] = $this->order_model->getOrderById($id);

        $address_data = array();

        $transaction = $this->common_model->getTableById('transaction', 'order_id', $id);
        if ($transaction && $transaction->payment_status == 'Paid') {
            if ($assign_order = $this->order_model->getAssignOrder($id)) {
                $address_data['billing_info'] = $assign_order->pickup_data ? json_decode($assign_order->pickup_data) : array();
                $address_data['shipping_info'] = $assign_order->station_data ? json_decode($assign_order->station_data) : array();
            }
        } else {
            $address_data['billing_info'] = (object) array(
                        'address' => $this->common_model->getSiteSettingByTitle('site_address'),
                        'contact_no' => $this->common_model->getSiteSettingByTitle('site_contact_no'),
                        'latitude' => $this->common_model->getSiteSettingByTitle('latitude'),
                        'longitude' => $this->common_model->getSiteSettingByTitle('longitude')
            );

            $address_data['shipping_info'] = array();
            if ($stations = $this->order_model->getStationById($this->data['order_data']->station_id)) {
                $address_data['shipping_info'] = $stations;
            }
        }

        $this->data['address_data'] = $address_data;

        /*$invoice_detail = array();
        $transaction = $this->order_model->getPaymentDetails($id);
        if (isset($transaction[0]->invoice_detail) && $transaction[0]->invoice_detail) {
            $invoice_detail = json_decode($transaction[0]->invoice_detail);
        }
        $this->data['invoice_detail'] = $invoice_detail;*/
        
        $this->data['invoice_detail'] = $this->order_model->getOrderDetailById($id);
        $this->data['transaction'] = $this->db->where('order_id', $id)->get('transaction')->row();
        $view = $this->load->view('admin/orders/print_invoice_html', $this->data, true);
        echo json_encode(array('status' => true, 'view' => $view));
        exit;
    }

    /* public function save_print_invoice() {

      $id = $this->input->post('id');
      $json = $this->input->post('json');

      //echo '<pre>';print_r($json);
      $base64string = file_get_contents($json);
      if($base64string != ''){

      if (!file_exists(INVOICES))
      mkdir(INVOICES);

      $file_name = 'invoice_' . $id . '.pdf';

      // Return the number of bytes saved, or false on failure
      if(file_put_contents(INVOICES . $file_name, $base64string)){
      $attachment = INVOICES . $file_name;

      $message = "Dear Sir/Madam,<br/><br/>";
      $message .= "Please find the enclosed attachment of invoice number " . $id;

      $email_id = 'dinesh.dev@colourmoon.com';
      $subject = 'Invoice';

      $this->common_model->send_mail($message, $email_id, $subject, $attachment);
      }
      }

      echo json_encode(array('status' => true));
      exit;
      } */

    public function change_status() {

        $status = 0;
        $id = $this->input->post('id');
        if ($id > 0) {

            $data = array();
            $data['payment_status'] = 'Paid';
            $data['updated_date'] = DATETIME;

            $this->db->where('order_id', $id);
            $this->db->update('transaction', $data);
            $status = 1;

            $order_data = $this->order_model->getOrderById($id);

            //Assign new order
            $pickup_data = array(
                'address' => $this->common_model->getSiteSettingByTitle('site_address'),
                'contact_no' => $this->common_model->getSiteSettingByTitle('site_contact_no'),
                'latitude' => $this->common_model->getSiteSettingByTitle('latitude'),
                'longitude' => $this->common_model->getSiteSettingByTitle('longitude')
            );

            $station_data = array();
            if ($stations = $this->order_model->getStationById($order_data->station_id)) {
                $station_data = $stations;
            }

            $assign_order = array(
                'order_id' => $id,
                'station_id' => $order_data->station_id,
                'pickup_data' => json_encode($pickup_data),
                'station_data' => json_encode($station_data),
                'assign_datetime' => DATETIME
            );

            if ($assign_order_id = $this->order_model->addAssignOrder($assign_order)) {

                $this->db->where('id', $id)->where('is_order', 1)->update('cart_orders', array('order_status' => 'New'));

                //Add assign order details
                $assign_data = array(
                    'order_id' => $id,
                    'assign_order_id' => $assign_order_id,
                    'order_status' => 'New',
                    'date_time' => DATETIME
                );
                $this->order_model->addAssignOrderDetails($assign_data);
            }

            $this->common_model->send_nearby_notification($id, 'Transporter');
        }
        echo json_encode(array('status' => $status));
        exit;
    }

}
