<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    public function addTransaction($data) {
        $this->db->insert('transaction', $data);
        return $this->db->insert_id();
    }

    public function getAllTransaction($user_id = '', $from_date = '', $to_date = '') {
        
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($from_date != '') {
            $this->db->where('DATE_FORMAT(payment_date, "%Y-%m-%d") >= ', $from_date);
        }
        if ($to_date != '') {
            $this->db->where('DATE_FORMAT(payment_date, "%Y-%m-%d") <= ', $to_date);
        }
        
        $this->db->order_by('created_date', 'DESC');
        $data = $this->db->get('transaction')->result();
        if($data){
            foreach ($data as $item) {
                $name = '';
                if($user = $this->common_model->getUserById($item->user_id)){
                    $name = $user->name;
                }
                $item->name = $name;
            }
        }
        return $data;
    }

    public function getTransactionById($id) {
        $this->db->where('id', $id);
        return $this->db->get('transaction')->row();
    }

    public function updateTransaction($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('transaction', $data);
    }

    public function getOwners() {
        $this->db->where('user_type', 'Owner');
        $this->db->where('status', 1);
        return $this->db->get('user')->result();
    } 
    
    public function getTransporters() {
        $this->db->where('user_type', 'Transporter');
        $this->db->where('status', 1);
        return $this->db->get('user')->result();
    } 
    
    public function getAllOrderReviews($user_id = '', $transporter_id = '', $from_date = '', $to_date = '') {
        
        if ($user_id != '') {
            $this->db->where('o.user_id', $user_id);
        }
        if ($transporter_id != '') {
            $this->db->where('o.transporter_id', $transporter_id);
        }
        if ($from_date != '') {
            $this->db->where('DATE_FORMAT(o.review_date, "%Y-%m-%d") >= ', $from_date);
        }
        if ($to_date != '') {
            $this->db->where('DATE_FORMAT(o.review_date, "%Y-%m-%d") <= ', $to_date);
        }
        
        $this->db->select('o.*, u.name as owner_name, u.mobile as owner_mobile, t.name as transporter_name, t.mobile as transporter_mobile');
        $this->db->where('o.rating != ', 0);
        $this->db->join('user u', 'u.user_id = o.owner_id', 'INNER');
        $this->db->join('user t', 't.user_id = o.transporter_id', 'LEFT'); 
        $this->db->order_by('o.review_date', 'DESC');
        $data = $this->db->get('cart_orders o')->result();
        /*if($data){
            foreach ($data as $item) {
                $owner_name = $transporter_name = '';
                if($user = $this->common_model->getUserById($item->user_id)){
                    $owner_name = $user->name;
                }
                if($transporter = $this->common_model->getUserById($item->transporter_id)){
                    $transporter_name = $transporter->name;
                }
                $item->owner_name = $owner_name;
                $item->transporter_name = $transporter_name;
            }
        }*/
        return $data;
    }
}
