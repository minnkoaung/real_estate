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
        $id = 6 ;
        $company     = "MK Enterpirse 2";
        $company_address = "Warshinton DC,USA";
        $description = "Some Description2";
        $profile_photo = "MyPhoto.jpg";
        $contact_phone = "0998989898";
        $contact_email = "user@zmail.com";
        $user_id = "00001";
        $created_at = date('Y-m-d H:i:s');
        $updated_at = "";
        $verified = "0";
        $requested_data = [
            'id' => 6,
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
        ];
        $this->Agents_model->update_agents($requested_data,$id); 
    }

    public function delete_agents(){
        $id = 3;
        $this->Agents_model->delete_agents($id);
    }  
}   
?>