<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    /**
     * Start Admin
     */
    public function getAdminLogin($email, $pwd) {
        $this->db->where('email_id', $email);
        $this->db->where('password', $pwd);
        $this->db->where('status', 1);
        return $this->db->get('admin')->row();
    }
    
    public function getAdminData() {
        $this->db->where('admin_id', 1);
        return $this->db->get('admin')->row();
    }
    
    public function updateAdminData($id, $data) {
        $this->db->where('admin_id', $id);
        $this->db->update('admin', $data);
    }
    
    public function addLogs($data) {
        return $this->db->insert('logs', $data);
    }
}
