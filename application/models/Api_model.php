<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function checkVerifyLogin($data = array()) {
        if ($data) {
            $this->db->group_start();
            $this->db->where('email', $data['email']);
            $this->db->or_where('login_id', $data['email']);
            $this->db->group_end();
            $this->db->where('password', md5($data['password']));
            return $this->db->get('user')->row();
        } else {
            return false;
        }
    }
    
    public function checkSocialLogin($data = array(), $auth_provider = 'Google') {
        if ($data) {
            $this->db->where('email', $data['email']);
            if($auth_provider == 'Google'){
                $this->db->where('google_auth_id', $data['auth_id']);
            }
            if($auth_provider == 'Facebook'){
                $this->db->where('facebook_auth_id', $data['auth_id']);
            }
            $this->db->where('auth_provider', $auth_provider);
            return $this->db->get('user')->row();
        } else {
            return false;
        }
    }

    public function checkVerifyMobile($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('mobile_verified', 1);
        return $this->db->get('user')->num_rows();
    }

    public function checkUserToken($user_id = 0, $user_token) {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('user_token', $user_token);
        return $this->db->get('user')->row();
    }

    public function checkUserStatus($mobile) {
        $this->db->where('mobile', $mobile);
        return $this->db->get('user')->row();
    }

    public function check_token($token, $type) {
        $data = false;
        if ($type == 'forgot') {
            $this->db->where('forgot_token', $token);
            $data = $this->db->get('user')->row();
        }
        if ($type == 'register') {
            $this->db->where('user_token', $token);
            $data = $this->db->get('user')->row();
        }
        return $data;
    }

    public function getUserById($id, $station = 0) {
        $this->db->select('user_id, login_id, name, email, mobile, address, station_id, mobile_verified, payment_option, otp_code,
                latitude, longitude, profile_pic, user_token, user_type, transporter_available, vehicle_id, currency, wallet_balance');
        $this->db->where('status', 1);
        $this->db->where('user_id', $id);
        $data = $this->db->get('user')->row();
        if ($data) {

            $data->profile_pic_url = getImage('user', $data->profile_pic);
            if ($data->user_type == 'Transporter') {

                unset($data->currency);
                unset($data->wallet_balance);
                unset($data->payment_option);

                $data->document_type = 'Driving License';
                $data->license_number = $data->driving_license_url = $data->vehicle_document_url = '';
                $data->front_vehicle_photo_url = $data->back_vehicle_photo_url = '';
                $data->left_vehicle_photo_url = $data->right_vehicle_photo_url = '';
                
                $vehicle_number = $vehicle_capacity = '';
                if ($data->vehicle_id) {
                    $vehicle = $this->db->get_where('vehicle', ['vehicle_id' => $data->vehicle_id, 'status' => 1])->row();
                    $vehicle_number = $vehicle ? $vehicle->vehicle_number : '';
                    $vehicle_capacity = $vehicle ? $vehicle->vehicle_capacity : '';
                    
                    $data->front_vehicle_photo_url = getImage('vehicle_photo', ($vehicle ? $vehicle->front_vehicle_photo : ''));
                    $data->back_vehicle_photo_url = getImage('vehicle_photo', ($vehicle ? $vehicle->back_vehicle_photo : ''));
                    $data->left_vehicle_photo_url = getImage('vehicle_photo', ($vehicle ? $vehicle->left_vehicle_photo : ''));
                    $data->right_vehicle_photo_url = getImage('vehicle_photo', ($vehicle ? $vehicle->right_vehicle_photo : ''));
                    $data->vehicle_document_url = getImage('vehicle_photo', ($vehicle ? $vehicle->vehicle_document : ''));
                    if($document = $this->db->get_where('user_documents', ['user_id' => $data->user_id])->row()){
                        $data->license_number = $document->document_number;
                        $data->driving_license_url = getImage('user_documents', $document->front_photo);
                    }
                }
                $data->vehicle_number = $vehicle_number;
                $data->vehicle_capacity = $vehicle_capacity;
                                
                $data->transporter_available = $this->common_model->getTransporterAvailability($data->user_id);
                
            } else {

                unset($data->vehicle_id);
                unset($data->transporter_available);

                if ($station) {
                    $data->station_count = count($this->getAllStation($data->user_id));
                }
            }
        }
        return $data;
    }

    public function sendOTPSMS($code, $mobile) {
        $message = "Your OTP Code is $code. \n Regards \n " . PROJECT_NAME;
        $template_id = '';
        send_message($message, $mobile, $template_id); 
    }
    
    public function sendOrderSMS($name, $order_id, $order_status, $mobile, $device_id) {
        $message = "Dear $name, your order $order_id is $order_status. \n Regards \n " . PROJECT_NAME;
        $template_id = '';
        //send_message($message, $mobile, $template_id);

        $data = array();
        $data['device_id'] = $device_id;
        $data['title'] = $order_status;
        $data['message'] = $message;
        $data['order_id'] = $order_id;
        $this->send_push_notification($data);
    }

    public function send_push_notification($data) {
        //Send Notification to Customer
        $cdata = array(
            "to" => $data['device_id'],
            "notification" => array(
                "title" => $data['title'],
                "body" => $data['message'],
                'image' => SITE_LOGO,
                'sound' => 'notification_sound',
                'vibrate' => 1
            ),
            "data" => [
                "title" => $data['title'],
                "message" => $data['message'],
                "order_id" => $data['order_id'],
            ]
        );

        $this->common_model->send_push_notification($cdata);
    }

    function getOrderByTitle($title = '', $search = '') {
        if ($title != '' && $search != '') {
            $this->db->order_by("CASE 
                    WHEN $title LIKE '$search' THEN 1
                    WHEN $title LIKE '$search%' THEN 2
                    WHEN $title LIKE '%$search' THEN 4
                    ELSE 3 END");
        }
    }

    public function getAllNotifications($user_id, $search = "", $limit, $page, $all = 0) {
        $this->db->select('id, title, message, date_time, is_read');
        $this->db->where('is_delete', '0');
        $this->db->where('user_id', $user_id);
        if ($search != "") {
            $this->db->group_start();
            $this->db->like("title", $search);
            $this->db->group_end();

            $this->getOrderByTitle('title', $search);
        }
        if ($all) {
            return $this->db->get('notifications')->num_rows();
        }

        $this->db->order_by('date_time', 'DESC');

        if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
            $offset = ((int) $page * $limit) - $limit;
            $this->db->limit($limit, $offset);
        else:
            $this->db->limit($limit);
        endif;

        $data = $this->db->get('notifications')->result();
        if ($data) {
            foreach ($data as $item) {
                $item->display_time = humanTiming($item->date_time);
            }
        }
        return $data;
    }

    public function getNotificationDetails($notification_id) {
        $this->db->select('id, title, message, date_time, is_read');
        $this->db->where('id', $notification_id);
        $this->db->where('is_delete', '0');
        $data = $this->db->get('notifications')->row();
        if ($data) {
            $data->display_time = humanTiming($data->date_time);
        }
        return $data;
    }

    public function getUnreadNotificationCounts($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        $this->db->where('is_delete', 0);
        return $this->db->get('notifications')->num_rows();
    }

    public function updateNotification($notification_id, $data, $user_id = 0, $all = 0) {
        if ($all && $user_id) {
            $this->db->where('user_id', $user_id);
        } else {
            $this->db->where('id', $notification_id);
        }
        return $this->db->update('notifications', $data);
    }

    public function deleteNotification($notification_id) {
        $this->db->where('id', $notification_id);
        return $this->db->delete('notifications');
    }

    public function deleteAllNotification($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('notifications');
    }

    public function addUserLogs($data) {
        return $this->db->insert('user_logs', $data);
    }

    public function getAllBoardingSlider() {
        $this->db->select('slider_id, title, description, image');
        $this->db->where('status', '1'); 
        $this->db->order_by('display_order', 'ASC');
        $data = $this->db->get('boarding_sliders')->result();
        if ($data) {
            foreach ($data as $item) {
                $item->image_path = getImage('boarding_slider', $item->image);
            }
        }
        return $data;
    }

    function getCategoryPrices() {
        //$this->db->select("id, category_id, currency, price");
        //$this->db->select("(SELECT name FROM category WHERE category_id = category_price.category_id) as category_name");
        //$this->db->select("(SELECT image FROM category WHERE category_id = category_price.category_id) as image");
        $this->db->where("status", 1);
        $this->db->order_by("display_order", 'asc');
        $data = $this->db->get("category")->result();

        if ($data) {
            foreach ($data as $item) {
                $item->image_path = getImage('product_image', $item->image);

                $price = $this->getTodayPrice($item->category_id);

                $item->price = $price ? $price->price : '';
                $item->currency = $price ? $price->currency : '';
            }
        }
        return $data;
    }

    public function getStations($lat = '', $lng = '') {
        $this->db->select('station_id, station_name, contact_person, contact_number, alternate_number, country, state, city');
        $this->db->select('pincode, landmark, address, latitude, longitude');
        $this->db->where('status', 1);
        return $this->db->get('station')->result();
    }

    public function addTable($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function updateTable($table, $key, $id, $data) {
        $this->db->where($key, $id);
        return $this->db->update($table, $data);
    }

    public function deleteTable($table, $key, $id) {
        $this->db->where($key, $id);
        return $this->db->delete($table);
    }

    public function getTableById($table, $key, $id, $status = 1, $image_dir = '', $image_key = '') {
        if ($status) {
            $this->db->where('status', 1);
        }
        $this->db->where($key, $id);
        $this->db->limit(1);
        $data = $this->db->get($table)->row();
        if ($data) {
            if ($image_dir != '' && $image_key != '') {
                $data->image_path = getImage($image_dir, $data->{$image_key});
            }
        }
        return $data;
    }

    public function getAllStation($id) {
        $this->db->where('owner_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('created_date', 'DESC');
        return $this->db->get('station')->result();
    }

    public function getTablePagination($table, $select = "*", $order_key = "", $order_by = "ASC", $where = array(), $search_arr = array(), $search = "", $limit = 0, $page = 1, $all = 0) {
        $this->db->select($select);
        if ($where) {
            $this->db->where($where);
        }
        $this->db->where('status', '1');
        if ($search != "") {
            $this->db->group_start();
            if ($search_arr) {
                foreach ($search_arr as $k => $search_key) {
                    if ($k == 0) {
                        $this->db->like($search_key, $search);
                    } else {
                        $this->db->or_like($search_key, $search);
                    }
                }
            }
            $this->db->group_end();

            //$this->getOrderByTitle($search_key, $search);
        }
        if ($all) {
            return $this->db->get($table)->num_rows();
        }

        if ($limit) {
            if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
                $offset = ((int) $page * $limit) - $limit;
                $this->db->limit($limit, $offset);
            else:
                $this->db->limit($limit);
            endif;
        }
        if ($order_key != '') {
            $this->db->order_by($order_key, $order_by);
        }
        return $this->db->get($table)->result();
    }

    public function getCategoryPrice($category_id) {

        $category = $this->getTableById('category', 'category_id', $category_id, 1, 'product_image', 'image');
        if ($category) {

            $price = $this->getTodayPrice($category_id);

            $category->price = $price ? $price->price : '';
            $category->currency = $price ? $price->currency : '';
        }
        return $category;
    }

    public function getTodayPrice($category_id) {

        $this->db->where('status', 1);
        $this->db->where('category_id', $category_id);
        $this->db->order_by('date_time', 'desc');
        $this->db->limit(1);
        return $this->db->get('category_price')->row();
    }

    public function countCartData($user_id) {

        $this->db->where('status', 0);
        $this->db->where('user_id', $user_id);
        return $this->db->get('carts')->num_rows();
    }

    public function getCartByCategoryId($user_id, $category_id) {

        $this->db->where('status', 0);
        $this->db->where('user_id', $user_id);
        $this->db->where('category_id', $category_id);
        return $this->db->get('carts')->row();
    }

    public function getCartData($user_id) {

        $this->db->where('status', 0);
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_date', 'asc');
        $data = $this->db->get('carts')->result();

        $amount = 0;
        if ($data) {
            foreach ($data as $item) {
                $item->image_path = getImage('product_image', $item->image);

                $amount += $item->total_price;
            }
        }
        return array('cart' => $data, 'amount' => $amount);
    }

    function generate_order_id($id, $prefix = '') {
        return $prefix . str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    function generate_auto_id($table, $key) {
        $id = date('y') . rand(111111, 999999) . generateRandomString(4);
        if ($this->db->get_where($table, [$key => $id])->num_rows() == 0) {
            return $id;
        } else {
            return $this->generate_auto_id($table, $key);
        }
    }

    function getCurrentOrders($user_id, $is_manager = 0) {
        /* $this->db->where('o.status', 0);
          $this->db->where('o.is_order', 1);
          $this->db->where('o.user_id', $user_id);
          $this->db->where("o.order_status != 'Rejected'");
          $this->db->where("o.order_status != 'Completed'");
          $this->db->join('station s', 's.station_id = o.station_id', 'left');
          $this->db->order_by('o.updated_date', 'desc');
          $this->db->get('cart_orders o')->result();


          $result = array();
          if ($data) {
          $i = 0;
          foreach ($data as $item) {
          if ($item->order_status == 'Processing') {
          $all_product_received = $this->checkOrderDetails($user_id, $item->id);
          //echo '<pre>';print_r($all_product_received);
          if (!$all_product_received) {
          if ($product_detail = $this->getOrderDetails($user_id, $item->id)) {
          foreach ($product_detail as $product) {

          $result[$i]->id = $product->id;
          $result[$i]->order_id = $item->order_id;
          $result[$i]->order_date = $item->order_date;
          $result[$i]->order_status = $item->order_status;
          $result[$i]->currency = $item->currency;
          $result[$i]->total_amount = $item->total_amount;
          $result[$i]->display_status = 'Review Order';

          $result[$i]->product_name = $product->name;
          $result[$i]->product_qty = $product->qty;
          $result[$i]->measurement = $product->measurement;
          $i++;
          }
          }
          } else {

          $check_receive_product = 1;
          if ($product_detail = $this->getOrderDetails($user_id, $item->id)) {
          foreach ($product_detail as $product) {

          if ($product->receive_status == 0) {

          $check_receive_product = 0;
          $result[$i]->id = $product->id;
          $result[$i]->order_id = $item->order_id;
          $result[$i]->order_date = $item->order_date;
          $result[$i]->order_status = $item->order_status;
          $result[$i]->currency = $item->currency;
          $result[$i]->total_amount = $item->total_amount;
          $result[$i]->display_status = 'Review Order';

          $result[$i]->product_name = $product->name;
          $result[$i]->product_qty = $product->qty;
          $result[$i]->measurement = $product->measurement;
          $i++;
          }
          }
          }

          if ($check_receive_product) {

          $payment = $this->getPaidTransactionAmount($item->id);
          $total_amount = round($item->total_amount - 1);
          if ($payment && $payment->total_amount < $total_amount) {

          $result[$i]->id = $item->id;
          $result[$i]->order_id = $item->order_id;
          $result[$i]->order_date = $item->order_date;
          $result[$i]->order_status = $item->order_status;
          $result[$i]->currency = $item->currency;
          $result[$i]->total_amount = $item->total_amount;
          $result[$i]->display_status = 'Make Payment';
          $i++;
          }
          }
          }
          } else {
          if ($product_detail = $this->getOrderDetails($user_id, $item->id)) {
          foreach ($product_detail as $product) {

          $result[$i]->id = $product->id;
          $result[$i]->order_id = $item->order_id;
          $result[$i]->order_date = $item->order_date;
          $result[$i]->order_status = $item->order_status;
          $result[$i]->currency = $item->currency;
          $result[$i]->total_amount = $item->total_amount;
          $result[$i]->display_status = 'Pending';

          $result[$i]->product_name = $product->name;
          $result[$i]->product_qty = $product->qty;
          $result[$i]->measurement = $product->measurement;
          $i++;
          }
          }
          }
          }
          }
          return $result; */

        $this->db->where('status', 0);
        $this->db->where('is_order', 1);
        $this->db->where("user_id IN(" . implode(',', $user_id) . ")");
        $this->db->where("order_status != 'Rejected'");
        $this->db->where("order_status != 'Cancelled'");
        //$this->db->where("order_status != 'Completed'");
        $this->db->order_by('updated_date', 'desc');
        $data = $this->db->get('cart_orders')->result();

        if ($data) {
            foreach ($data as $item) {

                $payment = $this->checkPaidTransactionAmount($item->id);
                $item->remaining_amount = $payment;

                $display_status = 'Pending';
                if ($item->order_status == 'Processing') {
                    if ($payment) {
                        $display_status = $is_manager ? 'Processing' : 'Make Payment';
                    } else {
                        $display_status = 'Processing';
                    }
                }
                if ($item->order_status == 'Completed') {

                    $display_status = 'Review Order';
                }

                //Get Payment done or not
                $payment_data = $this->db->where('order_id', $item->id)->where("payment_status != 'Cancelled'")->get('transaction')->row();
                if (!$payment_data) {
                    $display_status = 'Make Payment';
                }

                if ($item->is_approve == 0) {

                    $display_status = 'Verify Order';
                }
                $item->display_status = $display_status;

                //display total qty
                $this->db->select('SUM(qty) as quantity, measurement');
                $this->db->where('status', 0);
                $this->db->where('cart_order_id', $item->id);
                $detail = $this->db->get('cart_order_details')->row();

                $item->total_qty = $detail ? $detail->quantity : '';
                $item->measurement = $detail ? $detail->measurement : '';
            }
        }
        return $data;
    }

    function getOrders($user_id, $order_status, $from_date = '', $to_date = '', $limit = 0, $page = 1, $all = 0) {
        if ($order_status == 'Processing') {
            $this->db->group_start();
            $this->db->where('o.order_status', 'Accepted');
            $this->db->or_where('o.order_status', 'Processing');
            $this->db->group_end();
        } else {
            if ($order_status == 'Pending') {
                $this->db->where("(o.order_status = 'Pending' || o.order_status = 'New' || o.order_status = 'Rejected')");
            } else {
                $this->db->where('o.order_status', $order_status);
            }
        }
        
        if($from_date != ''){
            $this->db->where("o.order_date >= '$from_date'");
        }
        if($to_date != ''){
            $this->db->where("o.order_date <= '$to_date'");
        }
        
        //$this->db->where('o.is_owner', 1);
        $this->db->where('o.is_order', 1);
        $this->db->where('o.is_approve', 1);
        $this->db->where('o.user_id', $user_id);
        $this->db->order_by('o.updated_date', 'desc');

        if ($all) {
            return $this->db->get('cart_orders o')->num_rows();
        }

        if ($limit) {
            if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
                $offset = ((int) $page * $limit) - $limit;
                $this->db->limit($limit, $offset);
            else:
                $this->db->limit($limit);
            endif;
        }

        $this->db->join('station s', 's.station_id = o.station_id', 'left');
        $data = $this->db->get('cart_orders o')->result();

        if ($data) {
            foreach ($data as $item) {
                $product_name = '';
                if ($detail = $this->getFirstOrderDetails($item->id)) {
                    $product_name = $detail->name;
                }
                $item->product_name = $product_name;
            }
        }
        return $data;
    }

    function getOrderById($order_id) {
        //$this->db->select('o.*, s.*, TIME_TO_SEC(TIMEDIFF(o.time_left_to_accept, NOW())) AS total_seconds');
        $this->db->select('o.*, s.*');
        $this->db->where('o.is_order', 1);
        //$this->db->where('o.is_approve', $is_approve);
        $this->db->where('o.id', $order_id);
        $this->db->order_by('o.updated_date', 'desc');
        $this->db->join('station s', 's.station_id = o.station_id', 'left');
        $data = $this->db->get('cart_orders o')->row();

        if ($data) {

            $owner_id = $data->user_id;
            if ($data->is_owner == 0) {
                $owner = $this->getUserById($data->user_id);
                $owner_id = $owner ? $owner->owner_id : 0;
            }
            $data->owner_id = $owner_id;

            //display total qty and product name
            $this->db->select('SUM(qty) as quantity, measurement, GROUP_CONCAT(name) as product_name');
            $this->db->where('status', 0);
            $this->db->where('cart_order_id', $order_id);
            $detail = $this->db->get('cart_order_details')->row();

            $data->product_name = $detail ? $detail->product_name : '';
            $data->total_qty = $detail ? $detail->quantity : '';
            $data->measurement = $detail ? $detail->measurement : '';
        }
        return $data;
    }

    function getManagerOrders($user_id, $user_type = 'Manager', $limit = 0, $page = 1, $all = 0) {

        $this->db->select("o.*, s.station_name, s.contact_person, s.contact_number, s.alternate_number,
                s.address, s.latitude, s.longitude, IF((o.order_status = 'New' || o.order_status = 'Assigned'), 'Pending', (IF(o.order_status = 'Accepted', 'Processing', o.order_status))) as order_status");

        //$this->db->where('o.order_status', $order_status);
        $this->db->where('o.is_owner', 0);
        $this->db->where('o.is_order', 1);
        $this->db->where('u.owner_id', $user_id);

        /*
          $this->db->group_start();
          $this->db->where('u.user_type', 'Manager');
          $this->db->or_where('u.user_type', 'Attendant');
          $this->db->group_end();
         */

        $this->db->where('u.user_type', $user_type);
        $this->db->order_by('o.updated_date', 'desc');
        $this->db->join('user u', 'u.user_id = o.user_id', 'left');
        $this->db->join('station s', 's.station_id = o.station_id', 'left');

        if ($all) {
            return $this->db->get('cart_orders o')->num_rows();
        }

        if ($limit) {
            if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
                $offset = ((int) $page * $limit) - $limit;
                $this->db->limit($limit, $offset);
            else:
                $this->db->limit($limit);
            endif;
        }

        $data = $this->db->get('cart_orders o')->result();

        if ($data) {
            foreach ($data as $item) {
                $product_name = '';
                if ($detail = $this->getFirstOrderDetails($item->id)) {
                    $product_name = $detail->name;
                }
                $item->product_name = $product_name;
            }
        }
        return $data;
    }

    function getOrderDetails($order_id) {
        $this->db->where('status', 0);
        //$this->db->where('cart_user_id', $user_id);
        $this->db->where('cart_order_id', $order_id);
        $this->db->order_by('cart_created', 'asc');
        $data = $this->db->get('cart_order_details')->result();
        if ($data) {
            foreach ($data as $item) {
                $item->image_path = getImage('product_image', $item->image);
            }
        }
        return $data;
    }

    function checkOrderDetails($user_id, $order_id) {
        $this->db->where('status', 0);
        $this->db->where('cart_user_id', $user_id);
        $this->db->where('cart_order_id', $order_id);
        $this->db->where("assign_order_id != ''");
        $this->db->where('receive_status', 0);
        $receive_pending = $this->db->get('cart_order_details')->num_rows();

        $this->db->where('status', 0);
        $this->db->where('cart_user_id', $user_id);
        $this->db->where('cart_order_id', $order_id);
        $this->db->where('receive_status', 0);
        $receive_completed = $this->db->get('cart_order_details')->num_rows();

        $status = 0;
        if ($receive_pending == $receive_completed) {
            $status = 1;
        }
        return $status;
    }

    function getFirstOrderDetails($order_id) {
        $this->db->where('status', 0);
        //$this->db->where('cart_user_id', $user_id);
        $this->db->where('cart_order_id', $order_id);
        $this->db->order_by('cart_created', 'asc');
        $this->db->limit(1);
        $data = $this->db->get('cart_order_details')->row();
        if ($data) {
            $data->image_path = getImage('product_image', $data->image);
        }
        return $data;
    }

    function getSingleOrderDetails($user_id, $id) {
        $this->db->where('status', 0);
        $this->db->where('cart_user_id', $user_id);
        $this->db->where('id', $id);
        $data = $this->db->get('cart_order_details')->row();
        if ($data) {

            $order_id = $order_date = $payment_type = '';
            if ($order_data = $this->getOrderById($data->cart_order_id)) {
                $payment_type = $order_data->payment_type;
                $order_id = $order_data->order_id;
                $order_date = date('Y-m-d', strtotime($order_data->created_date));
            }
            $data->order_id = $order_id;
            $data->order_date = $order_date;
            $data->payment_type = $payment_type;
            $data->image_path = getImage('product_image', $data->image);
        }
        return $data;
    }

    function transporterOrders($user_id, $assign_status, $limit = 0, $page = 0, $all = 0) {

        if ($assign_status == 'Pending') {
            //$this->db->group_start();
            //$this->db->where("(a.assign_status = 'Pending' AND a.transporter_id = $user_id)");
            //$this->db->or_where("(a.assign_status = 'New' AND a.transporter_id = 0)");
            //$this->db->group_end();

            $site_lat = $this->common_model->getSiteSettingByTitle('latitude');
            $site_lng = $this->common_model->getSiteSettingByTitle('longitude');
            $distance_in_km = $this->common_model->getSiteSettingByTitle('nearby_pickup_radius');

            $this->db->select("a.*, 111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(s.latitude)) 
            * COS(RADIANS('$site_lat')) 
            * COS(RADIANS(s.longitude - '$site_lng')) 
            + SIN(RADIANS(s.latitude)) 
            * SIN(RADIANS('$site_lat'))))) AS distance_in_km");

            $this->db->join('station s', 's.station_id = a.station_id', 'left');
            $this->db->join("(SELECT order_id, GROUP_CONCAT(reject_user_id) AS reject_user_id FROM assign_order_details WHERE order_status = 'Reject' GROUP BY order_id) AS ad", 'ad.order_id = a.order_id', 'LEFT');
            $this->db->order_by('distance_in_km', 'asc');
            $this->db->having("distance_in_km < $distance_in_km");

            //$this->db->where('a.assign_status', 'New');
            $this->db->where("IF(reject_user_id, NOT FIND_IN_SET('$user_id', reject_user_id), 1=1)");
            $this->db->where("(a.assign_status = 'New' || a.assign_status = 'Reject')");
            $this->db->where('a.transporter_id', 0);
            $this->db->where("o.order_status != 'Cancelled'");
            $this->db->where('o.time_left_to_accept > NOW()');
            $this->db->join('cart_orders o', 'o.id = a.order_id', 'INNER');
            
        } else {

            if ($assign_status == 'Delivered') {

                $this->db->where("a.assign_status = 'Delivered'");
            } else {

                $this->db->group_start();
                $this->db->where("a.assign_status = 'Pending'");
                $this->db->or_where("a.assign_status = 'Accept'");
                $this->db->group_end();
            }
            $this->db->where('a.transporter_id', $user_id);
        }

        $this->db->where('a.status', 0);
        $this->db->order_by('a.assign_datetime', 'desc');

        if ($all) {
            return $this->db->get('assign_orders a')->num_rows();
        }

        if ($limit) {
            if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
                $offset = ((int) $page * $limit) - $limit;
                $this->db->limit($limit, $offset);
            else:
                if ($page) {
                    $this->db->limit($limit);
                }
            endif;
        }
        $data = $this->db->get('assign_orders a')->result();
        //echo $this->db->last_query();die;
        if ($data) {
            foreach ($data as $item) {

                $item->order_no = '';
                if ($order_data = $this->getOrderById($item->order_id)) {
                    $item->order_no = $order_data->order_id;
                    $item->payment_type = $order_data->payment_type;
                    $item->is_schedule_delivery = $order_data->is_schedule_delivery;
                    $item->delivery_date = $order_data->delivery_date;
                    $item->delivery_time = $order_data->delivery_time;

                    /* $seconds = $order_data->total_seconds;
                      $secs = (int) ($seconds % 60);
                      $hrs = $seconds / 60;
                      $mins = (int) ($hrs % 60);

                      $hrs = (int) ($hrs / 60);
                      $time_left_to_accept = ($hrs ? $hrs : '00') . ':' . ($mins ? $mins : '00') . ':' . ($secs ? $secs : '00');

                      $item->time_left_to_accept = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? date('H:i:s', strtotime($time_left_to_accept)) : ''; */
                    $item->time_left_to_accept = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? $order_data->time_left_to_accept : '';
                    $item->display_time = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? strtotime($order_data->time_left_to_accept) : 0;
                }
                $item->pickup_data = json_decode($item->pickup_data);
                $item->station_data = json_decode($item->station_data);
            }
        }
        return $data;
    }

    function getAssignOrder($order_id) {

        $this->db->where('order_id', $order_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('assign_orders')->row();
    }

    function transporterOrdersDetails($order_id) {

        $this->db->where('order_id', $order_id);
        $data = $this->db->get('assign_orders')->row();
        if ($data) {
            $data->pickup_data = json_decode($data->pickup_data);
            $data->station_data = json_decode($data->station_data);
            $order_data = $this->getOrderById($order_id);
            if ($order_data) {

                $display_status = 'Reach';
                if ($assign_detail = $this->getLastAssignOrderDetails($order_id)) {

                    if ($assign_detail->order_status == 'Reach') {
                        $display_status = 'Loaded';
                    }
                    if ($assign_detail->order_status == 'Loaded') {
                        $display_status = 'Delivered';
                    }
                }
                $order_data->display_status = $display_status;
                
                $order_data->today_delivery = 0;
                if($order_data->delivery_date == date('Y-m-d')){
                    $order_data->today_delivery = 1;
                }
                
                $order_data->is_add_fuel = $this->checkAddFuel($order_id);
                
                $order_data->order_details = $this->getOrderDetailById($order_id);                 
            }
            $data->order_data = $order_data;
        }
        return $data;
    }

    function getOrderDetailById($order_id, $check_add_fuel = 0) {
        $this->db->where('cart_order_id', $order_id);
        $this->db->order_by('cart_created', 'asc');
        $data = $this->db->get('cart_order_details')->result();
        if ($data) {
            foreach ($data as $item) {
                $item->image_path = getImage('product_image', $item->image);
                $item->add_fuel = $item->compartment_data ? 1 : 0;
            } 
        }
        return $data;
    }

    function updateAssignOrder($id, $order_id, $data) {
        $this->db->where('id', $id);
        $this->db->where('order_id', $order_id);
        return $this->db->update('assign_orders', $data);
    }

    function addAssignOrderDetails($data) {
        $this->db->insert('assign_order_details', $data);
        return $this->db->insert_id();
    }

    function checkPaidTransactionAmount($order_id) {

        $payment_done = 0;
        if ($order = $this->getOrderById($order_id)) {

            $this->db->select('*, SUM(amount) as total_amount');
            $this->db->where('order_id', $order_id);
            $this->db->where('payment_status', 'Paid');
            $payment = $this->db->get('transaction')->row();

            $total_amount = $order->total_amount;
            $payment_amount = $payment->total_amount;
            if ($payment && $payment_amount) {
                if ($payment_amount < $total_amount) {
                    $payment_done = round($total_amount - $payment_amount, 2);
                }
            } else {
                $payment_done = round($total_amount, 2);
            }
        }
        return $payment_done;
    }

    function get_nearby_stations($owner_id) {

        $this->db->select("station_id, station_name, contact_person, contact_number, address, latitude, longitude");
        $this->db->where('status', 1);
        $this->db->where('owner_id', $owner_id);
        $this->db->order_by('station_name', 'ASC');
        return $this->db->get('station')->result();
    }

    function getAssignOrdersDetails($order_id) {

        $this->db->where('order_id', $order_id);
        $data = $this->db->get('assign_orders')->row();
        if ($data) {
            $data->pickup_data = json_decode($data->pickup_data);
            $data->station_data = json_decode($data->station_data);
            $data->order_data = $this->getTrackOrders($order_id);
        }
        return $data;

        /* $order_data = $this->getOrderById($order_id);
          if ($order_data) {
          $display_status = 'Pending';
          if ($order_data->order_status == 'Delivered') {
          $display_status = 'Make Payment';
          }
          }
          return $order_data; */
    }

    function getAssignOrderDetailById($order_id) {
        $this->db->where('cart_order_id', $order_id);
        $this->db->order_by('cart_created', 'asc');
        $data = $this->db->get('cart_order_details')->result();
        if ($data) {
            foreach ($data as $item) {
                $item->image_path = getImage('product_image', $item->image);

                $product_status = 'Order Placed';
                if ($assign_detail = $this->getLastAssignOrderDetails($order_id, $item->id)) {

                    if ($assign_detail->order_status == 'Pending') {
                        $product_status = 'Transporter Assigned';
                    }
                    if ($assign_detail->order_status == 'Accept') {
                        $product_status = 'Order Loaded';
                    }
                    if ($assign_detail->order_status == 'Reach' || $assign_detail->order_status == 'Loaded') {
                        $product_status = 'In Transit';
                    }
                    if ($assign_detail->order_status == 'Delivered') {
                        $product_status = 'Delivered';
                    }
                }
                $item->product_status = $product_status;
            }
        }
        return $data;
    }

    function getLastAssignOrderDetails($order_id) {
        $this->db->where("order_status != 'Reject'");
        $this->db->where('order_id', $order_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('assign_order_details')->row();
    }

    function getAllAssignOrderDetails($order_id) {
        $this->db->where("order_status != 'Reject'");
        $this->db->where('order_id', $order_id);
        $this->db->order_by('id', 'asc');
        $this->db->group_by('order_status');
        return $this->db->get('assign_order_details')->result();
    }

    function getTrackOrders($order_id) {
        $order = $this->getOrderById($order_id);
        if ($order) {
            /*
              //display total qty and product name
              $this->db->select('SUM(qty) as quantity, measurement, GROUP_CONCAT(name) as product_name');
              $this->db->where('status', 0);
              $this->db->where('cart_order_id', $order_id);
              $detail = $this->db->get('cart_order_details')->row();

              $order->product_name = $detail ? $detail->product_name : '';
              $order->total_qty = $detail ? $detail->quantity : '';
              $order->measurement = $detail ? $detail->measurement : ''; */

            //assign order details
            $status_data = $status_list = array();
            if ($assign_detail = $this->getAllAssignOrderDetails($order_id)) {

                $i = 0;
                foreach ($assign_detail as $assign) {

                    $display_status = $date_time = "";
                    if ($assign->order_status == 'New') {
                        $display_status = 'Order Placed';
                        $date_time = date('d-m-Y h:i A', strtotime($assign->date_time));
                    }
                    if ($assign->order_status == 'Pending' || $assign->order_status == 'Accept') {
                        $display_status = 'Transporter Assigned';
                        $date_time = date('d-m-Y h:i A', strtotime($assign->date_time));
                    }
                    if ($assign->order_status == 'Reach') {
                        $display_status = 'Transporter reached depot';
                        $date_time = date('d-m-Y h:i A', strtotime($assign->date_time));
                    }
                    if ($assign->order_status == 'Loaded') {
                        $display_status = 'Transporter collected fuel';
                        $date_time = date('d-m-Y h:i A', strtotime($assign->date_time));
                    }
                    if ($assign->order_status == 'Delivered') {
                        $display_status = 'Delivered';
                        $date_time = date('d-m-Y h:i A', strtotime($assign->date_time));
                    }

                    if ($display_status != "") {
                        $status_list[$i]['display_status'] = $display_status;
                        $status_list[$i]['date_time'] = $date_time;
                        $status_list[$i]['status_active'] = $assign->order_status == 'Accept' ? 'Pending' : $assign->order_status;
                        $i++;
                    }
                }
            }

            $k = 0;
            $order_status = array('New', 'Pending', 'Reach', 'Loaded', 'Delivered');
            foreach ($order_status as $status) {

                $display_status = '';
                if ($status == 'New') {
                    $display_status = 'Order Placed';
                }
                if ($status == 'Pending') {
                    $display_status = 'Transporter Assigned';
                }
                if ($status == 'Reach') {
                    $display_status = 'Transporter reached depot';
                }
                if ($status == 'Loaded') {
                    $display_status = 'Transporter collected fuel';
                }
                if ($status == 'Delivered') {
                    $display_status = 'Delivered';
                }

                $new_status = array('display_status' => $display_status, 'date_time' => '', 'status_active' => false);
                $is_true = false;
                if ($status_list) {
                    foreach ($status_list as $value) {

                        if ($status == $value['status_active']) {
                            $is_true = true;
                            $new_status['display_status'] = $value['display_status'];
                            $new_status['date_time'] = $value['date_time'];
                            $new_status['status_active'] = true;
                        }
                    }
                }

                $status_data[$k]['display_status'] = $new_status['display_status'];
                $status_data[$k]['date_time'] = $is_true ? $new_status['date_time'] : '';
                $status_data[$k]['status_active'] = $is_true;
                $k++;
            }
            $order->status_list = $status_data;
        }
        return $order;
    }

    public function addAssignOrder($data) {
        $this->db->insert('assign_orders', $data);
        return $this->db->insert_id();
    }

    public function getStationById($station_id) {
        $this->db->where('station_id', $station_id);
        return $this->db->get('station')->row();
    }

    function getAssignOrderDetailByAssignId($assign_id, $status = '') {
        $this->db->where('assign_order_id', $assign_id);
        if ($status != '') {
            $this->db->where('order_status', $status);
        }
        $this->db->limit(1);
        return $this->db->get('assign_order_details')->row();
    }

    public function getAllTransactions($user_id, $search = "", $limit, $page, $all = 0) {
        $this->db->where('payment_status', 'Paid');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);

        $this->db->group_start();
        $this->db->where("(payment_type = 'Purchase' AND transaction_type = 'Wallet')");
        $this->db->or_where("(payment_type = 'Wallet' AND transaction_type != 'Wallet')");
        $this->db->group_end();

        if ($search != "") {
            $this->db->group_start();
            $this->db->like("payment_ref_id", $search);
            $this->db->or_like("order_no", $search);
            $this->db->group_end();

            $this->getOrderByTitle('payment_ref_id', $search);
        }
        if ($all) {
            return $this->db->get('transaction')->num_rows();
        }

        $this->db->order_by('created_date', 'DESC');

        if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
            $offset = ((int) $page * $limit) - $limit;
            $this->db->limit($limit, $offset);
        else:
            $this->db->limit($limit);
        endif;

        return $this->db->get('transaction')->result();
    }

    public function getAllAdvertisements($advertisement_type = '') {
 
        $data = array();
        if ($advertisement_type != '') { 
            $this->db->select('id, title, description, image, display_order');
            $this->db->where("(advertisement_type = 'Both' OR advertisement_type = '$advertisement_type')");
            $this->db->where('status', '1'); 
            $this->db->order_by('display_order', 'ASC');
            $data = $this->db->get('advertisement')->result();
            if ($data) {
                foreach ($data as $item) {
                    $item->image_path = getImage('advertisement', $item->image);
                }
            }
        }
        return $data;
    }

    public function getManagerIds($owner_id) {
        $this->db->select('GROUP_CONCAT(user_id) as user_ids');
        $this->db->where('status', 1);
        $this->db->where('owner_id', $owner_id);
        return $this->db->get('user')->row();
    }

    public function getCoupon($coupon_code) {
        $this->db->where('status', 1);
        $this->db->where('coupon_code', $coupon_code);
        return $this->db->get('coupons')->row();
    }

    function getSearchOrders($user_id, $order_id = '') {

        $this->db->select('id, order_id, order_status');
        if ($order_id != "") {
            $this->db->group_start();
            $this->db->like("order_id", $order_id);
            $this->db->group_end();

            $this->getOrderByTitle('order_id', $order_id);
        }

        $this->db->where('is_order', 1);
        $this->db->where("user_id IN(" . implode(',', $user_id) . ")");
        $this->db->order_by('updated_date', 'desc');
        return $this->db->get('cart_orders')->result();
    }

    function generateBill($customer = array(), $products = array(), $invoice_no = '', $partial = 'false') {

        $currency_code = $this->common_model->getSiteSettingByTitle('currency_symbol');

        $test_url = $live_url = '';
        if ($payment_gateway = $this->common_model->getSettings('payment_gateway_setting')) {
            foreach ($payment_gateway as $setting) {
                if ($setting->title == 'test_pg_url') {
                    $test_url = $setting->value;
                }
                if ($setting->title == 'live_pg_url') {
                    $live_url = $setting->value;
                }
            }
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $test_url . '/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=password&Username=eqwipetrol@jambopay.com&Password=Password1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $access_token = '';
        if ($response && $data = json_decode($response)) {
            $access_token = $data->access_token;
        }

        //data
        $customer_data = json_encode($customer);
        $product_data = json_encode($products);

        $curl1 = curl_init();
        curl_setopt_array($curl1, array(
            CURLOPT_URL => $test_url . '/api/UniversalBill/GenerateBill',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                    "MerchantCode":"121121",
                                    "CustomerInfo":' . $customer_data . ',
                                    "Items":' . $product_data . ',
                                    "BillTitle":"Invoice",
                                    "InvoiceNumber":"' . $invoice_no . '",
                                    "Currency":"KES",
                                    "PartialPayable":"' . $partial . '",
                                    "CallbackUrl":"' . base_url('payment/success') . '",
                                  }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'app_key: ccceee1ddbd1422f84bf9f5bda4bebf93a4a26b6e40e489aa7c44e324967e24ba989f4e961884ead8a5e7c0203350c6a',
                'Authorization: Bearer ' . $access_token
            ),
        ));

        $response1 = curl_exec($curl1);
        curl_close($curl1);

        return $response1;
    }

    function transporterScheduledOrders($user_id, $is_scheduled = 0, $limit = 0, $page = 0, $all = 0) {

        $today = date('Y-m-d');
        if ($is_scheduled) {
            //$this->db->where('DATE_FORMAT(a.assign_datetime, "%Y-%m-%d") >= ', $today);
            $this->db->where('o.delivery_date > ', $today);
        } else {
            //$this->db->where('DATE_FORMAT(a.assign_datetime, "%Y-%m-%d") = ', $today);
            $this->db->where('o.delivery_date = ', $today);
        }

        $this->db->select('a.*, o.order_id as order_no, o.payment_type, o.is_schedule_delivery, o.delivery_date,
                o.delivery_time, o.time_left_to_accept as left_to_accept');
        $this->db->group_start();
        $this->db->where("a.assign_status = 'Pending'");
        $this->db->or_where("a.assign_status = 'Accept'");
        $this->db->group_end();
        $this->db->where('a.transporter_id', $user_id);

        $this->db->where('a.status', 0);
        $this->db->where('o.is_order', 1);
        $this->db->join('cart_orders o', 'o.id = a.order_id', 'INNER');
        $this->db->order_by('a.assign_datetime', 'desc');

        if ($all) {
            return $this->db->get('assign_orders a')->num_rows();
        }

        if ($limit) {
            if (!empty($page) && $page != '' && $page != NULL && is_numeric($page)):
                $offset = ((int) $page * $limit) - $limit;
                $this->db->limit($limit, $offset);
            else:
                if ($page) {
                    $this->db->limit($limit);
                }
            endif;
        }
        $data = $this->db->get('assign_orders a')->result();
        //echo $this->db->last_query();die;
        if ($data) {
            foreach ($data as $item) {

                /* $item->order_no = '';
                  if ($order_data = $this->getOrderById($item->order_id)) {
                  $item->order_no = $order_data->order_id;
                  $item->payment_type = $order_data->payment_type;
                  $item->is_schedule_delivery = $order_data->is_schedule_delivery;
                  $item->delivery_date = $order_data->delivery_date;
                  $item->delivery_time = $order_data->delivery_time;

                  $item->time_left_to_accept = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? $order_data->time_left_to_accept : '';
                  $item->display_time = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? strtotime($order_data->time_left_to_accept) : 0;
                  }
                 */

                $item->time_left_to_accept = strtotime($item->left_to_accept) > strtotime(DATETIME) ? $item->left_to_accept : '';
                $item->display_time = strtotime($item->left_to_accept) > strtotime(DATETIME) ? strtotime($item->left_to_accept) : 0;

                $item->pickup_data = json_decode($item->pickup_data);
                $item->station_data = json_decode($item->station_data);
            }
        }
        return $data;
    }
    
    function todayTransporterOrders($user_id) {
        
        $today = date('Y-m-d');
        $this->db->select('a.*');
        $this->db->where("a.assign_status = 'Accept'");
        $this->db->where('a.transporter_id', $user_id);

        $this->db->where('a.status', 0);

        $this->db->where('o.status', 0);
        $this->db->where('o.is_order', 1);
        $this->db->where("o.order_status != 'Rejected'");
        $this->db->where("o.order_status != 'Cancelled'");
        $this->db->where("o.delivery_date = '$today'");
        $this->db->join('cart_orders o', 'o.id = a.order_id', 'INNER');
        $this->db->order_by('o.delivery_date', 'asc');
        $this->db->order_by('o.delivery_time', 'asc');
        $data = $this->db->get('assign_orders a')->result();
        //echo $this->db->last_query();die;
        if ($data) {
            foreach ($data as $item) {

                $item->order_no = '';
                if ($order_data = $this->getOrderById($item->order_id)) {
                    $item->order_no = $order_data->order_id;
                    $item->payment_type = $order_data->payment_type;
                    $item->is_schedule_delivery = $order_data->is_schedule_delivery;
                    $item->delivery_date = $order_data->delivery_date;
                    $item->delivery_time = $order_data->delivery_time;

                    $item->time_left_to_accept = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? $order_data->time_left_to_accept : '';
                    $item->display_time = strtotime($order_data->time_left_to_accept) > strtotime(DATETIME) ? strtotime($order_data->time_left_to_accept) : 0;
                }
                $item->pickup_data = json_decode($item->pickup_data);
                $item->station_data = json_decode($item->station_data);
            }
        }
        return $data;
    }
    
    function checkAddFuel($order_id) {
        $is_add_fuel = 1;
        $this->db->where('cart_order_id', $order_id);
        $data = $this->db->get('cart_order_details')->result();
        if ($data) {
            foreach ($data as $item) {
                if(!$item->compartment_data){
                    $is_add_fuel = 0;
                }
            }
        }
        return $is_add_fuel;
    }
    
    function generateBillKCB($customer = array(), $orders = array()) {

        /*
        $currency_code = $this->common_model->getSiteSettingByTitle('currency_symbol');
        $test_url = $live_url = '';
        if ($payment_gateway = $this->common_model->getSettings('payment_gateway_setting')) {
            foreach ($payment_gateway as $setting) {
                if ($setting->title == 'test_pg_url') {
                    $test_url = $setting->value;
                }
                if ($setting->title == 'live_pg_url') {
                    $live_url = $setting->value;
                }
            }
        }*/
        
        $post_data = array();
        $post_data['customerName'] = $customer['Names'];
        $post_data['customerPhone'] = $customer['PhoneNumber'];
        $post_data['billAmount'] = $orders->total_amount;
        $post_data['billCurrency'] = $orders->currency;
        $post_data['orderID'] = $orders->id;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://exp.fanakamobile.com/api/eqwipetrol/generate/bill/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post_data            
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }
}
