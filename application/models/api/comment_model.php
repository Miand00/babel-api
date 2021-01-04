<?php

class comment_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_comment($id){
    $query = $this->db->query("SELECT comments.*,users.name FROM comments, users WHERE comments.user_id = users.id AND comments.place_id=".$id);
    return $query->result();
  }

  public function insert_comment($data){
    $query = $this->db->insert('comments', $data);
    return $query;
  }

  public function update_comment($id, $data){
    $this->db->where('id', $id);
    $query = $this->db->update('comments', $data);
    return $query;
  }

  public function delete_comment($id){
    $this->db->where('id', $id);
    $query = $this->db->delete('comments');
    return $query;
  }
}

?>