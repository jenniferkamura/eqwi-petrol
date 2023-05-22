<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function addAdmin($data) {
        $this->db->insert('admin', $data);
        return $this->db->insert_id();
    }

    public function getAdmin() {
        $this->db->where('status', 1);
        return $this->db->get('admin')->result();
    }

    public function getAdminById($id) {
        $this->db->where('admin_id', $id);
        return $this->db->get('admin')->row();
    }

    public function updateAdmin($id, $data) {
        $this->db->where('admin_id', $id);
        return $this->db->update('admin', $data);
    }

    public function deleteAdmin($id) {
        $this->db->where('admin_id', $id);
        $this->db->where('is_super_admin', 0);
        return $this->db->delete('admin');
    }

    function create_backup() {
        $this->load->dbutil();
        $options = array(
            'format' => 'txt',
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );
        $tables = array();
        $file_name = 'db_backup_' . date('Y-m-d-H-i-s');
        $backup = $this->dbutil->backup(array_merge($options, $tables));
        write_file('db_backup/' . $file_name . '.sql', $backup);
        //$this->load->helper('download');
        //force_download($file_name.'.sql', $backup);
        return true;
    }

    function restore_backup() {

        move_uploaded_file($_FILES['backup_file']['tmp_name'], 'uploads/backup.sql');
        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );

        $schema = htmlspecialchars(file_get_contents($prefs['filepath']));

        $query = rtrim(trim($schema), "\n;");

        $query_list = explode(";", $query);
        $this->truncate();

        foreach ($query_list as $query) {
            $this->db->query($query);
        }
        //$restore =& $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    public function addLogs($data) {
        return $this->db->insert('logs', $data);
    }

    public function getAllLogs() {
        $this->db->order_by('date_time', 'DESC');
        return $this->db->get('logs')->result();
    }

    public function addRole($data) {
        $this->db->insert('role', $data);
        return $this->db->insert_id();
    }

    public function getAllRole() {
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('role')->result();
    }

    public function getRoleById($id) {
        $this->db->where('id', $id);
        return $this->db->get('role')->row();
    }

    public function updateRole($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('role', $data);
    }

    public function deleteRole($id) {
        $this->db->where('id', $id);
        return $this->db->delete('role');
    }
    
    public function getALLSubAdmin() {
        $this->db->select('a.*, r.role_name');
        $this->db->where('a.is_super_admin', 0);
        $this->db->join('role r', 'r.id = a.role_id', 'left');
        return $this->db->get('admin a')->result();
    }
    
    public function addPrivilege($data, $id) {
        if ($id) {
            $data['updated_date'] = DATETIME;
            $this->db->where('id', $id);
            $this->db->update("admin_user_privileges", $data);
        } else {
            $data['created_date'] = DATETIME;
            $this->db->insert("admin_user_privileges", $data);
        }
    }
    
    public function deleteSubAdmin($id) {
        $this->db->where('admin_id', $id);
        $this->db->delete('admin_user_privileges');
        $this->deleteAdmin($id);
        return true;
    }
}
