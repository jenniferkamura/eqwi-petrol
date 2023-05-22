<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_notifications extends CI_Controller {

    private $privilege_error;
    private $admin_id;
    
    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Admin Send Notifications';

        $this->admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($this->admin_id, "admin/admin_notifications");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/notifications/admin_notifications';
        $this->data['notification_data'] = $this->common_model->getAdminNotifications($this->admin_id);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function alert() {
        $this->data['title'] = 'Admin Alerts';
        $this->data['view'] = 'admin/notifications/admin_alert';
        $this->data['notification_data'] = $this->common_model->getAllNotifications();
        
        $this->db->where('is_custom', '0');
        $this->db->where('admin_read', '0');
        $this->db->update('notifications', array('admin_read' => 1));
        $this->load->view('admin/admin_master', $this->data);
    }
}
