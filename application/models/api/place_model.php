<?php

class place_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_place(){
    $query = $this->db->get('places')->result();
    return $query;
  }

  public function get_place_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('places')->result();
    return $query;
  }
}

?>