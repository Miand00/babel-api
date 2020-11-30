<?php

class user_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function check_user($id){
    $this->db->where('google_id', $id);
    $query = $this->db->get('users')->result();
    return $query;
  }

  public function get_user_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('users')->result();
    return $query;
  }

  public function insert_user($data){
    $query = $this->db->insert('users', $data);
    return $query;
  }
}
?>
