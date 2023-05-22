<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'third_party/phpmailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class Common_model extends CI_Model {

    public function getSiteSettingByTitle($title) {
        $this->db->where('title', $title);
        $data = $this->db->get('option_setting')->row();
        return $data ? $data->value : '';
    }

    public function getSettings($option_type) {
        $this->db->where('option_type', $option_type);
        return $this->db->get('option_setting')->result();
    }

    public function addMenu($data) {
        $this->db->insert('admin_dashboard_menu', $data);
        return $this->db->insert_id();
    }

    public function updateMenu($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('admin_dashboard_menu', $data);
    }

    public function getAllMenu($type = '') {
        if ($type == 'main') {
            $this->db->where('menu_id', 0);
        } else {
            $this->db->where('menu_id != ', 0);
        }
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('admin_dashboard_menu')->result();
    }

    public function getMainMenu($id = 0) {
        if ($id) {
            $this->db->where('id != ', $id);
        }
        $this->db->where('menu_id', 0);
        return $this->db->get('admin_dashboard_menu')->result();
    }

    public function getMenuById($id) {
        $this->db->where('id', $id);
        return $this->db->get('admin_dashboard_menu')->row();
    }

    public function getAllSubMenuByMenuId($id) {
        $this->db->select('GROUP_CONCAT(id) as ids');
        $this->db->where('menu_id', $id);
        $this->db->limit(1);
        return $this->db->get('admin_dashboard_menu')->row();
    }

    function send_push_notification($data) {

        $push_notification_key = $this->getSiteSettingByTitle('push_notification_key');
        if ($push_notification_key != '') {

            //send notifcation to ios
            unset($data["notification"]["channel_id"]);
            $data["channel_id"] = "fcm_smart_life";
            $data["priority"] = "high";
            if (isset($data["notification"])) {
                $data["notification"]["android_channel_id"] = "fcm_smart_life";
            }
            $data["category"] = "content_added_notification";
            $data["content_available"] = true;
            $data["mutable_content"] = true;

            $data_string = json_encode($data);
            $headers = array(
                'Authorization: key=' . $push_notification_key,
                'Content-Type: application/json'
            );

            //echo '<pre>';print_r($data_string);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            $result = curl_exec($ch);
            curl_close($ch);

            //send notifcation to android
            unset($data["notification"]);
            unset($data["notification"]["channel_id"]);
            $data["channel_id"] = "fcm_smart_life";
            $data["priority"] = "high";
            if (isset($data["notification"])) {
                $data["notification"]["android_channel_id"] = "fcm_smart_life";
            }
            $data["category"] = "content_added_notification";
            $data["content_available"] = true;
            $data["mutable_content"] = true;

            $data_string = json_encode($data);
            $headers = array(
                'Authorization: key=' . $push_notification_key,
                'Content-Type: application/json'
            );

            #print_r($data_string);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            $result = curl_exec($ch);
            curl_close($ch);
            //echo '<pre>';print_r($result);die;

            return true;
        }
    }

    function send_mail($message, $email_id, $subject = '', $attachment = '') {

        $smtp_host = $smtp_username = $smtp_password = $smtp_port = '';
        $site_data = $this->getSettings("email_setting");
        if (isset($site_data) && $site_data) {
            foreach ($site_data as $setting) {
                if ($setting->title == 'smtp_host') {
                    $smtp_host = $setting->value;
                }
                if ($setting->title == 'smtp_user') {
                    $smtp_username = $setting->value;
                }
                if ($setting->title == 'smtp_password') {
                    $smtp_password = $setting->value;
                }
                if ($setting->title == 'smtp_port') {
                    $smtp_port = $setting->value;
                }
            }
        }

        $contact_email = FROM_MAIL;

        /*
          $config['protocol'] = 'smtp';
          $config['charset'] = 'utf-8';
          $config['smtp_host'] = $smtp_host;
          $config['smtp_user'] = $smtp_username;
          $config['smtp_pass'] = $smtp_password;
          $config['smtp_port'] = $smtp_port;
          $config['crlf'] = "\r\n";
          $config['newline'] = "\r\n";
          $config['wordwrap'] = TRUE;
          $config['mailtype'] = 'html';
          $this->load->library('email');
          $this->email->initialize($config);

          $this->email->from($contact_email);
          $this->email->to($email_id);
          $this->email->subject($subject);
          $this->email->message($message);
          $send = $this->email->send();

          if (!$send) {
          echo $this->email->print_debugger();
          die();
          }
          return true;
         * 
         */

        $mail = new PHPMailer();
        $mail->Encoding = "base64";
        $mail->SMTPAuth = true;
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'TLS';
        $mail->isSMTP();
        $mail->IsHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->From = $contact_email;
        $mail->addAddress($email_id);
        $mail->Body = $message;
        $mail->Subject = $subject;

        if ($attachment != '') {
            $mail->addAttachment($attachment);
        }

        if (!$mail->Send()) {
            return false;
        }
        return true;

        /* $mail->SMTPDebug = 1;
          $mail->Debugoutput = function ($str, $level) {
          echo "debug level $level; message: $str";
          echo "<br>";
          };
          if (!$mail->Send()) {
          echo "Mail sending failed";
          } else {
          echo "Successfully sent";
          } */
    }

    public function getSubAdminById($id) {
        $this->db->select('a.*, r.role_name');
        $this->db->where('a.admin_id', $id);
        $this->db->join('role r', 'r.id = a.role_id', 'left');
        return $this->db->get('admin a')->row();
    }

    function getSuperAdminAccess($menu_id = 0) {
        $type = $menu_id ? 'M' : 'S';
        $sql = "select m.id, '$type' as menu_type, m.menu_name, m.menu_url, m.menu_icon, m.sub_ids, 1 as list_p, 
                1 as add_p, 1 as edit_p, 1 as delete_p, 0 as pid from admin_dashboard_menu m
                where m.status = 1 and m.menu_id = $menu_id order by m.display_order asc";
        return $this->db->query($sql)->result();
    }

    // get menu details
    function get_menu_details($id = 0) {

        $admin_details = $this->getSubAdminById($id);
        $is_super_admin = $admin_details && $admin_details->is_super_admin ? $admin_details->is_super_admin : 0;

        if ($is_super_admin) {
            $data = $this->getSuperAdminAccess();
        } else {

            if ($id) {
                $sql = "select m.id, 'M' as menu_type, m.menu_name, m.menu_url, m.menu_icon, m.sub_ids, p.list_p, 
                        p.add_p, p.edit_p, p.delete_p, p.id as pid from admin_dashboard_menu m
                    left join admin_user_privileges p on p.menu_id = m.id 
                    where m.status = 1 and m.menu_id = 0 GROUP BY m.id order by m.display_order asc";
                $data = $this->db->query($sql)->result();
            } else {
                $sql = "select m.id, 'M' as menu_type, m.menu_name, m.menu_url, m.menu_icon, m.sub_ids, 0 as list_p, 
                        0 as add_p, 0 as edit_p, 0 as delete_p, 0 as pid from admin_dashboard_menu m 
                        where m.status = 1 and m.menu_id = 0 GROUP BY m.id order by m.display_order asc";
                $data = $this->db->query($sql)->result();
            }
        }
        //echo '<pre>';print_r($data);die;
        if ($data) {
            foreach ($data as $item) {

                if ($is_super_admin) {
                    $item->sub_menu = $this->getSuperAdminAccess($item->id);
                } else {

                    if ($id) {

                        $sql1 = "select m.id, 'S' as menu_type, m.menu_name, m.menu_url, m.menu_icon, m.sub_ids, p.list_p, 
                        p.add_p, p.edit_p, p.delete_p, p.id as pid from admin_dashboard_menu m 
                        left join admin_user_privileges p on p.menu_id = m.id 
                        where m.status = 1 and m.menu_id = " . $item->id . " GROUP BY m.id order by m.display_order asc";
                        $item->sub_menu = $this->db->query($sql1)->result();
                    } else {

                        $sql1 = "select m.id, 'S' as menu_type, m.menu_name, m.menu_url, m.menu_icon, m.sub_ids, 0 as list_p, 
                        0 as add_p, 0 as edit_p, 0 as delete_p, 0 as pid from admin_dashboard_menu m 
                        where m.status = 1 and m.menu_id = " . $item->id . " GROUP BY m.id order by m.display_order asc";
                        $item->sub_menu = $this->db->query($sql1)->result();
                    }
                }
            }
        }

        return $data;
    }

    function check_menu_privilege($admin_id, $menu_url, $privilege) {
        $admin_details = $this->getSubAdminById($admin_id);
        $is_super_admin = $admin_details && $admin_details->is_super_admin ? $admin_details->is_super_admin : 0;

        if ($is_super_admin) {
            return true;
        } else {
            return $this->db->query("SELECT * FROM admin_user_privileges WHERE admin_id = $admin_id AND menu_url LIKE '$menu_url%' AND $privilege = 1")->row();
        }
    }

    function get_menu_privilege($admin_id, $menu_url) {
        $admin_details = $this->getSubAdminById($admin_id);
        $is_super_admin = $admin_details && $admin_details->is_super_admin ? $admin_details->is_super_admin : 0;

        if ($is_super_admin) {
            return $this->db->query("SELECT 1 as list_p, 1 as add_p, 1 as edit_p, 1 as delete_p FROM admin_dashboard_menu WHERE menu_url LIKE '$menu_url%'")->row();
        } else {
            return $this->db->query("SELECT list_p, add_p, edit_p, delete_p FROM admin_user_privileges WHERE admin_id = $admin_id AND menu_url LIKE '$menu_url%'")->row();
        }
    }

    function get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
        /*
          $meters = get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2);
          $kilometers = $meters / 1000;
          $miles = $meters / 1609.34;
          $yards = $miles * 1760;
          $feet = $miles * 5280;
          return compact('miles', 'feet', 'yards', 'kilometers', 'meters');
         */

        if (($latitude1 == $latitude2) && ($longitude1 == $longitude2)) {
            return 0;
        } // distance is zero because they're the same point
        $p1 = deg2rad($latitude1);
        $p2 = deg2rad($latitude2);
        $dp = deg2rad($latitude2 - $latitude1);
        $dl = deg2rad($longitude2 - $longitude1);
        $a = (sin($dp / 2) * sin($dp / 2)) + (cos($p1) * cos($p2) * sin($dl / 2) * sin($dl / 2));
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $r = 6371008; // Earth's average radius, in meters
        $d = $r * $c;
        return $d; // distance, in meters
    }

    function form_validation_message($data, $use_tags = 0) {
        $single_line_message = "";
        foreach ($data as $k => $name) {
            if ($k == 0) {
                if (form_error($name)) {
                    $single_line_message .= strip_tags(form_error($name));
                }
            } else {
                if (form_error($name)) {
                    $single_line_message .= $single_line_message ? ($use_tags ? form_error($name) : strip_tags(form_error($name))) : strip_tags(form_error($name));
                }
            }
        }
        return $single_line_message;
    }

    public function getUserById($id) {
        $this->db->where('status', 1);
        $this->db->where('user_id', $id);
        return $this->db->get('user')->row();
    }

    public function getAllUserCount($user_type) {
        $this->db->where('user_type', $user_type);
        return $this->db->get('user')->num_rows();
    }

    public function getDashboardCount($table = '') {
        if ($table != '') {
            return $this->db->get($table)->num_rows();
        }
        return 0;
    }

    function getOrderCounts($status) {
        $this->db->where('is_order', 1);
        $this->db->where('order_status', $status);
        return $this->db->get('cart_orders')->num_rows();
    }

    function getTransactionCounts($status) {
        $this->db->where('status', 1);
        $this->db->where('payment_status', $status);
        return $this->db->get('transaction')->num_rows();
    }

    public function getLastDisplayOrder($table) {
        $this->db->order_by('display_order', 'desc');
        $this->db->limit(1);
        $data = $this->db->get($table)->row();
        return $data ? ($data->display_order + 1) : 1;
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

    function getNewOrders() {

        $this->db->select("o.*");
        $this->db->where('o.is_order', 1);
        $this->db->where('o.order_status', 'New');
        $this->db->where('o.time_left_to_accept < NOW()');

        return $this->db->get('cart_orders o')->result();
    }

    function updateWallet($user_id) {

        $this->db->select('SUM(amount) as total_amount');
        $this->db->where('user_id', $user_id);
        $this->db->where('payment_status', 'Paid');
        $this->db->where('payment_type', 'Wallet');
        $this->db->where('transaction_type', 'Credit');
        $credit_trans = $this->db->get('transaction')->row();

        $sum_credit = $credit_trans ? $credit_trans->total_amount : 0;

        $this->db->select('SUM(amount) as total_amount');
        $this->db->where('user_id', $user_id);
        $this->db->where('payment_status', 'Paid');
        $this->db->where('payment_type', 'Purchase');
        $this->db->where('transaction_type', 'Wallet');
        $debit_trans = $this->db->get('transaction')->row();

        $sum_debit = $debit_trans ? $debit_trans->total_amount : 0;
        $wallet_amount = round($sum_credit - $sum_debit, 2);

        $this->db->where('user_id', $user_id);
        $this->db->update('user', ['wallet_balance' => $wallet_amount]);
        return $wallet_amount;
    }

    public function getAllTransaction($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_date', 'DESC');
        $data = $this->db->get('transaction')->result();
        if ($data) {
            foreach ($data as $item) {
                $name = '';
                if ($user = $this->common_model->getUserById($item->user_id)) {
                    $name = $user->name;
                }
                $item->name = $name;
            }
        }
        return $data;
    }

    function getNearbyOrders($order_id) {
        
        if ($order = $this->db->where('is_order', 1)->where('id', $order_id)->limit(1)->get('cart_orders')->row()) {
 
            $capacity = 0;
            if ($card_detail = $this->db->select('SUM(qty) as total_qty')->where('cart_order_id', $order_id)->get('cart_order_details')->row()) {
                $capacity = $card_detail->total_qty;
            }
            $delivery_date = $order->delivery_date;

            $this->db->select('GROUP_CONCAT(u.user_id) as not_available_user');
            $this->db->where('a.set_date', $delivery_date);
            $this->db->where("(u.device_id IS NOT NULL AND u.device_id != '')");
            $this->db->where('u.status', '1');
            $this->db->where('u.user_type', 'Transporter');
            $this->db->join('transporter_not_available a', 'a.user_id = u.user_id', 'LEFT');
            $not_available = $this->db->get('user u')->row();

            $not_available_user = 0;
            if ($not_available) {
                $not_available_user = $not_available->not_available_user;
            }

            $this->db->select('GROUP_CONCAT(u.user_id) as available_user');
            if ($not_available_user) {
                $this->db->where("u.user_id NOT IN($not_available_user)");
            }
            $this->db->where("(u.device_id IS NOT NULL AND u.device_id != '')");
            $this->db->where('u.status', '1');
            $this->db->where('u.user_type', 'Transporter');
            $this->db->where("u.vehicle_id != 0");
            $this->db->where("v.status", '1');
            $this->db->where("v.vehicle_capacity >= $capacity");
            $this->db->join('vehicle v', 'v.vehicle_id = u.vehicle_id', 'LEFT');
            $available_user_data = $this->db->get('user u')->row();

            $available_user = array();
            if ($available_user_data) {
                $available_user = $available_user_data->available_user;
            }

            $site_lat = $this->getSiteSettingByTitle('latitude');
            $site_lng = $this->getSiteSettingByTitle('longitude');
            $distance_in_km = $this->getSiteSettingByTitle('nearby_pickup_radius');

            if ($available_user) {
                
                $this->db->select("u.device_id, u.user_id, a.station_id, 111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(u.latitude)) 
                * COS(RADIANS('$site_lat')) 
                * COS(RADIANS(u.longitude - '$site_lng')) 
                + SIN(RADIANS(u.latitude)) 
                * SIN(RADIANS('$site_lat'))))) AS distance_in_km");

                $this->db->where("u.user_id IN($available_user)");
                
                $this->db->where('a.order_id', $order_id);
                $this->db->where('a.assign_status', 'New');
                $this->db->where('a.status', 0);
                $this->db->where("(u.device_id IS NOT NULL AND u.device_id != '')");
                $this->db->where('u.status', '1');
                $this->db->where('u.user_type', 'Transporter');
                $this->db->where('u.transporter_available', 1);
                $this->db->order_by('distance_in_km', 'asc');
                $this->db->having("distance_in_km < $distance_in_km");

                $data = $this->db->get('assign_orders a, user u')->result();
                
                //Container wise notification
                $result = $this->getContainerWiseCapacity($data, $capacity, $delivery_date, $order_id);
                
                if($result['data']){
                    foreach ($result['data'] as $value) {
                        $this->db->where('user_id', $value->user_id);
                        $this->db->where('order_id', $order_id);
                        $order_notifications = $this->db->get('new_order_notifications')->row();
                        
                        if(!$order_notifications){
                            
                            $date_time = DATETIME;
                            if($result['is_vehicle']){
                                $date_time = date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime(DATETIME)));
                            } 
                                                        
                            $new_order = array();
                            $new_order['user_id'] = $value->user_id;
                            $new_order['distance_in_km'] = $value->distance_in_km;
                            $new_order['order_id'] = $order_id;
                            $new_order['date_time'] = $date_time;
                            $this->db->insert('new_order_notifications', $new_order);
                        }
                    }
                }
                
                $new_order_notifications = $this->getNewOrderNotifications($order_id);
                
                return $new_order_notifications;
            }
            return array();
        }
        return array();
    }
    
    public function send_nearby_notification($order_id, $user_type, $order_status = 'New', $user_id = 0) {
        
        $this->db->select("o.*");
        $this->db->where('o.id', $order_id);
        $this->db->where('o.is_order', 1);
        if ($order_status == 'New') {
            $this->db->where('o.order_status', 'New');
            //$this->db->where('o.time_left_to_accept > NOW()');
        } else {

            if ($order_status == 'Reach' || $order_status == 'Loaded') {
                $this->db->where('o.order_status', 'Processing');
            } else {
                $this->db->where('o.order_status', $order_status);
            }
        }
        $order = $this->db->get('cart_orders o')->row();

        $is_new = 'true';
        $devices = array();
        if ($order_status == 'New') {
            $is_new = 'false';
            $devices = $this->getNearbyOrders($order_id);
            
            $title = 'New Order';
            $message = 'New Order Placed : ' . ($order ? $order->order_id : '');
            
            if(!$devices){
                $notification_arr = array();
                $notification_arr['user_id'] = 1;
                $notification_arr['title'] = $title;
                $notification_arr['message'] = $message;
                $notification_arr['is_admin'] = 1;
                $notification_arr['date_time'] = DATETIME;
                $this->db->insert('notifications', $notification_arr);
            }
            
        } else {

            $this->db->select("device_id, user_id");
            $this->db->where("(device_id IS NOT NULL AND device_id != '')");
            $this->db->where('status', '1');
            $this->db->where('user_id', $user_id);
            $this->db->where('user_type', $user_type);
            $devices = $this->db->get('user')->result();

            $title = "$order_status Order";
            $message = "Order $order_status : " . ($order ? $order->order_id : '');
            if ($order_status == 'Reach') {
                $message = 'Transporter reached depot Order : ' . ($order ? $order->order_id : '');
            }
            if ($order_status == 'Loaded') {
                $message = 'Transporter collected fuel Order : ' . ($order ? $order->order_id : '');
            }
        }

        $send_notification = 0;
        $notification_data = array();
        if ($devices) {
            //$a_ids = [];
            foreach ($devices as $item) {
                //$a_ids[] = $item->device_id;

                $data = array(
                    //"to" => implode(',', $a_ids),
                    "to" => $item->device_id,
                    "notification" => array(
                        "title" => $title,
                        "body" => $message,
                        'image' => SITE_LOGO,
                        'sound' => 'notification_sound',
                        'vibrate' => 1
                    ),
                    "data" => [
                        "title" => $title,
                        "message" => $message,
                        "order_id" => $order_id,
                        "order_type" => $is_new,
                    ]
                );

                $send_notification = $this->send_push_notification($data);

                $notification_arr = array();
                $notification_arr['user_id'] = $item->user_id;
                $notification_arr['title'] = $title;
                $notification_arr['message'] = $message;
                $notification_arr['date_time'] = DATETIME;
                $notification_data[] = $notification_arr;
            }

            if ($send_notification && $notification_data) {
                return $this->db->insert_batch('notifications', $notification_data);
            }
        }
    }

    function pagination() {
        $config['full_tag_open'] = '<ul class ="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '«';
        $config['first_tag_open'] = '<li class="page-item page-link">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '»';
        $config['last_tag_open'] = '<li class="page-item page-link">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="page-item page-link">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="page-item page-link">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item page-number">';
        $config['num_tag_close'] = '</li>';
        return $config;
    }

    function checkServiceAvailable($latitude, $longitude) {

        $site_lat = $this->getSiteSettingByTitle('latitude');
        $site_lng = $this->getSiteSettingByTitle('longitude');
        $distance_in_km = $this->getSiteSettingByTitle('service_available_radius');

        $distance = $this->db->query("SELECT 111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS('$latitude')) 
        * COS(RADIANS('$site_lat')) 
        * COS(RADIANS('$longitude' - '$site_lng')) 
        + SIN(RADIANS('$latitude')) 
        * SIN(RADIANS('$site_lat'))))) AS distance_in_km")->row();

        return $distance && $distance->distance_in_km && $distance->distance_in_km < $distance_in_km ? true : false;
    }

    public function jsonToTable($data) {
        $table = '
        <table class="table table-responsive table-bordered">
        ';
        foreach ($data as $key => $value):
            $table .= '
            <tr valign="top">
            ';
            if (!is_numeric($key)):
                $table .= '
                <td>
                    <strong>' . $key . ':</strong>
                </td>
                <td>
                ';
            else:
                $table .= '
                <td colspan="2">
                ';
            endif;
            if (is_object($value) || is_array($value)):
                $table .= $this->jsonToTable($value);
            else:
                $table .= $value;
            endif;
            $table .= '
                </td>
            </tr>
            ';
        endforeach;
        $table .= '
        </table>
        ';
        return $table;
    }

    function check_transaction_status() {

        $payment_gateway = $this->getSettings('payment_gateway_setting');
        if ($payment_gateway) {
            foreach ($payment_gateway as $setting) {
                if ($setting->title == 'test_pg_url') {
                    $this->test_url = $setting->value;
                }
                if ($setting->title == 'live_pg_url') {
                    $this->live_url = $setting->value;
                }
                if ($setting->title == 'client_email') {
                    $this->client_email = $setting->value;
                }
                if ($setting->title == 'pg_client_key') {
                    $this->client_key = $setting->value;
                }
                if ($setting->title == 'pg_checksum_key') {
                    $this->checksum_key = $setting->value;
                }
            }
        }

        //Get Access Token
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->test_url . '/token',
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

        //Check Order Payment and update order status
        $today = $from_date = date('Y-m-d');
        $to_date = date('Y-m-d', strtotime("-1 days"));

        //$this->db->where("DATE_FORMAT(t.payment_date, '%Y-%m-%d') <= '$from_date'");
        //$this->db->where("DATE_FORMAT(t.payment_date, '%Y-%m-%d') >= '$to_date'");
        $this->db->where("DATE_FORMAT(t.payment_date, '%Y-%m-%d') = '$today'");
        $this->db->where('t.is_invoice', 0);
        $this->db->where('t.payment_type', 'Purchase');
        $this->db->where('t.payment_status', 'Pending');
        $this->db->where('o.is_order', 1);
        $this->db->join('cart_orders o', 'o.id = t.order_id', 'inner');
        $transactions = $this->db->get('transaction t')->result();
        if ($transactions) {

            foreach ($transactions as $transaction) {

                $transaction_id = $transaction->transaction_id;

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $this->test_url . '/api/Transactions/TranStatus/' . $transaction_id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $access_token
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $status = 'Pending';
                if ($response && $result = json_decode($response)) {
                    $status = $result->Status;
                    if ($result->Status == 'Completed') {
                        $data = array();
                        $data['receipt_no'] = $result->TranID;
                        $data['payment_info'] = $response;
                        $data['payment_status'] = 'Paid';

                        $this->db->where('transaction_id', $transaction_id);
                        $this->db->update('transaction', $data);

                        if ($transaction->order_id == 0) {

                            //Online Wallet Payment
                            $this->updateWallet($transaction->user_id);
                        }
                    } else {

                        if ($result->Status != 'Pending') {
                            $data = array();
                            $data['payment_info'] = $response;
                            $data['payment_status'] = $status;
                            $this->db->where('transaction_id', $transaction_id);
                            $this->db->update('transaction', $data);
                        }
                    }
                }
            }
        }
    }

    public function send_ticket_notification($help_id) {

        $this->db->where('id', $help_id);
        $ticket = $this->db->get('help_ticket')->row();

        $devices = array();
        if ($ticket) {
            $this->db->select("device_id, user_id");
            $this->db->where("(device_id IS NOT NULL AND device_id != '')");
            $this->db->where('status', '1');
            $this->db->where('user_id', $ticket->user_id);
            $devices = $this->db->get('user')->row();

            $title = 'Ticket ' . ($ticket->status ? "Resolved" : "Raised");
            $message = "Ticket Number : " . $ticket->ticket_id;

            if ($devices) {

                $data = array(
                    "to" => $devices->device_id,
                    "notification" => array(
                        "title" => $title,
                        "body" => $message,
                        'image' => SITE_LOGO,
                        'sound' => 'notification_sound',
                        'vibrate' => 1
                    ),
                    "data" => [
                        "title" => $title,
                        "message" => $message,
                        "order_id" => $help_id,
                    ]
                );

                $this->send_push_notification($data);

                $notification_arr = array();
                $notification_arr['user_id'] = $devices->user_id;
                $notification_arr['title'] = $title;
                $notification_arr['message'] = $message;
                $notification_arr['date_time'] = DATETIME;

                return $this->db->insert('notifications', $notification_arr);
            }
        }
        return false;
    }

    public function send_feedback_notification($feedback_id) {

        $this->db->where('id', $feedback_id);
        $feedback = $this->db->get('feedback')->row();

        $devices = array();
        if ($feedback) {
            $this->db->select("device_id, user_id");
            $this->db->where("(device_id IS NOT NULL AND device_id != '')");
            $this->db->where('status', '1');
            $this->db->where('user_id', $feedback->user_id);
            $devices = $this->db->get('user')->row();

            $title = 'Feedback';
            $message = "Feedback Rating : " . $feedback->rating . ' star ' . $feedback->quick_feedback . '\n';
            $message .= $feedback->description;

            if ($devices) {

                $data = array(
                    "to" => $devices->device_id,
                    "notification" => array(
                        "title" => $title,
                        "body" => $message,
                        'image' => SITE_LOGO,
                        'sound' => 'notification_sound',
                        'vibrate' => 1
                    ),
                    "data" => [
                        "title" => $title,
                        "message" => $message,
                        "order_id" => $feedback_id,
                    ]
                );

                $this->send_push_notification($data);

                $notification_arr = array();
                $notification_arr['user_id'] = $devices->user_id;
                $notification_arr['title'] = $title;
                $notification_arr['message'] = $message;
                $notification_arr['date_time'] = DATETIME;

                return $this->db->insert('notifications', $notification_arr);
            }
        }
        return false;
    }

    function getTransporterRating($user_id) {
        $this->db->select('SUM(o.rating) as total_rating, COUNT(o.id) as total_order, t.name as transporter_name, t.mobile as transporter_mobile');
        $this->db->where('o.transporter_id', $user_id);
        $this->db->where('o.rating != ', 0);
        $this->db->join('user t', 't.user_id = o.transporter_id', 'LEFT');
        $this->db->group_by('o.transporter_id');
        $data = $this->db->get('cart_orders o')->row();

        $rating = 0;
        if ($data) {
            $rating = round($data->total_rating / $data->total_order);
        }
        return (string) $rating;
    }

    function getTransporterAvailability($user_id, $date = '') {
        if ($date == '') {
            $date = date('Y-m-d');
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('set_date', $date);
        $data = $this->db->get('transporter_not_available')->row();

        $available = 1;
        if ($data) {
            $available = 0;
        }
        return $available;
    }

    public function sendOrderMessage($order_id, $user_id) {

        if ($order = $this->db->get_where('cart_orders', ['id' => $order_id])->row()) {

            $order_no = $order->order_id;
            
            $this->db->where('status', '1');
            $this->db->where('user_id', $user_id);
            $user = $this->db->get('user')->row();
            
            $mobile = $user ? $user->mobile : '';
            
            $message = '';
            if($order->order_status == 'Completed'){
                $message = "Order Completed : " . $order_no . ". \n Regards \n " . PROJECT_NAME;
            }
            if($order->order_status == 'Assigned'){
                $message = "Order Assigned : " . $order_no . ". \n Regards \n " . PROJECT_NAME;
            }
            if($order->order_status == 'Cancelled'){
                $message = "Order Cancelled : " . $order_no . ". Amount will be credited in your wallet. \n Regards \n " . PROJECT_NAME;
            }
            send_message($message, $mobile);
        }
    }

    function getAllNotifications($limit = 0) {
        $this->db->where('n.is_custom', '0');
        if($limit){
            $this->db->group_by('n.date_time');
            $this->db->limit($limit);
        }else{
            $this->db->join('user u', 'u.user_id = n.user_id', 'inner');
            $this->db->select('n.*, u.name, u.mobile');
        }
        $this->db->order_by('n.date_time', 'desc');
        return $this->db->get('notifications n')->result();
    } 
    
    function getUnreadAdmnNotifications() { 
        $this->db->where('is_custom', '0');
        $this->db->where('admin_read', '0');
        $this->db->order_by('date_time', 'desc');
        return $this->db->get('notifications')->num_rows();
    }
    
    function getTransporterNotifications($admin_id) {
        $this->db->where('user_id', $admin_id);
        $this->db->where('is_admin', '1');
        $this->db->where('is_custom', '0');
        $this->db->order_by('date_time', 'desc');
        return $this->db->get('notifications')->result();
    }
    
    function getAdminNotifications($admin_id) {
        $this->db->select('n.*, u.name, u.mobile');
        $this->db->where('n.is_admin', $admin_id);
        $this->db->where('n.is_custom', '1');
        $this->db->join('user u', 'u.user_id = n.user_id', 'inner');
        $this->db->order_by('n.date_time', 'desc');
        return $this->db->get('notifications n')->result();
    }
    
    function check_delete_data($related_table, $where_related) {
        
        $this->db->where($where_related);
        return $this->db->get($related_table)->row();
    }
    
    function getShippingCharge($station_id, $shipping_charge = 0) {
        $site_lat = $this->common_model->getSiteSettingByTitle('latitude');
        $site_lng = $this->common_model->getSiteSettingByTitle('longitude');

        $this->db->select("111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(latitude)) 
        * COS(RADIANS('$site_lat')) 
        * COS(RADIANS(longitude - '$site_lng')) 
        + SIN(RADIANS(latitude)) 
        * SIN(RADIANS('$site_lat'))))) AS distance_in_km");

        $this->db->where('station_id', $station_id);
        $this->db->where('status', 1);
        $distance = $this->db->get('station')->row();
        
        $shipping_rate = $shipping_charge;
        if($distance && $shipping_charge){
            $shipping_rate = round($distance->distance_in_km * $shipping_charge);
        }
        return $shipping_rate;
    }
    
    function getContainerWiseCapacity($data, $capacity, $delivery_date, $order_id) {
        //echo '<pre>';
        $result = array();
        $is_vehicle = 0;
        if($data){
            
            $distance_in_km = $this->getSiteSettingByTitle('nearby_pickup_radius');
            foreach ($data as $row) {
                
                $station = $this->db->where('station_id', $row->station_id)->where('status', 1)->get('station')->row();
                $latitude = $station ? $station->latitude : 0;
                $longitude = $station ? $station->longitude : 0;
                                
                /*$this->db->group_start();
                $this->db->where("a.assign_status = 'Pending'");
                $this->db->or_where("a.assign_status = 'Accept'");
                $this->db->group_end();*/

                $this->db->where("a.assign_status = 'Accept'");
                $this->db->where('a.transporter_id', $row->user_id);
                $this->db->group_by('a.transporter_id');
                $this->db->order_by('a.assign_datetime', 'asc');
                $assign_orders = $this->db->get('assign_orders a')->result();
                if($assign_orders){
                    
                    /*echo '<pre>Assign Orders';
                    print_r($assign_orders);*/
                    
                    foreach ($assign_orders as $assign_order) {

                        $compartment_no = array();
                        //$used_vehicle_capacity = 0;                            
                        
                        $this->db->where('is_order', 1);
                        $this->db->where("order_status IN('Assigned','Accepted','Processing')");
                        $this->db->where('transporter_id', $assign_order->transporter_id);
                        $this->db->where('delivery_date', $delivery_date);
                        $orders = $this->db->get('cart_orders')->result();
                        if ($orders) {

                            /*echo '<pre>Orders';
                            print_r($orders);*/
                            foreach ($orders as $order) {

                                $compartments_details = array();
                                $compartments_detail = $this->db->where('cart_order_id', $order->id)->where("(compartment_data != '' OR compartment_data IS NOT NULL)")->get('cart_order_details')->result();
                                if($compartments_detail){
                                    foreach ($compartments_detail as $compartments) {
                                        if($compartments->compartment_data && $compartment_data = json_decode($compartments->compartment_data)){
                                            
                                            foreach ($compartment_data as $compartment) {
                                                $compartments_details[] = $compartment->compartment_no;                                                
                                            }
                                        }
                                    }
                                }
                                
                                if($compartments_details){
                                    $compartment_no = $compartments_details;
                                    /*foreach ($compartments_detail as $compartment) {
                                        $compartment_no[] = $compartment->compartment_no;
                                        //$used_vehicle_capacity += $compartment->compartment_capacity;
                                    }*/
                                }else{

                                    if ($order_detail = $this->db->select('SUM(qty) as total_qty')->where('cart_order_id', $order->id)->get('cart_order_details')->row()) {
                                        $order_capacity = $order_detail->total_qty;

                                        if($vehicles = $this->db->where('user_id', $assign_order->transporter_id)->get('vehicle')->row()){
                                            if($vehicle_details = $this->db->where('vehicle_id', $vehicles->vehicle_id)->order_by('compartment_no', 'asc')->get('vehicle_detail')->result()){

                                                $check_capacity = $order_capacity;
                                                foreach ($vehicle_details as $details) {

                                                    if($check_capacity > 0){
                                                        /*if($check_capacity > $details->compartment_capacity){
                                                            $check_capacity = $check_capacity - $details->compartment_capacity;
                                                        }else{
                                                            $check_capacity = $check_capacity - $details->compartment_capacity;
                                                        }*/
                                                        $check_capacity = $check_capacity - $details->compartment_capacity;

                                                        $compartment_no[] = $details->compartment_no;
                                                        //$used_vehicle_capacity += $details->compartment_capacity;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
 
                        /*echo '<pre>compartment_no';
                        print_r($compartment_no);*/
                        $remaining_vehicle_capacity = 0;
                        if($vehicle = $this->db->where('user_id', $assign_order->transporter_id)->get('vehicle')->row()){

                            if($compartment_no){
                                $compartment_no = array_unique($compartment_no);
                                $compartment_no_arr = implode(',', $compartment_no); 
                                $this->db->where("compartment_no NOT IN($compartment_no_arr)");
                            }
                            $this->db->where('vehicle_id', $vehicle->vehicle_id);
                            $vehicle_detail = $this->db->get('vehicle_detail')->result();
                            if($vehicle_detail){

                                foreach ($vehicle_detail as $detail) {
                                    $remaining_vehicle_capacity += $detail->compartment_capacity;
                                }
                            }
                        }
                        /*
                        echo '<pre>capacity';
                        print_r($used_vehicle_capacity);
                        print_r($remaining_vehicle_capacity);
                        print_r($capacity);*/
                        
                        if($remaining_vehicle_capacity && $capacity && $remaining_vehicle_capacity >= $capacity){
                            
                            if($station){
                            
                                $this->db->select("111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(latitude)) 
                                * COS(RADIANS('$latitude')) 
                                * COS(RADIANS(longitude - '$longitude')) 
                                + SIN(RADIANS(latitude)) 
                                * SIN(RADIANS('$latitude'))))) AS distance_in_km");
                                
                                $this->db->where('station_id', $assign_order->station_id);
                                $this->db->where('status', 1);
                                $this->db->having("distance_in_km < $distance_in_km");
                                $station_order = $this->db->get('station')->row();
                                if($station_order){
                                    $nearby_station = round($station_order->distance_in_km);
                                    
                                    if($nearby_station){ 
                                                    
                                        $new_order = array();
                                        $new_order['user_id'] = $assign_order->transporter_id;
                                        $new_order['distance_in_km'] = $nearby_station;
                                        $new_order['order_id'] = $order_id;
                                        $new_order['date_time'] = DATETIME;
                                        $this->db->insert('new_order_notifications', $new_order);
                                        $is_vehicle = 1;
                                    }
                                }
                            }

                            $result[] = $row;
                        }
                    }
                }
            }
        }
        /*echo '<pre>record';
        print_r($result);die;*/
        return array('is_vehicle' => $is_vehicle, 'data' => $result);
    }
    
    function getNewOrderNotifications($order_id = 0) {
        
        $today = DATETIME;
        if($order_id){
            $this->db->where('n.order_id', $order_id);
        }
        $this->db->select("n.id, u.device_id, u.user_id");
        $this->db->where("(u.device_id IS NOT NULL AND u.device_id != '')");
        $this->db->where('u.status', '1');
        $this->db->where('u.user_type', 'Transporter');
        $this->db->where('u.transporter_available', 1);
        $this->db->where('n.is_sent', 0);
        $this->db->where("DATE_ADD(n.date_time, INTERVAL -1 MINUTE) < '$today'");
        $this->db->where("DATE_ADD(n.date_time, INTERVAL +1 MINUTE) > '$today'");
        $this->db->join('user u', 'u.user_id = n.user_id', 'left');
        $this->db->order_by('n.distance_in_km', 'asc');
        $new_order_notifications = $this->db->get('new_order_notifications n')->result();

        if($new_order_notifications){
            foreach ($new_order_notifications as $row) {

                $this->db->where('id', $row->id);
                $this->db->update('new_order_notifications', array('is_sent' => 1));
            }
        }
        
        return $new_order_notifications;
    }
    
    function sendNewOrderNotifications() {
        
        $today = DATETIME;
        $this->db->where("DATE_ADD(date_time, INTERVAL -1 MINUTE) < '$today'");
        $this->db->where("DATE_ADD(date_time, INTERVAL +1 MINUTE) > '$today'");
        $this->db->where('is_sent', 0);
        $this->db->order_by('date_time', 'asc');
        $this->db->order_by('distance_in_km', 'asc');
        $order_notifications = $this->db->get('new_order_notifications')->result();
        
        //echo '<pre>';print_r($order_notifications);die;
        $notification_arr = array();
        if($order_notifications){
            foreach ($order_notifications as $notification) {
                
                $order_id = $notification->order_id;
                
                $this->db->where('order_id', $order_id);
                $this->db->where('assign_status', 'Accept');
                $assign_order = $this->db->get('assign_orders')->row();
                
                if(!$assign_order){
                    
                    $this->db->select("o.*");
                    $this->db->where('o.id', $order_id);
                    $this->db->where('o.is_order', 1);
                    $this->db->where("(o.order_status = 'New' || o.order_status = 'Pending')");
                    $order = $this->db->get('cart_orders o')->row();

                    if($order){
                    
                        $this->db->select("device_id, user_id");
                        $this->db->where("(device_id IS NOT NULL AND device_id != '')");
                        $this->db->where('status', '1');
                        $this->db->where('user_id', $notification->user_id);
                        $this->db->where('user_type', 'Transporter');
                        $devices = $this->db->get('user')->row();

                        $title = 'New Order';
                        $message = 'New Order Placed : ' . $order->order_id;
                    
                        if ($devices) {

                            $data = array(
                                "to" => $devices->device_id,
                                "notification" => array(
                                    "title" => $title,
                                    "body" => $message,
                                    'image' => SITE_LOGO,
                                    'sound' => 'notification_sound',
                                    'vibrate' => 1
                                ),
                                "data" => [
                                    "title" => $title,
                                    "message" => $message,
                                    "order_id" => $order_id,
                                    "order_type" => 'false',
                                ]
                            );

                            $send_notification = $this->send_push_notification($data);

                            if ($send_notification) {
                                
                                $notification_arr = array();
                                $notification_arr['user_id'] = $devices->user_id;
                                $notification_arr['title'] = $title;
                                $notification_arr['message'] = $message;
                                $notification_arr['order_id'] = $order->id;
                                $notification_arr['date_time'] = DATETIME;                            

                                $check_notification = $this->db->where('order_id', $order->id)->where('user_id', $devices->user_id)->get('notifications')->row();
                                if(!$check_notification){
                                    $this->db->insert('notifications', $notification_arr);
                                }
                                
                                $this->db->where('id', $notification->id);
                                $this->db->update('new_order_notifications', array('is_sent' => 1));
                            }
                        }
                    }
                }
            }
        }
        
    }
}
