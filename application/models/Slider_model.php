<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends CI_Model {

    public function addBoardingSlider($data) {
        $this->db->insert('boarding_sliders', $data);
        return $this->db->insert_id();
    }

    public function getAllBoardingSlider() {
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('boarding_sliders')->result();
    }

    public function getBoardingSliderById($id) {
        $this->db->where('slider_id', $id);
        return $this->db->get('boarding_sliders')->row();
    }

    public function updateBoardingSlider($id, $data) {
        $this->db->where('slider_id', $id);
        return $this->db->update('boarding_sliders', $data);
    }

    public function deleteBoardingSlider($id) {
        $slider = $this->getBoardingSliderById($id);
        
        $this->db->where('slider_id', $id);
        $delete = $this->db->delete('boarding_sliders');
        
        if($delete && $slider && $slider->image){
            unlink(BOARDING_SLIDER_IMG . $slider->image);
        }
        return $delete;
    }

}
