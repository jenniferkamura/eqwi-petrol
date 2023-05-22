<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->data['page'] = 'Home';
        $this->data['title'] = 'Home';
    }

    function index() {
        if(checkadminlogin()){
            redirect('admin/home');
        }else{
            redirect('admin/login');
        }
    }
    
    function google_login() {
        
    }
}
