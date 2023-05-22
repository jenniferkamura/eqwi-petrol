<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends CI_Model {

    public function addFeedback($data) {
        $this->db->insert('feedback', $data);
        return $this->db->insert_id();
    }

    public function getAllFeedback($from_date = '', $to_date = '') {
        
        if ($from_date != '') {
            $this->db->where('DATE_FORMAT(f.created_date, "%Y-%m-%d") >= ', $from_date);
        }
        if ($to_date != '') {
            $this->db->where('DATE_FORMAT(f.created_date, "%Y-%m-%d") <= ', $to_date);
        }
        
        $this->db->select('f.*, u.name');
        $this->db->order_by('f.created_date', 'DESC');
        $this->db->join('user u', 'u.user_id = f.user_id', 'inner');
        $data = $this->db->get('feedback f')->result();
        /*if($data){
            foreach ($data as $item) {
                $name = '';
                if($user = $this->common_model->getUserById($item->user_id)){
                    $name = $user->name;
                }
                $item->name = $name;
            }
        }*/
        return $data;
    }

    public function getFeedbackById($id) {
        $this->db->where('id', $id);
        return $this->db->get('feedback')->row();
    }

    public function updateFeedback($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('feedback', $data);
    }

}
