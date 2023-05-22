<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = '404 Error Page';
    }

    public function index() {
        $this->data['view'] = 'admin/error_404';
        $this->load->view('admin/admin_master', $this->data);
    }
}
