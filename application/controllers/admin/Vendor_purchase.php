<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_purchase extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Vendor Purchase';
        $this->load->model('vendor_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/vendor_purchase");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/vendor_purchase/index';
        $this->data['vendor_purchase'] = $this->vendor_model->getAllVendorPurchase();
        $this->load->view('admin/admin_master', $this->data);
    }
    
    public function edit($id) {

        if (($id == 0 && $this->data['privilege']->add_p == 0) || ($id && $this->data['privilege']->edit_p == 0)) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }

        $this->data['title'] = 'Vendor Purchase';
        $this->data['page'] = ($id ? "Edit " : "Add ") . $this->data['title'];
        $this->data['view'] = 'admin/vendor_purchase/edit';

        if ($this->input->post()) {
            
            $vendor_id = trim($this->input->post('vendor_id'));

            $this->form_validation->set_rules("vendor_id", "Vendor Name", "required", array('required' => 'Vendor Name cannot be empty'));
            $this->form_validation->set_rules("product_id", "Product Name", "required", array('required' => 'Product Name cannot be empty'));
            $this->form_validation->set_rules("invoice_no", "Invoice Number", "required", array('required' => 'Invoice number cannot be empty'));
            $this->form_validation->set_rules("invoice_date", "Invoice Date", "required", array('required' => 'Invoice date cannot be empty'));
            //$this->form_validation->set_rules("inward_date", "Inward Date", "required", array('required' => 'Inward date cannot be empty'));
            $this->form_validation->set_rules("amount", "Amount", "required", array('required' => 'Amount cannot be empty'));

            if ($this->form_validation->run() == FALSE) {

                $form_data = array('vendor_id', 'product_id', 'invoice_no', 'invoice_date', 'amount');
                $error_messages = $this->common_model->form_validation_message($form_data, 1);
                $this->session->set_flashdata('error', $error_messages);
                redirect("admin/vendor");
            }

            $vendor_purchase_id = trim($this->input->post('vendor_purchase_id'));
            $vendor_id = trim($this->input->post('vendor_id'));
            $product_id = trim($this->input->post('product_id'));
            $invoice_no = trim($this->input->post('invoice_no'));
            $_invoice_date = trim($this->input->post('invoice_date'));
            //$_inward_date = trim($this->input->post('inward_date'));
            $amount = trim($this->input->post('amount'));

            $invoice_date = $inward_date = NULL;
            if ($_invoice_date) {
                $old_invoice_date = explode('/', $_invoice_date);
                $invoice_date = (isset($old_invoice_date[2]) ? $old_invoice_date[2] : date('Y')) . '-' . $old_invoice_date[1] . '-' . $old_invoice_date[0];
            }
            /*if ($_inward_date) {
                $old_inward_date = explode('/', $_inward_date);
                $inward_date = (isset($old_inward_date[2]) ? $old_inward_date[2] : date('Y')) . '-' . $old_inward_date[1] . '-' . $old_inward_date[0];
            }*/
            
            $vendor_data = $this->vendor_model->getVendorById($vendor_id);
            $product_data = $this->vendor_model->getProductById($product_id);
            
            $data = array();
            $data['vendor_id'] = $vendor_id;
            $data['product_id'] = $product_id;
            $data['invoice_no'] = $invoice_no;
            $data['invoice_date'] = $invoice_date;
            //$data['inward_date'] = $inward_date;
            $data['amount'] = $amount;
            $data['vendor_data'] = $vendor_data ? json_encode($vendor_data) : '';
            $data['product_data'] = $product_data ? json_encode($product_data) : '';
            
            if (!empty($_FILES['invoice_attach'])) {

                if (!file_exists(INVOICE_IMAGE))
                    mkdir(INVOICE_IMAGE);

                $ext = pathinfo($_FILES['invoice_attach']['name'], PATHINFO_EXTENSION);
                $invoice_image = 'inv_' . rand(111, 999) . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['invoice_attach']['tmp_name'], INVOICE_IMAGE . $invoice_image)) {
                    $data['invoice_attach'] = $invoice_image;
                }
            }

            if ($vendor_purchase_id > 0) {
                $data['updated_date'] = DATETIME;
                $this->vendor_model->updateVendorPurchase($vendor_id, $data);
                $this->session->set_flashdata('success', "Vendor purchase updated successfully!");
            } else {
                $data['created_date'] = DATETIME;
                $vendor_id = $this->vendor_model->addVendorPurchase($data);
                $this->session->set_flashdata('success', "Vendor purchase added successfully!");
            }
            redirect("admin/vendor_purchase");
        }

        $this->data['vendor_data'] = $this->vendor_model->getAllVendor(1);
        $this->data['product_data'] = $this->vendor_model->getAllProduct();
        $this->data['vendor_purchase'] = $this->vendor_model->getVendorPurchaseById($id);
        $this->data['vendor_purchase_id'] = isset($this->data['vendor_purchase']) && $this->data['vendor_purchase']->id ? $this->data['vendor_purchase']->id : 0;
        $this->load->view('admin/admin_master', $this->data);
    }

    public function export_csv() {
        $filename = 'export_volunteer_' . date('Ymd') . time();
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$filename.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, array('Sr', 'Vendor Name', 'Gender', 'Email', 'Mobile', 'Verified', 'Company', 'Date of Birth', 'Address', 'Created Date', 'Status'));

        $vendor_data = $this->vendor_model->getAllVendor();
        $i = 0;
        foreach ($vendor_data as $value) { 
            $i++;
            $verified = $value->mobile_verified == 1 ? 'Yes' : 'No';
            $vendor_list = array($i, $value->name, $value->gender, $value->email, $value->mobile, $verified, $value->company, $value->birth_date, $value->address, $value->creation_datetime, ($value->status ? 'Active' : 'Inactive'));
            fputcsv($output, $vendor_list);
        }
        fclose($output);
    }

    public function delete($id) {

        if ($this->data['privilege']->delete_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
        if ($id > 0) {
            $this->vendor_model->deleteVendorPurchase($id);
            $this->session->set_flashdata('success', 'Vendor purchase deleted successfully!');
        }
        redirect("admin/vendor_purchase");
    }
}
