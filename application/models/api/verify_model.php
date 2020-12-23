<?php

class verify_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function insert_verifies($data){
    $query = $this->db->insert('verifies', $data);
    return $query;
  }
}

?>
