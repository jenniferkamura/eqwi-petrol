<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    private $test_url = '';
    private $live_url = '';
    private $client_email = '';
    private $client_key = '';
    private $checksum_key = '';

    function __construct() {
        parent::__construct();

        $payment_gateway = $this->common_model->getSettings('payment_gateway_setting');
        if ($payment_gateway) {
            foreach ($payment_gateway as $setting) {
                if ($setting->title == 'test_pg_url') {
                    $this->test_url = $setting->value;
                }
                if ($setting->title == 'live_pg_url') {
                    $this->live_url = $setting->value;
                }
                if ($setting->title == 'client_email') {
                    $this->client_email = $setting->value;
                }
                if ($setting->title == 'pg_client_key') {
                    $this->client_key = $setting->value;
                }
                if ($setting->title == 'pg_checksum_key') {
                    $this->checksum_key = $setting->value;
                }
            }
        }
    }

    function pay($payment_ref_id = '') {

        if ($payment_ref_id != '') {

            $this->db->select('t.*, u.name, u.email, u.mobile');
            $this->db->where('t.payment_ref_id', $payment_ref_id);
            $this->db->where('t.payment_status', 'Pending');
            $this->db->where('u.status', 1);
            $this->db->join('user u', 'u.user_id = t.user_id', 'INNER');
            $transaction = $this->db->get('transaction t')->row();
            if ($transaction) {

                $data = array();
                $data['client_email'] = $this->client_email;
                $data['client_key'] = $this->client_key;
                $data['transaction'] = $transaction;

                $this->load->view('payment', $data);

                /* $param = array();
                  $param['OrderId'] = $transaction->transaction_id;
                  $param['CustomerEmail'] = $transaction->email;
                  $param['Currency'] = $this->common_model->getSiteSettingByTitle('currency_code');
                  $param['CustomerPhone'] = $transaction->mobile;
                  $param['OrderAmount'] = $transaction->amount;
                  $param['BusinessEmail'] = $this->client_email;
                  $param['ClientKey'] = $this->client_key;
                  $param['CancelledUrl'] = base_url('payment/cancel');
                  $param['CallBackUrl'] = base_url('payment/success');
                  $param['Description'] = 'Purchase';
                  $param['SupportEmail'] = '';
                  $param['SupportPhone'] = '';
                  $param['UseJPLogo'] = 'yes';
                  $param['StoreName'] = $transaction->name;
                  echo $url = "https://checkout-v3-test.jambopay.co.ke/?" . http_build_query($param);die; */
            } else {
                echo 'Transaction not found';
                die;
            }
        } else {
            echo 'bye';
            die;
        }
    }

    function calculateChecksum($orderData) {
        $checksumKey = $this->checksum_key; //obtained from some secret env
        $test = hash("sha256", $orderData['order_id'] . strval(round($orderData['amount'], 2)) . $checksumKey);

        echo '<pre>';
        print_r($orderData);
        print_r($test);
        die;
    }

    function verifyChecksum($callbackInfo) {
        //$orderInfo = array('orderId' => '1121', 'amount' => '1.00');//GetOrderFromDb($callbackInfo->orderId);
        $orderInfo = array('orderId' => $callbackInfo['order_id'], 'amount' => $callbackInfo['amount']);
        return $this->calculateChecksum($orderInfo) == $callbackInfo['checksum'];
    }

    function success() {
        //response
        /*
          array(
          'order_id' => '1111',
          'status' => 'SUCCESS',
          'currency' => 'KES',
          'receipt' => 'a3dde9b8-fef6-4497-8ee5-ed9eced752ec',
          'checksum' => '09956fd5bddab55909cd929298e3feae564145c92be886aa4ca3fb28c6f14e47',
          'amount' => 1.00,
          'timestamp' => '2022-12-02 08:45:36'
          );
         */

        /* echo '<pre>';print_r($_POST);
          $data = $this->verifyChecksum($_POST);
          echo '<pre>';print_r($data);
          echo '<pre>';print_r($_POST);die; */

        $result = false;
        if ($this->input->post()) {

            /* $transaction_id = $this->input->post('order_id');
              $status = $this->input->post('status');

              if ($status == 'SUCCESS') {

              $data = array();
              $data['receipt_no'] = $this->input->post('receipt');
              $data['payment_info'] = json_encode($this->input->post());
              $data['payment_status'] = 'Paid';

              $this->db->where('transaction_id', $transaction_id);
              $this->db->update('transaction', $data);
              $result = true;
              } */

            $transaction_id = $this->input->post('OrderId');
            $status = $this->input->post('Status');

            /* if ($status == 'Completed') {

              $data = array();
              $data['receipt_no'] = $this->input->post('TranID');
              $data['payment_info'] = json_encode($this->input->post());
              $data['payment_status'] = 'Paid';

              $this->db->where('transaction_id', $transaction_id);
              $this->db->update('transaction', $data);
              $result = true;
              } */

            if ($status == 'Failed' || $status == 'Canceled') {
                $result = false;
            }
        }
        echo json_encode(array('status' => $result));
        die;
    }

    function cancel() {
        //response
        /*
          array(
          'order_id' => '1112',
          'status' => 'FAILED'
          );
         */

        echo json_encode(array('status' => false));
        die;
    }

    function token() {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->test_url . '/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&Username=eqwipetrol@jambopay.com&Password=Password1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $access_token = '';
        if ($response && $data = json_decode($response)) {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    function check_status($transaction_id) {

        $status = '';
        if ($transaction = $this->db->where('transaction_id', $transaction_id)->where('payment_status', 'Pending')->get('transaction')->row()) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->test_url . '/api/Transactions/TranStatus/' . $transaction_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->token()
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $status = 'Pending';
            if ($response && $result = json_decode($response)) {
                $status = $result->Status;
                if ($result->Status == 'Completed') {
                    $data = array();
                    $data['receipt_no'] = $result->TranID;
                    $data['payment_info'] = $response;
                    $data['payment_status'] = 'Paid';

                    $this->db->where('transaction_id', $transaction_id);
                    $this->db->update('transaction', $data);

                    if ($transaction->order_id) {

                        $payment_data = $this->db->where('order_id', $transaction->order_id)->where("transaction_id != $transaction_id")->get('transaction')->row();
                        if (!$payment_data) {
                            $this->load->model('api_model');

                            $this->api_model->updateTable('cart_orders', 'id', $transaction->order_id, array('is_order' => 1));
                            if ($cart_data = $this->api_model->getCartData($transaction->user_id)) {
                                if (isset($cart_data['cart']) && $cart_data['cart']) {
                                    foreach ($cart_data['cart'] as $cart) {

                                        $this->api_model->deleteTable('carts', 'cart_id', $cart->cart_id);
                                    }
                                }
                            }

                            //Assign new order
                            $pickup_data = array(
                                'address' => $this->common_model->getSiteSettingByTitle('site_address'),
                                'contact_no' => $this->common_model->getSiteSettingByTitle('site_contact_no'),
                                'latitude' => $this->common_model->getSiteSettingByTitle('latitude'),
                                'longitude' => $this->common_model->getSiteSettingByTitle('longitude')
                            );

                            $station_data = array();
                            if ($stations = $this->api_model->getStationById($transaction->station_id)) {
                                $station_data = $stations;
                            }

                            $assign_order = array(
                                'order_id' => $transaction->order_id,
                                'station_id' => $transaction->station_id,
                                'pickup_data' => json_encode($pickup_data),
                                'station_data' => json_encode($station_data),
                                'assign_datetime' => DATETIME
                            );

                            if ($assign_order_id = $this->api_model->addAssignOrder($assign_order)) {

                                //Add assign order details
                                $assign_data = array(
                                    'order_id' => $transaction->order_id,
                                    'assign_order_id' => $assign_order_id,
                                    'order_status' => 'New',
                                    'date_time' => DATETIME
                                );
                                $this->api_model->addAssignOrderDetails($assign_data);
                            }
                            $this->common_model->send_nearby_notification($transaction->order_id, 'Transporter');
                        }
                    } else {

                        //Online Wallet Payment
                        $this->common_model->updateWallet($transaction->user_id);
                    }
                } else {

                    $data = array();
                    $data['payment_info'] = $response;
                    $data['payment_status'] = $status;
                    $this->db->where('transaction_id', $transaction_id);
                    $this->db->update('transaction', $data);
                }
            }
        }
        echo json_encode(array('status' => $status));
        die;
    }

}
