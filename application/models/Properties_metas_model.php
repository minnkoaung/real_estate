<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Properties_metas_model extends CI_Model {
public $meta_id;
public $property_id;
public $meta_key;
public $meta_value;
public $updated_at;
public $updated_by;
 public function get_last_ten_property_metas()
        {
                $query = $this->db->get('property_metas', 10);
                return $query->result();
        }

        public function create_property_metas($data){
                $this->db->insert('property_metas', $data);
        }

        public function update_property_metas($data,$meta_id){
                $this->db->where('meta_id',$meta_id);
                $update_result = $this->db->update('property_metas', $data);
                return $update_result;
                
        }

        public function delete_property_metas( $meta_id){
                $this->db->where('meta_id', $meta_id);
                $delete_result = $this->db->delete('property_metas');
                return $delete_result;

        }      

}



?>