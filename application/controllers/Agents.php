<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends CI_Controller { 

    public function __construct(){//overwrite parent contruct
        parent::__construct();
        $this->load->model('Agents_model');
    }

    public function index()
    {
        $query = $this->Agents_model->get_last_ten_agents(); 
        var_dump ($query);
       // echo "This is agent controller";
       
    }

     public function create_agents() {
       $company     = "MK Enterpirse";
        $company_address = "Warshinton DC,USA";
        $description = "Some Description";
        $profile_photo = "MyPhoto.jpg";
        $contact_phone = "0998989898";
        $contact_email = "user@zmail.com";
        $user_id = "00001";
        $created_at = date('Y-m-d H:i:s');
        $updated_at = "";
        $verified = "0";
        $this->Agents_model->create_agents([
            'company' => $company,
            'company_address' => $company_address,
            'description' => $description,
            'profile_photo' => $profile_photo,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
            'user_id' => $user_id,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'verified' => $verified
        ]);
    }

    public function update_agents() {
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