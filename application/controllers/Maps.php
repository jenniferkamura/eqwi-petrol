<?php

class Maps extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $google_map_api_key = $this->common_model->getSiteSettingByTitle('google_map_api_key');
        $this->data['google_map_api_key'] = $google_map_api_key;
    }

    function index() {
        $this->load->view("admin/maps/geo_fence", $this->data);
    }

    function view($table, $id) {
        $latitude = '-1.291020';
        $longitude = '36.821390';
        $location_name = $address = '';
        $key = $table . '_id';
        if($location = $this->common_model->getTableById($table, $key, $id)){        
            $latitude = $location->latitude;
            $longitude = $location->longitude;
            if($table == 'station'){
                $location_name = $location->station_name;
            }else{
                $location_name = $location->name;
            }
            $address = $location->address;
        }
        
        $this->data['latitude'] = $latitude;
        $this->data['longitude'] = $longitude;
        $this->data['location_name'] = $location_name;
        $this->data['address'] = $address;
        
        $this->load->view("admin/maps/geo_fence_view", $this->data);
    }

}
