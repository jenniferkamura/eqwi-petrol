<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_model extends CI_Model {

    public function addVehicle($data) {
        $this->db->insert('vehicle', $data);
        return $this->db->insert_id();
    }

    public function getAllVehicle($status = 0) {
        if ($status) {
            $this->db->where('v.status', $status);
        }
        $this->db->select('v.*, u.name, u.mobile');
        $this->db->join('user u', 'u.user_id = v.user_id', 'INNER');
        $this->db->order_by('v.created_date', 'DESC');
        return $this->db->get('vehicle v')->result();
    }

    public function getVehicleById($id, $status = 1) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->where('vehicle_id', $id);
        $data = $this->db->get('vehicle')->row();
        if($data){
            $data->document_type = 'Driving License';
            $data->license_number = '';
            $data->driving_license = '';
            $data->driving_license_url = getImage('user_documents', '');
            $data->front_vehicle_photo_url = getImage('vehicle_photo', $data->front_vehicle_photo);
            $data->back_vehicle_photo_url = getImage('vehicle_photo', $data->back_vehicle_photo);
            $data->left_vehicle_photo_url = getImage('vehicle_photo', $data->left_vehicle_photo);
            $data->right_vehicle_photo_url = getImage('vehicle_photo', $data->right_vehicle_photo);
            $data->vehicle_document_url = getImage('vehicle_photo', $data->vehicle_document);
            if($document = $this->db->get_where('user_documents', ['user_id' => $data->user_id])->row()){
                $data->license_number = $document->document_number;
                $data->driving_license = $document->front_photo;
                $data->driving_license_url = getImage('user_documents', $document->front_photo);
            }
        }
        return $data;
    }

    public function addVehicleDetail($data) {
        $this->db->insert('vehicle_detail', $data);
        return $this->db->insert_id();
    }

    public function getVehicleDetailById($id) {
        $this->db->where('vehicle_id', $id);
        return $this->db->get('vehicle_detail')->result();
    }

    public function updateVehicle($id, $data) {
        $this->db->where('vehicle_id', $id);
        return $this->db->update('vehicle', $data);
    }

    public function deleteVehicle($id) {
        $this->db->where('vehicle_id', $id);
        return $this->db->delete('vehicle');
    }

    public function deleteVehicleDetail($id) {
        $this->db->where('vehicle_id', $id);
        return $this->db->delete('vehicle_detail');
    }

    public function getAllTransporters($id = 0) {
        $this->db->where('u.status', 1);
        $this->db->where('u.user_type', 'Transporter');
        if ($id) {
            $this->db->where("(u.user_id NOT IN(SELECT v.user_id FROM vehicle v WHERE v.status = 1 AND v.user_id = u.user_id) OR u.user_id = $id)");
        } else {
            $this->db->where("u.user_id NOT IN(SELECT v.user_id FROM vehicle v WHERE v.status = 1 AND v.user_id = u.user_id)");
        }
        $this->db->order_by('u.created_date', 'DESC');
        return $this->db->get('user u')->result();
    }

    public function getOrderDetail($user_id = '', $from_date = '', $to_date = '', $status = '') {
        
        $where = "";
        if ($user_id != '') {
            $where .= " AND o.transporter_id = $user_id";
        }
        if ($from_date != '') {
            $where .= " AND o.delivery_date >= '$from_date'";
        }
        if ($to_date != '') {
            $where .= " AND o.delivery_date <= '$to_date'";
        }
        if ($status != '') {
            $where .= " AND o.order_status = '$status'";
        }
        
        return $this->db->query("SELECT o.*, p.product_name, p.total_qty, u.name, u.mobile, v.vehicle_capacity, 
            s.station_name, s.address, s.city, s.state, s.country
            FROM cart_orders o
            LEFT JOIN (SELECT cart_order_id, GROUP_CONCAT(`name` SEPARATOR ', ') AS product_name,
                SUM(qty) as total_qty
                FROM `cart_order_details` GROUP BY cart_order_id) p ON p.cart_order_id = o.id
            LEFT JOIN `user` u ON u.user_id = o.transporter_id
            LEFT JOIN `vehicle` v ON v.user_id = o.transporter_id AND v.status = 1
            LEFT JOIN `station` s ON s.station_id = o.station_id AND s.status = 1
            WHERE o.is_order = 1 AND o.order_status != 'Completed' AND o.order_status != 'Cancelled'  $where
            ORDER BY o.delivery_date DESC, o.delivery_time DESC")->result();
    }
    
    public function getAllUser($user_type) {
        $this->db->where('u.status', '1');
        $this->db->where('u.user_type', $user_type);
        $this->db->order_by('u.created_date', 'DESC');
        return $this->db->get('user u')->result();
    }
}
