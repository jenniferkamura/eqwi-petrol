<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct(); 
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Products';
        $this->load->model('product_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/product");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/product/index';
        $this->data['product_data'] = $this->product_model->getAllProduct();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $this->data['title'] = 'Product';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/product/edit';

        if ($this->input->post()) {
            
            $this->form_validation->set_rules("product_name", "Product Name", "required", array('required' => 'Product name cannot be empty'));
            $this->form_validation->set_rules("product_type", "Product Type", "required", array('required' => 'Product type cannot be empty'));
            $this->form_validation->set_rules("measurement", "Measurement", "required", array('required' => 'Measurement cannot be empty'));
            $this->form_validation->set_rules("display_order", "Display Order", "required", array('required' => 'Display order cannot be empty'));
            
            if ($this->form_validation->run() == FALSE) {
                
                $form_data = array('product_name', 'product_type', 'measurement', 'display_order');                
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/product");
            }
            
            $product_id = trim($this->input->post('product_id'));
            $product_name = trim($this->input->post('product_name'));
            $product_type = trim($this->input->post('product_type'));
            $measurement = trim($this->input->post('measurement'));
            $minimum_order_qty = trim($this->input->post('minimum_order_qty'));
            $display_order = trim($this->input->post('display_order'));
            $status = trim($this->input->post('status'));

            $data = array();
            $data['name'] = $product_name;
            $data['type'] = $product_type;
            $data['measurement'] = $measurement;
            $data['minimum_order_qty'] = $minimum_order_qty;
            $data['display_order'] = $display_order;
            $data['status'] = $status;
            
            if (!empty($_FILES['product_image'])) {

                if (!file_exists(PRODUCT_IMG))
                    mkdir(PRODUCT_IMG);

                $ext = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
                $product_image = 'product_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['product_image']['tmp_name'], PRODUCT_IMG . $product_image)) {
                    $data['image'] = $product_image;
                }
            }
            
            if ($product_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->product_model->updateProduct($product_id, $data);
                $this->session->set_flashdata('success', "Product updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $product_id = $this->product_model->addProduct($data);
                $this->session->set_flashdata('success', "Product added successfully!");
            }
            redirect("admin/product");
        }
        
        $this->data['product_data'] = $this->product_model->getProductById($id);
        $this->data['last_display_order'] = $this->common_model->getLastDisplayOrder('category');
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            
            $where_related = array(
                'category_id' => $id,
            );
            $check = $this->common_model->check_delete_data('cart_order_details', $where_related);
            
            if (!$check) {
                $this->product_model->deleteProduct($id);
                $this->session->set_flashdata('success', 'Product deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Product is already use in orders, you can not delete this product!');
            }
        }
        redirect("admin/product");
    }

}
