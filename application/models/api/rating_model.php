<?php
class rating_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_rating($place_id, $user_id){
    $query = $this->db->query("SELECT * FROM `ratings` WHERE place_id = '".$place_id."' AND user_id = '".$user_id."'");
    return $query->result();
  }

  public function insert_rating($data){
    $query = $this->db->insert('ratings', $data);
    return $query;
  }

  public function update_rating($id, $data){
    $this->db->where('id', $id);
    $query = $this->db->update('ratings', $data);
    return $query;
  }
}
?>
