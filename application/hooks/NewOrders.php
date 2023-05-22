<?php

function updateNewOrders() {

    // load the instance
    $CI = & get_instance();

    /* $latitude = $CI->db->get_where('option_setting', ['title' => 'latitude'])->row();
      $site_lat = $latitude ? $latitude->value : '';

      $longitude = $CI->db->get_where('option_setting', ['title' => 'longitude'])->row();
      $site_lng = $longitude ? $longitude->value : ''; */

    $CI->db->select("o.*");
    $CI->db->where('o.is_order', 1);
    $CI->db->where('o.order_status', 'New');
    $CI->db->where('o.time_left_to_accept < NOW()');
    //$CI->db->join('station s', 's.station_id = o.station_id', 'left');

    $new_orders = $CI->db->get('cart_orders o')->result();

    if ($new_orders) {
        foreach ($new_orders as $order) {

            $no_invoice = $CI->db->where('order_id', $order->id)->where('is_invoice', 0)->get('transaction')->row();
            if ($no_invoice) {
                $CI->db->where('id', $order->id);
                $CI->db->update('cart_orders', ['order_status' => 'Pending']);

                //get assign order
                $CI->db->where('order_id', $order->id);
                $CI->db->order_by('id', 'desc');
                $CI->db->limit(1);
                $assign = $CI->db->get('assign_orders')->row();

                if ($assign) {
                    $CI->db->where('id', $assign->id);
                    $CI->db->update('assign_orders', ['assign_status' => 'Pending']);
                }
            }
        }
    }
    return;
}
