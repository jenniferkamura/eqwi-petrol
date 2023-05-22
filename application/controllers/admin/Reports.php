<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    private $privilege_error;

    function __construct() {
        parent::__construct();
        checkadminlogin();
        $this->data['page'] = '';
        $this->data['title'] = 'Reports';
        $this->load->model('report_model');

        $admin_id = $this->session->userdata(PROJECT_NAME . '_user_data')->admin_id;
        $this->data['privilege'] = $this->common_model->get_menu_privilege($admin_id, "admin/reports");
        $this->privilege_error = 'You do not have rights for this module, please contact super admin!';

        if ($this->data['privilege']->list_p == 0) {
            $this->session->set_flashdata('error', $this->privilege_error);
            redirect('admin/errors');
        }
    }

    public function index() {
        $this->data['view'] = 'admin/report/index';
        
        $user_id = $from_date = $to_date = '';
        if ($this->input->post()) {
            
            $this->data['user_id'] = $user_id = $this->input->post('user_id');
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
        
        $this->data['user_data'] = $this->report_model->getOwners();
        $this->data['transaction_data'] = $this->report_model->getAllTransaction($user_id, $from_date, $to_date);
        $this->load->view('admin/admin_master', $this->data);
    }
    
    public function export_csv() {
        
        $user_id = $from_date = $to_date = '';
        if ($this->input->post()) {
            
            $this->data['user_id'] = $user_id = $this->input->post('user_id');
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
        
        $filename = 'csv_reports_' . date('Ymd') . time();
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$filename.csv");

        $output = fopen("php://output", "w");
        fputcsv($output, array('Sr', 'Order Id', 'Name', 'Product', 'Shipping Charge', 'Tax', 'Amount', 
            'Total Amount', 'Total Pay Amount', 'Remaining Amount', 'Order Date'));

        $transaction_data = $this->report_model->getAllTransaction($user_id, $from_date, $to_date);
        $i = 0;
        foreach ($transaction_data as $value) {
            $i++;
            $report_list = array($i, $value->order_id, $value->name . ' (' . $value->mobile . ')', 
                $value->product_name, ($value->currency .' '. $value->shipping_charge), ($value->currency . ' ' . $value->tax), 
                ($value->currency .' '. $value->amount) . (($value->discount != 0.00) ? ' Discount: ' . ($value->currency . ' ' . $value->discount) : ''), 
                ($value->currency .' '. $value->total_amount), ($value->currency .' '. $value->trans_amount), 
                ($value->currency .' '. $value->remaining_amt), date('d/m/Y', strtotime($value->order_date)));
            fputcsv($output, $report_list);
        }
        fclose($output);
    }
    
    public function export_pdf() {
        
       $this->load->library('fpdf_lib');

        //$pdf = new Fpdf_lib(); 
        $this->fpdf_lib->AddPage();
        $this->fpdf_lib->SetFont('Arial', 'B', 9);
                 
        $this->fpdf_lib->SetWidths(array(8,16,22,16,17,14,21,21,21,20,20));
        $header = array('Sr', 'Order Id', 'Name', 'Product', 'Shipping Charge', 'Tax', 'Amount', 
            'Total Amount', 'Total Pay Amount', 'Remaining Amount', 'Order Date');
        
        $this->fpdf_lib->Row($header);
        $this->fpdf_lib->SetFont('Arial', '', 9);
        
        $user_id = $from_date = $to_date = '';
        if ($this->input->post()) {
            
            $this->data['user_id'] = $user_id = $this->input->post('user_id');
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

        $transaction_data = $this->report_model->getAllTransaction($user_id, $from_date, $to_date);
        $i = 0;
        foreach ($transaction_data as $value) {
            $i++; 
            $report_list = array($i, $value->order_id, $value->name . ' (' . $value->mobile . ')', 
                $value->product_name, ($value->currency .' '. $value->shipping_charge), ($value->currency .' '. $value->tax), 
                ($value->currency .' '. $value->amount) . (($value->discount != 0.00) ? ' Discount: ' . ($value->currency .' '. $value->discount) : ''), 
                ($value->currency .' '. $value->total_amount), ($value->currency .' '. $value->trans_amount), 
                ($value->currency .' '. $value->remaining_amt), date('d/m/Y', strtotime($value->order_date)));
            $this->fpdf_lib->Row($report_list);
        }
        $filename = 'pdf_reports_' . date('Ymd') . time() . '.pdf'; 
        $this->fpdf_lib->Output($filename, 'D');
    }
}
