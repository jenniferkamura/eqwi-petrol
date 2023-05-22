<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {

    public function addCoupon($data) {
        $this->db->insert('coupons', $data);
        return $this->db->insert_id();
    }

    public function getAllCoupon() {
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('coupons')->result();
    }

    public function getCouponById($id) {
        $this->db->where('coupon_id', $id);
        return $this->db->get('coupons')->row();
    }

    public function updateCoupon($id, $data) {
        $this->db->where('coupon_id', $id);
        return $this->db->update('coupons', $data);
    }

    public function deleteCoupon($id) {        
        $this->db->where('coupon_id', $id);
        return $this->db->delete('coupons');
    }

    public function getAllProduct() {
        $this->db->where('status', 1);
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('category')->result();
    }
    
    public function getProductById($id) {
        $this->db->where('category_id', $id);
        return $this->db->get('category')->row();
    }
}
