<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement_model extends CI_Model {

    public function addAdvertisement($data) {
        $this->db->insert('advertisement', $data);
        return $this->db->insert_id();
    }

    public function getAllAdvertisement() {
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('advertisement')->result();
    }

    public function getAdvertisementById($id) {
        $this->db->where('id', $id);
        return $this->db->get('advertisement')->row();
    }

    public function updateAdvertisement($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('advertisement', $data);
    }

    public function deleteAdvertisement($id) {
        $ads = $this->getAdvertisementById($id);
        
        $this->db->where('id', $id);
        $delete = $this->db->delete('advertisement');
        
        if($delete && $ads && $ads->image){
            unlink(BOARDING_SLIDER_IMG . $ads->image);
        }
        return $delete;
    }

}
