<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Station_model extends CI_Model {

    public function addStation($data) {
        $this->db->insert('station', $data);
        return $this->db->insert_id();
    }

    public function getAllStation() {
        $this->db->select('s.*, u.name');
        $this->db->join('user u', 'u.user_id = s.owner_id', 'LEFT');
        $this->db->order_by('s.created_date', 'DESC');
        return $this->db->get('station s')->result();
    }
    
    public function getAllOwners() {
        $this->db->where('status', '1');
        $this->db->where('user_type', 'Owner');
        return $this->db->get('user')->result();
    }

    public function getStationById($id) {
        $this->db->where('station_id', $id);
        return $this->db->get('station')->row();
    }

    public function updateStation($id, $data) {
        $this->db->where('station_id', $id);
        return $this->db->update('station', $data);
    }

    public function deleteStation($id) {
        $this->db->where('station_id', $id);
        return $this->db->delete('station');
    }

}
