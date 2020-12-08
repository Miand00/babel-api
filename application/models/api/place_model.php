<?php

class place_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_place(){
    $query = $this->db->query("SELECT a.*, d.image, CAST(COALESCE((b.totalRating/c.totalUser),0) AS DECIMAL(4, 1)) AS rating FROM places a, ( SELECT place_id, SUM(rating) AS totalRating FROM ratings GROUP BY place_id ) b, ( SELECT place_id, COUNT(user_id) AS totalUser FROM ratings GROUP BY place_id ) c, places_images d WHERE c.place_id = a.id AND b.place_id = a.id AND d.place_id = a.id GROUP BY a.id ORDER BY RAND() LIMIT 20");
    return $query->result();
  }

  public function get_place_id($id){
    $this->db->where('id', $id);
    $query = $this->db->get('places')->result();
    return $query;
  }

  public function get_image($id){
    $query = $this->db->query("SELECT image FROM `".$this->db->dbprefix('places')."` WHERE id='".$id."'");
    return $query;
  }

  public function insert_place($data){
    $query = $this->db->insert('places', $data);
    return $query;
  }

  public function update_place($id, $data){
    $this->db->where('id', $id);
    $query = $this->db->update('places', $data);
    return $query;
  }

  public function delete_place($id){
    $this->db->where('id', $id);
    $query = $this->db->delete('places');
    return $query;
  }
}

?>