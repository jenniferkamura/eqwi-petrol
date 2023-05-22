<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function addProduct($data) {
        $this->db->insert('category', $data);
        return $this->db->insert_id();
    }

    public function getAllProduct() {
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('category')->result();
    }

    public function getProductById($id) {
        $this->db->where('category_id', $id);
        return $this->db->get('category')->row();
    }

    public function updateProduct($id, $data) {
        $this->db->where('category_id', $id);
        return $this->db->update('category', $data);
    }

    public function deleteProduct($id) {
        $product = $this->getProductById($id);
        
        $this->db->where('category_id', $id);
        $delete = $this->db->delete('category');
        
        if($delete && $product && $product->image){
            unlink(PRODUCT_IMG . $product->image);
        }
        return $delete;
    }

}
