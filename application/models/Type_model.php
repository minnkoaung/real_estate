<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_model extends CI_Model {
public $id;
public $name;
public $parent;
public $updated_at;
public $updated_by;

 public function get_last_ten_types()
        {
                $query = $this->db->get('types', 10);
                return $query->result();
        }

        public function create_types($data){
                $this->db->insert('types', $data);
        }

        public function update_types($data,$id){
                $this->db->where('id',$id);
                $update_result = $this->db->update('types', $data);
                return $update_result;
                
        }

        public function delete_types($id){
                $this->db->where('id',$id);
                $delete_result = $this->db->delete('types');
                return $delete_result;

        }      

}



?>