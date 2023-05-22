<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function send_message($message = "", $mobile_number, $template_id = null) {

    $CI = get_instance();
    $sms_gateway = $CI->db->where('option_type', 'sms')->get("option_setting")->result();

    $sms_url = $api_key = $sender_id = '';
    if ($sms_gateway) {
        foreach ($sms_gateway as $setting) {
            if ($setting->title == 'sms_url') {
                $sms_url = $setting->value;
            }
            if ($setting->title == 'api_key') {
                $api_key = $setting->value;
            }
            if ($setting->title == 'sender_id') {
                $sender_id = $setting->value;
            }
        }
    }

    $post_data = array();
    $post_data['api_key'] = $api_key;
    $post_data['service_id'] = 0;
    $post_data['mobile'] = $mobile_number;
    $post_data['response_type'] = 'json';
    $post_data['shortcode'] = $sender_id;
    $post_data['message'] = $message;
    
    /*
     '{
        "api_key":"fKLO8d7uUCl1sG234W9Jp6IqoaBQjNP0vXtgkEyxznDRFwmVZSibcAYHMThe5r",
        "service_id":0,
        "mobile":"254719585416",
        "response_type":"json",
        "shortcode":"EQWIPETROL",
        "message":"this is a test message from api dinesh"
      }'
     */
    $post_json = json_encode($post_data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $sms_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_json,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return true;
}
