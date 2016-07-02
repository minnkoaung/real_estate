<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Agents_model extends CI_Model {
public $id;
public $company;
public $company_address;
public $description;
public $profile_photo;
public $content_phone;
public $content_email;
public $user_id;
public $created_at;
public $updated_at;
public $verified;

 public function get_last_ten_agents()
        {
                $query = $this->db->get('agents', 10);
                return $query->result();
        }

        public function create_agents($data){
                $this->db->insert('agents', $data);
        }

        public function update_agents($data,$id){
                $this->db->where('id',$id);
                $update_result = $this->db->update('agents', $data);
                return $update_result;
                
        }

        public function delete_agents($id){
                $this->db->where('id',$id);
                $delete_result = $this->db->delete('agents');
                return $delete_result;

        }      

}



?>