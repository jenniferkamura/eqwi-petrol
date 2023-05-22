<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Menu';
    }

    public function index($type = 'main') {
        $this->data['title'] = ucfirst($type) . ' Menu';
        $this->data['view'] = 'admin/menu/index';
        
        $menu_data = $this->common_model->getAllMenu($type);
        if($menu_data){
            foreach ($menu_data as $key => $value) {
                $menu_data[$key] = $value;
                
                $menu_type = '';
                if($value->menu_id && $menu = $this->common_model->getMenuById($value->menu_id)){
                    $menu_type = $menu->menu_name;
                }
                $menu_data[$key]->menu_type = $menu_type;
            }
        }
        
        $this->data['menu_type'] = $type;        
        $this->data['menu_data'] = $menu_data;
        $this->load->view('admin/admin_master', $this->data);
    }
    
    public function edit($type = 'main', $id) {
        $this->data['title'] = ucfirst($type) . ' Menu';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/menu/edit';

        if ($this->input->post()) {

            $this->form_validation->set_rules("menu_name", "Menu Name", "required", array('required' => 'Menu Name cannot be empty'));
           
            if ($this->form_validation->run() == FALSE) {
                $errors = [
                    "menu_name" => strip_tags(form_error("menu_name"))
                ];
                $single_line_message = "";
                if (form_error("menu_name")) {
                    $single_line_message .= strip_tags(form_error("menu_name"));
                }
                $this->session->set_flashdata('error', $single_line_message);
                redirect("admin/menu");
            }

            $menu_id = trim($this->input->post('menu_id'));
            $parent_id = trim($this->input->post('parent_id'));
            $menu_name = trim($this->input->post('menu_name'));
            $menu_url = trim($this->input->post('menu_url'));
            $menu_icon = trim($this->input->post('menu_icon'));
            $display_order = trim($this->input->post('display_order'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['menu_id'] = $parent_id;
            $data['menu_name'] = $menu_name;
            $data['menu_url'] = $menu_url;
            $data['menu_icon'] = $menu_icon;
            $data['display_order'] = $display_order;
            $data['status'] = $status;
            
            if ($menu_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->common_model->updateMenu($menu_id, $data);
                $this->session->set_flashdata('success', "Menu updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $this->common_model->addMenu($data);
                $this->session->set_flashdata('success', "Menu added successfully!");
            }
            if($parent_id && $sub_ids = $this->common_model->getAllSubMenuByMenuId($parent_id)){
                $this->common_model->updateMenu($parent_id, array('sub_ids' => $sub_ids->ids));
            }

            if($type == 'main'){
                redirect("admin/main_menu");
            }else{
                redirect("admin/sub_menu");
            }
        }
        
        $this->data['menu_type'] = $type;
        $this->data['main_menu'] = $this->common_model->getMainMenu($id);
        $this->data['menu_data'] = $this->common_model->getMenuById($id);
        $this->data['menu_id'] = isset($this->data['menu_data']) && $this->data['menu_data']->id ? $this->data['menu_data']->id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }
}
