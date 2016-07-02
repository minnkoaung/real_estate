<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations_model extends CI_Model {
public $id;
public $name;
public $type;
public $parent;
public $updated_at;
public $updated_by;

 public function get_last_ten_locations()
        {
                $query = $this->db->get('locations', 10);
                return $query->result();
        }

        public function create_locations($data){
                $this->db->insert('locations', $data);
        }

        public function update_locations($data,$id){
                $this->db->where('id',$id);
                $update_result = $this->db->update('locations', $data);
                return $update_result;
                var_dump($update_result);
                
        }

        public function delete_locations($id){
                $this->db->where('id',$id);
                $delete_result = $this->db->delete('locations');
                return $delete_result;

        }      

}



?>