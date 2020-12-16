<?php

class moment_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_moment(){
    $query = $this->db->get('moments')->result();
    return $query;
  }

  public function get_moment_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('moments')->result();
    return $query;
  }

  public function insert_moment($data){
    $query = $this->db->insert('moments', $data);
    return $query;
  }
}

?>
