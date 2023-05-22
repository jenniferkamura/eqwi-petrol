<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function addUser($data) {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function getAllUser($user_type, $status = 0) {
        if ($status) {
            $this->db->where('u.status', $status);
        }
        if($user_type == 'Manager' || $user_type == 'Attendant'){
            $this->db->select('u.*, s.station_name');
            $this->db->join('station s', 's.station_id = u.station_id', 'left');
        }
        $this->db->where('u.user_type', $user_type);
        $this->db->order_by('u.created_date', 'DESC');
        return $this->db->get('user u')->result();
    }

    public function getUserById($id, $status = 1) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->where('user_id', $id);
        return $this->db->get('user')->row();
    }

    public function checkUserExist($value, $type, $user_id, $user_type) {
        /*if($type != 'login_id'){
            $this->db->where('user_type', $user_type);
        }*/
        $this->db->where($type, $value);
        if ($user_id) {
            $this->db->where('user_id != ', $user_id);
        }
        return $this->db->get('user')->row();
    }

    public function updateUser($id, $data) {
        $this->db->where('user_id', $id);
        return $this->db->update('user', $data);
    }

    public function deleteUser($id) {
        $this->db->where('user_id', $id);
        return $this->db->delete('user');
    }

    function check_user_data($type = '', $val = '', $user_id = 0) {
        $result = TRUE;
        if ($type == 'login_id') {
            $this->db->where('login_id', $val);
        }
        if ($type == 'email') {
            $this->db->where('email', $val);
        }
        if ($type == 'mobile') {
            $this->db->where('mobile', $val);
        }
        if ($user_id > 0) {
            $this->db->where("user_id != $user_id");
        }
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            $result = FALSE;
        }
        return $result;
    }
    
    public function getStationOwnerId($station_id) {
        $this->db->where('station_id', $station_id);
        return $this->db->get('station')->row();
    }

    public function addUserDocuments($data) {
        $this->db->insert('user_documents', $data);
        return $this->db->insert_id();
    }

    public function updateUserDocuments($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('user_documents', $data);
    }
    
    public function updateUserDocumentsByUserId($id, $data) {
        $this->db->where('user_id', $id);
        $document = $this->db->get('user_documents')->row();
        if ($document) {
            $this->updateUserDocuments($document->id, $data);
        } else {
            $this->addUserDocuments($data);
        }
    }

    public function getUserDocuments($user_id) {
        $this->db->select('id, document_type, document_number, front_photo');
        $this->db->where('user_id', $user_id);
        $data = $this->db->get('user_documents')->row();
        if($data){
            $data->front_photo_url = getImage('user_documents', $data->front_photo);
        }
        return $data;
    }
    
    public function getAllStation($owner_id) {
        $this->db->where('status', 1);
        $this->db->where('owner_id', $owner_id);
        $this->db->order_by('station_name', 'ASC');
        return $this->db->get('station')->result();
    }

    function getUserTableData($postData) {
        $sql = $this->get_datatables_users_query($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $sql .= ' LIMIT ' . $postData['length'] . ' OFFSET ' . $postData['start'];
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getUserTableSearchData($postData) {
        $sql = $this->get_datatables_users_query($postData);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_datatables_users_query($postData) {
        $column_order = array('', '', 'a.name', 'a.email', 'a.mobile', 'a.company', 'a.birthdate', 'a.address', 'a.created_date', 'a.status', 'a.verified', 'a.user_status');
        $sql = "SELECT a.* FROM (SELECT *, DATE_FORMAT(creation_datetime, '%d/%m/%Y %h:%i %p') as created_date, 
                IF(birth_date, DATE_FORMAT(birth_date, '%d/%m/%Y'), '') as birthdate,
                IF(mobile_verified = 1, 'Yes', 'No') as verified, IF(status = 1, 'Active', 'Inactive') as user_status
                FROM user) a WHERE 1=1 ";
        if (isset($postData['search']['value']) && $postData['search']['value']) {
            $i = 0;
            $search_value = $postData['search']['value'];
            foreach ($column_order as $value) {
                if($value != ''){ 
                    if ($i == 0) {
                        $like = " AND (";
                        $like .= $value . " LIKE '%" . $search_value . "%')";
                    }else{
                        $like = " OR (";
                        $like .= $value . " LIKE '%" . $search_value . "%')";
                    }
                    $sql .= $like;
                    $i++;
                }
            }
        }
        
        if (isset($postData['order'])) {
            $sql .= " ORDER BY " . $column_order[$postData['order']['0']['column']] . ' ' . $postData['order']['0']['dir'];
        } else {
            $sql .= ' ORDER BY a.creation_datetime DESC';
        }
        return $sql;
    }
    
    function getTransporterAvailability($user_id = 0, $from_date = '', $to_date = '') {    

        if($user_id > 0){
            $this->db->where('u.user_id', $user_id);            
        }
        if ($from_date != '') {
            $this->db->where('a.set_date >= ', $from_date);
        }
        if ($to_date != '') {
            $this->db->where('a.set_date <= ', $to_date);
        }
        
        $this->db->where('u.status', 1);
        $this->db->join('transporter_not_available a', 'a.user_id = u.user_id', 'INNER');
        $this->db->order_by('a.set_date', 'DESC');
        return $this->db->get('user u')->result();
    }
}
