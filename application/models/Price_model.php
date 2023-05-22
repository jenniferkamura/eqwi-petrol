<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Price_model extends CI_Model {

    public function addProductPrice($data) {
        $this->db->insert('category_price', $data);
        return $this->db->insert_id();
    }

    public function getAllProductPrice($from_date = "", $to_date = "") {
        
        if ($from_date != '' && $to_date != '') {
            $this->db->where(" DATE_FORMAT(p.date_time, '%Y-%m-%d') >= '$from_date' AND DATE_FORMAT(p.date_time, '%Y-%m-%d') <= '$to_date' ");
        }
        $this->db->select('p.*, c.name');
        $this->db->where('c.status', 1);
        $this->db->join('category c', 'c.category_id = p.category_id', 'LEFT');
        $this->db->order_by('p.date_time', 'DESC');
        return $this->db->get('category_price p')->result();
    }
    
    public function getAllProduct() {
        $this->db->where('status', 1);
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('category')->result();
    }

    public function getProductPriceById($id) {
        $this->db->where('id', $id);
        return $this->db->get('category_price')->row();
    }

    public function updateAllCartDataById($id, $price) {
          
        $this->db->where('category_id', $id);
        $carts = $this->db->get('carts')->result();
        if($carts){ 
            foreach ($carts as $cart) {
                 
                $data = array();
                $data['price'] = $price;
                $data['total_price'] = round($cart->qty * $price, 2);

                $this->db->where('cart_id', $cart->cart_id);
                $this->db->update('carts', $data);
            }
        }
    }
}
