<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crons extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function payment_status() {

        //$this->db->select('t.*, u.name, u.email, u.mobile');
        $this->db->where('t.payment_status', 'Pending');
        //$this->db->where('u.status', 1);
        $this->db->where('t.status', 1);
        $this->db->where('t.is_invoice', 1);
        $this->db->where('t.transaction_type', 'Invoice');
        //$this->db->join('user u', 'u.user_id = t.user_id', 'INNER');
        $transactions = $this->db->get('transaction t')->result();
        if ($transactions) {
            foreach ($transactions as $transaction) {
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://exp.fanakamobile.com/api/eqwipetrol/verify/bill/' . $transaction->receipt_no,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'GET'
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                if($response && $result = json_decode($response)){
                    if($result->code == 200){
                            
                        if($response->response->billStatus != 'Pending'){
                            
                            $data = array();
                            $data['payment_info'] = $response;
                            $data['payment_status'] = 'Paid';
                            
                            $this->db->where('order_id', $response->response->orderID);
                            $this->db->where('receipt_no', $response->response->billRegNo);
                            $this->db->update('transaction', $data);
                        }
                    }
                }
            }
        }
    }

}
