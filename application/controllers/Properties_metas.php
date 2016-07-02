<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_metas extends CI_Controller { 

    public function __construct(){//overwrite parent contruct
        parent::__construct();
        $this->load->model('Properties_metas_model');
    }

    public function index()
    {
        $query = $this->Properties_metas_model->get_last_ten_property_metas(); 
        var_dump ($query);       
    }

     public function create_property_metas() {
        $property_id = "00001";
        $meta_key = "Some Description";
        $meta_value = "There is some meta value.";
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = 2;
        $requested_data = [
            'property_id' => $property_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->Properties_metas_model->create_property_metas($requested_data);
    }

     public function update_property_metas() {
        $meta_id     = 2;
        $property_id = "08001";
        $meta_key = "Some Updated Description ";
        $meta_value = "There is some Updated meta value.";
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = "3";
        $requested_data = [
            'meta_id' => 2,
            'property_id' => $property_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->Properties_metas_model->update_property_metas($requested_data,$meta_id); 
    }

    public function delete_property_metas(){
        $meta_id = 3;
        $this->Properties_metas_model->delete_property_metas( $meta_id);
    }  
}   
?>