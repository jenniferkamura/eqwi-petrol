<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Help_model extends CI_Model {

    public function addHelp($data) {
        $this->db->insert('help_support', $data);
        return $this->db->insert_id();
    }

    public function getAllHelp($status = 0) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('help_support')->result();
    }

    public function getHelpById($id, $status = 1) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->where('id', $id);
        return $this->db->get('help_support')->row();
    }

    public function updateHelp($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('help_support', $data);
    }

    public function deleteHelp($id) {
        $this->db->where('id', $id);
        return $this->db->delete('help_support');
    }

    public function getAllHelpTicket($status = 0) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('help_ticket')->result();
    }
    
    public function getHelpTicketById($id) {
        $this->db->where('id', $id);
        return $this->db->get('help_ticket')->row();
    }
    
    public function updateHelpTicket($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('help_ticket', $data);
    }
}
