<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends CI_Controller { 

	public function __construct(){//overwrite parent contruct
		parent::__construct();
		$this->load->model('Type_model');
	}

    public function create()
	{
        // $data['name'] = "8Minn Ko Aung";
        // $data['parent'] = "Minn Ko Aung";  
        // $data['updated_by'] = "Minn Ko Aung";  
        $this->Type_model->insert_type();
       
    }
}   




?>