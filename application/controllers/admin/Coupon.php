<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller {

    private $privilege_error;
    
    function __construct() {
        parent::__construct(); 
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Coupons';
        $this->load->model('coupon_model');
        
        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/coupon");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/coupon/index';
        $this->data['coupon_data'] = $this->coupon_model->getAllCoupon();
        $this->load->view('admin/admin_master', $this->data);
    }

    public function edit($id) {
        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        $this->data['title'] = 'Coupon';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/coupon/edit';

        if ($this->input->post()) {
            
            $is_discount = trim($this->input->post('is_discount'));
            
            //$this->form_validation->set_rules("product_id", "Product Name", "required", array('required' => 'Product name cannot be empty'));
            $this->form_validation->set_rules("coupon_title", "Coupon Title", "required", array('required' => 'Coupon title cannot be empty'));
            $this->form_validation->set_rules("start_date", "Start Date", "required", array('required' => 'Start Date cannot be empty'));
            $this->form_validation->set_rules("end_date", "End Date", "required", array('required' => 'End Date cannot be empty'));
            
            if($is_discount){
                $this->form_validation->set_rules("discount", "Discount", "required", array('required' => 'Discount cannot be empty'));
                $this->form_validation->set_rules("on_amount", "Discount on amount", "required", array('required' => 'Discount on amount cannot be empty'));
            }
            
            if ($this->form_validation->run() == FALSE) {
                
                $form_data = array('coupon_title', 'start_date', 'end_date', 'discount', 'on_amount');                
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/coupon");
            }
            
            $coupon_id = trim($this->input->post('coupon_id'));
            //$product_id = trim($this->input->post('product_id'));
            $coupon_title = trim($this->input->post('coupon_title'));
            $description = trim($this->input->post('description'));
            $discount = trim($this->input->post('discount'));
            $on_amount = trim($this->input->post('on_amount'));
            $status = trim($this->input->post('status'));
            
            $start_date = '';
            if ($_start_date = trim($this->input->post('start_date'))) {
                $old_start_date = explode('/', $_start_date);
                $start_date = (isset($old_start_date[2]) ? $old_start_date[2] : date('Y')) . '-' . $old_start_date[1] . '-' . $old_start_date[0];
            }
            
            $end_date = '';
            if ($_end_date = trim($this->input->post('end_date'))) {
                $old_end_date = explode('/', $_end_date);
                $end_date = (isset($old_end_date[2]) ? $old_end_date[2] : date('Y')) . '-' . $old_end_date[1] . '-' . $old_end_date[0];
            }

            //$product_data = $this->coupon_model->getProductById($product_id);
            
            $data = array();
            //$data['product_id'] = $product_id;
            $data['coupon_title'] = $coupon_title;
            $data['description'] = $description;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['is_discount'] = $is_discount;
            $data['discount'] = $is_discount ? $discount : '';
            $data['on_amount'] = $is_discount ? $on_amount : '';
            //$data['product_data'] = $product_data ? json_encode($product_data) : '';
            $data['status'] = $status;
            
            if ($coupon_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->coupon_model->updateCoupon($coupon_id, $data);
                $this->session->set_flashdata('success', "Coupon updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $coupon_id = $this->coupon_model->addCoupon($data);
                
                $coupon_code = 'C' . rand(0000, 9999) . $coupon_id;
                $this->coupon_model->updateCoupon($coupon_id, array('coupon_code' => $coupon_code));
                $this->session->set_flashdata('success', "Coupon added successfully!");
            }
            redirect("admin/coupon");
        }
        
        $this->data['product_data'] = $this->coupon_model->getAllProduct();
        $this->data['coupon_data'] = $this->coupon_model->getCouponById($id);
        $this->load->view('admin/admin_master', $this->data);
    }

    public function delete($id) {
        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->coupon_model->deleteCoupon($id);
            $this->session->set_flashdata('success', 'Coupon deleted successfully!');
        }
        redirect("admin/coupon");
    }

}
