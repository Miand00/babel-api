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
}

?>