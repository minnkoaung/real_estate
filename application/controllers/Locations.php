<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends CI_Controller { 

    public function __construct(){//overwrite parent contruct
        parent::__construct();
        $this->load->model('Locations_model');
    }

    public function index()
    {
        $query = $this->Locations_model->get_last_ten_locations(); 
        var_dump ($query);       
    }

     public function create_locations() {
        $name = "Warshinton DC,USA";
        $type = "City";
        $parent = 2;
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = 2;
         $requested_data = [
            'name' => $name,
            'type' => $type,
            'parent' => $parent,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->Locations_model->create_locations($requested_data);
    }

     public function update_locations() {
        $id = 1 ;
        $name = "New York";
        $type = "City";
        $parent = 2;
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = 2; 
        $requested_data = [
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'parent' => $parent,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->Locations_model->update_locations($requested_data, $id); 
    }

    public function delete_locations(){
        $id = 3;
        $this->Locations_model->delete_locations($id);
    }  
}   
?>