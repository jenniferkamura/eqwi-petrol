<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function getAllOrder($order_status = 'Pending', $order_id = '', $from_date = '', $to_date = '', $limit = NULL, $start = NULL) {
        
        if ($order_id != '') {
            $this->db->like('o.order_id', $order_id);
        }
        if ($from_date != '') {
            $this->db->where('DATE_FORMAT(o.order_date, "%Y-%m-%d") >= ', $from_date);
        }
        if ($to_date != '') {
            $this->db->where('DATE_FORMAT(o.order_date, "%Y-%m-%d") <= ', $to_date);
        }
        
        $this->db->select('o.*, u.name, mobile, s.station_name, s.address');
        $this->db->where('o.is_order', 1);
        $this->db->where('o.order_status', $order_status);
        $this->db->join('user u', 'u.user_id = o.user_id', 'left');
        $this->db->join('station s', 's.station_id = o.station_id', 'left');
        $this->db->order_by('o.created_date', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('cart_orders o')->result();
    }

    public function getOrderById($id) {
        $this->db->select('o.*, u.name, mobile, s.station_name, s.address');
        $this->db->where('o.is_order', 1);
        $this->db->where('o.id', $id);
        $this->db->join('user u', 'u.user_id = o.user_id', 'left');
        $this->db->join('station s', 's.station_id = o.station_id', 'left');
        $this->db->limit(1);
        return $this->db->get('cart_orders o')->row();
    }

    public function updateOrder($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('cart_orders', $data);
    }

    public function deleteOrder($id) {
        $this->db->where('id', $id);
        return $this->db->delete('cart_orders');
    }
    
    public function getOrderDetailById($id) {
        $this->db->where('cart_order_id', $id);
        return $this->db->get('cart_order_details')->result();
    }
    
    public function getAllVendor() {
        $this->db->where('status', 1);
        $this->db->order_by('created_date', 'desc');
        return $this->db->get('vendor')->result();
    }
    
    public function getAllTransporter() {
        $this->db->where('status', 1);
        $this->db->where('user_type', 'Transporter');
        $this->db->order_by('created_date', 'desc');
        return $this->db->get('user')->result();
    }
    
    public function addAssignOrder($data) {
        $this->db->insert('assign_orders', $data);
        return $this->db->insert_id();
    }
    
    public function assignOrder($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('assign_orders', $data);
    }
    
    public function getVendorById($vendor_id) {
        $this->db->where('vendor_id', $vendor_id);
        return $this->db->get('vendor')->row();
    }
    
    public function getStationById($station_id) {
        $this->db->where('station_id', $station_id);
        return $this->db->get('station')->row();
    }
    
    public function getAssignOrder($order_id) {
        $this->db->where('order_id', $order_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('assign_orders')->row();
    }
    
    public function getOrderCounts($order_status) {
        $this->db->where('order_status', $order_status);
        $this->db->where('is_order', 1);
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('cart_orders')->num_rows();
    }
    
    function addAssignOrderDetails($data) {
        return $this->db->insert('assign_order_details', $data);
    }
        
    function getAssignOrderDetails($order_id) {
        
        $result = array();
        if($assign_orders = $this->db->order_by('id', 'desc')->get_where('assign_orders', ['order_id' => $order_id])->result()){
            $i = 0;
            foreach ($assign_orders as $assign) {
                
                $user = $this->db->limit(1)->get_where('user', ['user_id' => $assign->transporter_id])->row();
                $name = $user ? $user->name : '';
                            
                $this->db->where('assign_order_id', $assign->id);
                $this->db->where('order_id', $order_id);
                $this->db->order_by('id', 'desc');
                $data = $this->db->get('assign_order_details')->result();
                if($data){
                    foreach ($data as $item) {
                        
                        if($item->order_status == 'Reject'){                    
                            $user = $this->db->limit(1)->get_where('user', ['user_id' => $item->reject_user_id])->row();
                            $name = $user ? $user->name : '';
                        }
                        
                        $result[$i] = $item;
                        $result[$i]->name = $name;
                        $i++;
                    }
                }
            }
        }
        return $result;
    }
    
    function getPaymentDetails($order_id) {
        $this->db->where('status', 1);
        $this->db->where('order_id', $order_id);
        $this->db->group_start();
        $this->db->where('payment_status', 'Paid');
        $this->db->or_where('payment_status', 'Pending');
        $this->db->group_end();
        return $this->db->get('transaction')->result();
    }
    
    function checkPaidTransactionAmount($order_id) {

        $payment_done = 0;
        if ($order = $this->getOrderById($order_id)) {
            
            $this->db->select('*, SUM(amount) as total_amount');
            $this->db->where('order_id', $order_id);
            $this->db->where('payment_status', 'Paid');
            $payment = $this->db->get('transaction')->row();
            
            $total_amount = $order->total_amount;
            $payment_amount = $payment->total_amount;
            if ($payment && $payment_amount) {
                if ($payment_amount < $total_amount) {
                    $payment_done = round($total_amount - $payment_amount, 2);
                }
            }else{
                $payment_done = round($total_amount, 2);
            }
        }
        return $payment_done;
    }
}
