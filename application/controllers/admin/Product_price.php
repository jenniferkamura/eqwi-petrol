<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_price extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Price List';
        $this->load->model('price_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/product_price");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/product_price/index';
        
        $from_date = $to_date = '';
        if ($this->input->post()) {
            
            $this->data['from_date'] = $_from_date = $this->input->post('from_date');
            $this->data['to_date'] = $_to_date = $this->input->post('to_date');

            if ($_from_date) {
                $old_from_date = explode('/', $_from_date);
                $from_date = (isset($old_from_date[2]) ? $old_from_date[2] : date('Y')) . '-' . $old_from_date[1] . '-' . $old_from_date[0];
            }
            if ($_to_date) {
                $old_to_date = explode('/', $_to_date);
                $to_date = (isset($old_to_date[2]) ? $old_to_date[2] : date('Y')) . '-' . $old_to_date[1] . '-' . $old_to_date[0];
            }
        }

        $this->data['product_price_data'] = $this->price_model->getAllProductPrice($from_date, $to_date);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit() {
        if ($this->data['privilege']->add_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $this->data['title'] = 'Price';
        $this->data['page'] = "Update Price";
        $this->data['view'] = 'admin/product_price/edit';

        if ($this->input->post()) {
            
            $product_id = $this->input->post('product_id');
            $price = $this->input->post('price');
            
            $price_added = 0;
            if ($product_id) {
                foreach ($product_id as $key => $value) {

                    if (trim($price[$key])) { 
                        $data = array();
                        $data['category_id'] = $product_id[$key];
                        $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
                        $data['price'] = $price[$key];
                        $data['price_date'] = date('Y-m-d');
                        $data['date_time'] = DATETIME;

                        $this->price_model->addProductPrice($data);
                        $price_added = 1;
                         
                        $this->price_model->updateAllCartDataById($product_id[$key], $price[$key]);
                    }
                }
            }

            if ($price_added) {
                $this->session->set_flashdata('success', "Price updated successfully!");
            } else {
                $this->session->set_flashdata('error', "Price not updated!");
            }
            redirect("admin/product_price");
        }

        $this->data['product_data'] = $this->price_model->getAllProduct();
        $this->load->view('admin/admin_master', $this->data);
    }

    /* public function edit() {
      if ($this->data['privilege']->add_p == 0) {
      $this->session->set_flashdata('error', $this->privilege_error);
      redirect('admin/errors');
      }
      $this->data['title'] = 'Price';
      $this->data['page'] = "Add " . $this->data['title'];
      $this->data['view'] = 'admin/product_price/edit';

      if ($this->input->post()) {

      $this->form_validation->set_rules("product_id", "Product Name", "required", array('required' => 'Product name cannot be empty'));
      $this->form_validation->set_rules("price", "Price", "required", array('required' => 'Price cannot be empty'));
      if ($this->form_validation->run() == FALSE) {

      $form_data = array('product_id', 'price');
      $error_messages = $this->common_model->form_validation_message($form_data);
      $this->session->set_flashdata('error', $error_messages);
      redirect("admin/product_price");
      }

      $product_id = trim($this->input->post('product_id'));
      $price = trim($this->input->post('price'));
      $status = trim($this->input->post('status'));

      $data = array();
      $data['category_id'] = $product_id;
      $data['currency'] = $this->common_model->getSiteSettingByTitle('currency_symbol');
      $data['price'] = $price;
      $data['price_date'] = date('Y-m-d');
      $data['status'] = $status;
      $data['date_time'] = DATETIME;

      $this->price_model->addProductPrice($data);
      $this->session->set_flashdata('success', "Price added successfully!");
      redirect("admin/product_price");
      }

      $this->data['product_data'] = $this->price_model->getAllProduct();
      $this->load->view('admin/admin_master', $this->data);
      }

      public function delete($id) {
      if ($this->data['privilege']->delete_p == 0) {
      $this->session->set_flashdata('error', $this->privilege_error);
      redirect('admin/errors');
      }
      if ($id > 0) {
      $this->price_model->deleteProductPrice($id);
      $this->session->set_flashdata('success', 'Price deleted successfully!');
      }
      redirect("admin/product_price");
      } */
}
