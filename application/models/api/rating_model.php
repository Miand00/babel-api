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

  public function get_comment($id){
    $query = $this->db->query("SELECT ratings.*,users.name FROM ratings, users WHERE ratings.user_id = users.id AND ratings.comment IS NOT NULL AND ratings.place_id=".$id);
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

  public function insert_comment($data,$id1,$id2){
    $this->db->where('place_id', $id1);
    $this->db->where('user_id', $id2);
    $query = $this->db->update('ratings', $data);
    return $query;
  }

  public function update_comment($id, $data){
    $this->db->where('id', $id);
    $query = $this->db->update('ratings', $data);
    return $query;
  }

  public function delete_data($id){
    $this->db->where('id', $id);
    $query = $this->db->delete('ratings');
    return $query;
  }
}
?>
