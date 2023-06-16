<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function token() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://uat.buni.kcbgroup.com/token?grant_type=client_credentials',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic UmZsa2xzWXpHS1o0WnV0djVHajJudXlWTjRNYTptUDVaSG0wVEhwdzhmbHRKYkRvVEFEUnM4V3dh',
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

    function pay($payment_ref_id = '') {

        if ($payment_ref_id != '') {

            $this->db->select('t.*, u.name, u.email, u.mobile');
            $this->db->where('t.payment_ref_id', $payment_ref_id);
            $this->db->where('t.payment_status', 'Pending');
            $this->db->where('u.status', 1);
            $this->db->join('user u', 'u.user_id = t.user_id', 'INNER');
            $transaction = $this->db->get('transaction t')->row();
            if ($transaction) {

                $post_data = array();
                $post_data['customerPhone'] = $transaction->mobile;
                $post_data['billAmount'] = round($transaction->amount);
                $post_data['invoiceNumber'] = $payment_ref_id;
                $post_data['transactionDescription'] = 'Purchase';

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://exp.sharksight.co.ke/api/eqwipetrol/kcb/stk-push',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $post_data,
                        /* CURLOPT_HTTPHEADER => array(
                          'apikey: ' . $this->token()
                          ), */
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $msg = '';
                $success = $requestID = 0;
                if ($response && $data = json_decode($response)) {
                    if ($data->code == 200) {
                        $requestID = $data->response->requestID;
                        $success = 1;
                        $msg = $data->response->message;
                    } else {
                        $msg = $data->message;
                    }
                }

                if ($requestID) {

                    $this->db->where('payment_ref_id', $payment_ref_id);
                    $this->db->where('payment_status', 'Pending');
                    $this->db->update('transaction', array('receipt_no' => $requestID));
                }

                echo json_encode(array('success' => $success, 'msg' => $msg, 'request_id' => $requestID, 'payment_ref_id' => $payment_ref_id));
                die;
            } else {
                echo json_encode(array('success' => 0, 'msg' => 'Transaction not found'));
                die;
            }
        } else {
            echo json_encode(array('success' => 0, 'msg' => 'Invoice number empty'));
            die;
        }
    }

    function verify($payment_ref_id = '', $requestID = '') {

        if ($payment_ref_id != '' && $requestID != '') {

            $this->db->where('payment_ref_id', $payment_ref_id);
            $this->db->where('receipt_no', $requestID);
            $this->db->where('payment_status', 'Pending');
            $transaction = $this->db->get('transaction t')->row();
            if ($transaction) {

                $post_data = array();
                $post_data['MerchantRequestID'] = $requestID;

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://exp.sharksight.co.ke/api/eqwipetrol/kcb/stk/verify',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $post_data,
                        /* CURLOPT_HTTPHEADER => array(
                          'apikey: ' . $this->token()
                          ), */
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $msg = '';
                $success = 0;
                if ($response && $data = json_decode($response)) {

                    if ($data->code == 200) {
                        $msg = $data->response->Result;
                        $success = 1;

                        if ((isset($data->response->MpesaCode) && isset($data->response->TransactionDate)) && ($data->response->MpesaCode && $data->response->TransactionDate)) {

                            $transaction_id = $transaction->transaction_id;

                            $data = array();
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
                            $this->db->where('transaction_id', $transaction_id);
                            $this->db->update('transaction', $data);
                        }
                    } else {
                        $msg = $data->message;
                    }
                }

                echo json_encode(array('success' => $success, 'msg' => $msg));
                die;
            } else {
                echo json_encode(array('success' => 0, 'msg' => 'Transaction not found'));
                die;
            }
        } else {
            echo json_encode(array('success' => 0, 'msg' => 'Invoice number empty'));
            die;
        }
    }

    function check_payment_status() {

        $this->db->where('payment_status', 'Pending');
        $transactions = $this->db->get('transaction t')->result();
        if ($transactions) {

            foreach ($transactions as $transaction) {

                if ($requestID = $transaction->receipt_no) {

                    $post_data = array();
                    $post_data['MerchantRequestID'] = $requestID;

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'http://exp.sharksight.co.ke/api/eqwipetrol/kcb/stk/verify',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $post_data,
                            /* CURLOPT_HTTPHEADER => array(
                              'apikey: ' . $this->token()
                              ), */
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);

                    $msg = '';
                    $success = 0;
                    if ($response && $data = json_decode($response)) {

                        if ($data->code == 200) {
                            $msg = $data->response->Result;
                            $success = 1;

                            $transaction_id = $transaction->transaction_id;
                            
                            if ((isset($data->response->MpesaCode) && isset($data->response->TransactionDate)) && ($data->response->MpesaCode && $data->response->TransactionDate)) {

                                $data = array();
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
                                $data['payment_status'] = 'Failed';
                                $this->db->where('transaction_id', $transaction_id);
                                $this->db->update('transaction', $data);
                            }
                        }
                    }
                }
            }
        }
    }

}
