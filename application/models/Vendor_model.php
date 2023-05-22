<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_model extends CI_Model {

    public function addVendor($data) {
        $this->db->insert('vendor', $data);
        return $this->db->insert_id();
    }

    public function getAllVendor($status = 0) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('vendor')->result();
    }

    public function getVendorById($id, $status = 1) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->where('vendor_id', $id);
        return $this->db->get('vendor')->row();
    }

    public function checkVendorExist($value, $type, $vendor_id) {
        $this->db->where($type, $value);
        if ($vendor_id) {
            $this->db->where('vendor_id != ', $vendor_id);
        }
        return $this->db->get('vendor')->row();
    }

    public function updateVendor($id, $data) {
        $this->db->where('vendor_id', $id);
        return $this->db->update('vendor', $data);
    }

    public function deleteVendor($id) {
        $this->db->where('vendor_id', $id);
        return $this->db->delete('vendor');
    }

    function check_vendor_data($type = '', $val = '') {
        $result = TRUE;
        if ($type == 'email') {
            $credential = array('email' => $val);
        }
        if ($type == 'mobile') {
            $credential = array('mobile' => $val);
        }
        $query = $this->db->get_where('vendor', $credential);
        if ($query->num_rows() > 0) {
            $result = FALSE;
        }
        return $result;
    }

    function getVendorTableData($postData) {
        $sql = $this->get_datatables_vendors_query($postData);
        if (isset($postData['length']) && $postData['length'] != -1) {
            $sql .= ' LIMIT ' . $postData['length'] . ' OFFSET ' . $postData['start'];
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getVendorTableSearchData($postData) {
        $sql = $this->get_datatables_vendors_query($postData);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_datatables_vendors_query($postData) {
        $column_order = array('', '', 'a.name', 'a.email', 'a.mobile', 'a.company', 'a.birthdate', 'a.address', 'a.created_date', 'a.status', 'a.verified', 'a.vendor_status');
        $sql = "SELECT a.* FROM (SELECT *, DATE_FORMAT(creation_datetime, '%d/%m/%Y %h:%i %p') as created_date, 
                IF(birth_date, DATE_FORMAT(birth_date, '%d/%m/%Y'), '') as birthdate,
                IF(mobile_verified = 1, 'Yes', 'No') as verified, IF(status = 1, 'Active', 'Inactive') as vendor_status
                FROM vendor) a WHERE 1=1 ";
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
    
    public function getAllProduct() {
        $this->db->where('status', 1);
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('category')->result();
    }
    
    public function addVendorPurchase($data) {
        $this->db->insert('vendor_purchase', $data);
        return $this->db->insert_id();
    }
    
    public function updateVendorPurchase($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('vendor_purchase', $data);
    }
    
    public function getAllVendorPurchase() {
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('vendor_purchase')->result();
    }
    
    public function getVendorPurchaseById($id) {
        $this->db->where('id', $id);
        return $this->db->get('vendor_purchase')->row();
    }
    
    public function getProductById($id) {
        $this->db->where('category_id', $id);
        return $this->db->get('category')->row();
    }
    
    public function deleteVendorPurchase($id) {
        $this->db->where('id', $id);
        return $this->db->delete('vendor_purchase');
    }
}
