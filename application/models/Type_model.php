<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_model extends CI_Model {
public $name;
public $parent;
public $updated_at;
public $updated_by;

public function insert_type()
        {
                $this->name    = "Apartment2";
                $this->parent  = "Housing";
                $this->updated_at  = date('Y-m-d H:i:s');
                $this->updated_by  = "Minn Ko";
                $this->db->insert('types', $this);
             
        }

}


?>