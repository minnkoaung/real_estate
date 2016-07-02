<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends CI_Controller { 

	public function __construct(){//overwrite parent contruct
		parent::__construct();
		$this->load->model('Type_model');
	}

    public function index()
	{
        $query = $this->Type_model->get_last_ten_types(); 
        var_dump ($query);
       
    }

    public function create_types() {
        $name = "koko";
        $parent = "Housing";
        $updated_at = "date('Y-m-d H:i:s')";
        $updated_by = "2";
        $this->Type_model->create_types([
            'name' => $name,
            'parent' => $parent,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ]); 
    }

    public function update_types() {
        $id = "7";
        $name = "koko2";
        $parent = "Housing";
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = "2";
        $this->Type_model->update_types([
            'name' => $name,
            'parent' => $parent,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ],$id); 
    }

    public function delete_types(){
        $id = 6;
        $this->Type_model->delete_types($id);
    }   
}   
?>