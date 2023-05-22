<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {
        
    public function getPointByTitle($title) {
        $this->db->where('title', $title);
        return $this->db->get('points')->row();
    }

    public function updatePoint($title, $data) {
        $this->db->where('title', $title);
        return $this->db->update('points', $data);
    }
    
    public function getSettings($option_type) {
        $this->db->where('option_type', $option_type);
        return $this->db->get('option_setting')->result();
    }
    
    public function updateSetting($option_type, $data) {
        $this->db->where('option_type', $option_type);
        $result = $this->db->get('option_setting')->row();
        if($result){
            if($data){
                foreach ($data as $value) {
                    if($this->db->get_where('option_setting', ['title' => $value['title']])->row()){
                        $this->db->where('title', $value['title']);
                        $this->db->update('option_setting', $value); 
                    }else{
                        $this->db->insert('option_setting', $value);
                    }
                }
                return true;
            }
        }else{
            return $this->db->insert_batch('option_setting', $data);
        }
    }
    
    public function insertPushNotification($data) {
        return $this->db->insert_batch('notifications', $data);
    }
    
    //start reject reason
    public function addRejectReason($data) {
        $this->db->insert('reject_reason', $data);
        return $this->db->insert_id();
    }

    public function getAllRejectReason($status = 0) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('reject_reason')->result();
    }

    public function getRejectReasonById($id, $status = 1) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->where('id', $id);
        return $this->db->get('reject_reason')->row();
    }
    
    public function updateRejectReason($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('reject_reason', $data);
    }

    public function deleteRejectReason($id) {
        $this->db->where('id', $id);
        return $this->db->delete('reject_reason');
    }
    //end reject reason
}
