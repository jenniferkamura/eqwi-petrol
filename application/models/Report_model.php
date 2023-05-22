<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function getAllTransaction($user_id = '', $from_date = '', $to_date = '') {
        $where = "";
        if ($user_id != '') {
            $where .= " AND o.owner_id = $user_id";
        }
        if ($from_date != '') {
            $where .= " AND o.order_date >= '$from_date'";
        }
        if ($to_date != '') {
            $where .= " AND o.order_date <= '$to_date'";
        }
        
        $data = $this->db->query("SELECT o.*, u.name, u.mobile, p.product_name, 
                IFNULL(t.pay_amount, 0) AS trans_amount, IFNULL(o.total_amount - t.pay_amount, 0) AS remaining_amt 
            FROM cart_orders o
            LEFT JOIN (SELECT cart_order_id, GROUP_CONCAT(`name` SEPARATOR ', ') AS product_name
                FROM `cart_order_details` GROUP BY cart_order_id) p ON p.cart_order_id = o.id
            LEFT JOIN (SELECT order_id, SUM(amount) AS pay_amount 
                FROM `transaction` WHERE payment_status = 'Paid' GROUP BY order_id) t ON t.order_id = o.id
            LEFT JOIN `user` u ON u.user_id = o.owner_id
            WHERE o.is_order = 1 AND o.order_status != 'Rejected' AND o.order_status != 'Cancelled' $where
            ORDER BY o.updated_date DESC")->result();
        
        return $data;
    }

    public function getReportById($id) {
        $this->db->where('id', $id);
        return $this->db->get('transaction')->row();
    }

    public function updateReport($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('transaction', $data);
    }

    public function getOwners() {
        $this->db->where('user_type', 'Owner');
        $this->db->where('status', 1);
        return $this->db->get('user')->result();
    } 
    
    public function getAllOrderReviews($user_id = '', $from_date = '', $to_date = '') {
        
        if ($user_id != '') {
            $this->db->where('user_id', $user_id);
        }
        if ($from_date != '') {
            $this->db->where('DATE_FORMAT(review_date, "%Y-%m-%d") >= ', $from_date);
        }
        if ($to_date != '') {
            $this->db->where('DATE_FORMAT(review_date, "%Y-%m-%d") <= ', $to_date);
        }
        
        $this->db->where('rating != ', 0);
        $this->db->order_by('review_date', 'DESC');
        $data = $this->db->get('cart_orders')->result();
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
}
