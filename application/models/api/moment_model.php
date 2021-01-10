<?php

class moment_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_moment(){
    $query = $this->db->query("SELECT * FROM moments GROUP BY moments.id ORDER BY moments.id DESC LIMIT 20");
    return $query->result();
  }

  public function get_moment_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('moments')->result();
    return $query;
  }

  public function get_image($id){
    $query = $this->db->query("SELECT image FROM `moments` WHERE id ='".$id."'");
    return $query;
  }

  public function get_moment_owned($id){
    $this->db->where('user_id', $id);
    $query = $this->db->get('moments')->result();
    return $query;
  }

  public function get_moment_search($search){
    $query = $this->db->query("SELECT * FROM moments WHERE moments.title LIKE '%".$search."%'");
    return $query->result();
  }

  public function insert_moment($data){
    $query = $this->db->insert('moments', $data);
    return $query;
  }

  public function update_moment($id, $data){
    $this->db->where('id', $id);
    $query = $this->db->update('moments', $data);
    return $query;
  }

  public function delete_moment($id){
    $this->db->where('id', $id);
    $query = $this->db->delete('moments');
    return $query;
  }
}

?>
