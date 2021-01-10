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

  public function get_guide_search($search){
    $query = $this->db->query("SELECT * FROM guides WHERE guides.name LIKE '%".$search."%'");
    return $query->result();
  }
}

?>