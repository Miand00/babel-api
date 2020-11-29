<?php

class guide_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_guide(){
    $query = $this->db->get('guides')->result();
    return $query;
  }

  public function get_guide_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('guides')->result();
    return $query;
  }
}

?>